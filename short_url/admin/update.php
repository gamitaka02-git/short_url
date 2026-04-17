<?php
// update.php - 更新チェック＆自動アップデートAPI
require_once __DIR__ . '/init.php';

// ログインチェック
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? ($_GET['action'] ?? '');

// ---------------------------------------------------------
// ユーティリティ関数（先に定義）
// ---------------------------------------------------------

/**
 * ディレクトリごとコピーする（再帰処理）
 * $exclude_paths に含まれるファイルは上書きしない
 */
function update_plugin_copy_files($src, $dst, $base_dst) {
    if (!is_dir($src)) {
        return;
    }
    
    // 除外リスト (相対パスで指定)
    $exclude_paths = [
        'admin/database.sqlite',
        'admin/config.php'
    ];

    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            // コピー先パスからツールルートまでの相対パスを生成して除外判定
            $relative_path = ltrim(str_replace($base_dst, '', $dstFile), '/');
            
            if (in_array($relative_path, $exclude_paths)) {
                // 保護対象ファイルはスキップ
                continue;
            }

            if (is_dir($srcFile)) {
                update_plugin_copy_files($srcFile, $dstFile, $base_dst);
            } else {
                if (!copy($srcFile, $dstFile)) {
                    throw new Exception("ファイル {$relative_path} の上書きに失敗しました。");
                }
            }
        }
    }
    closedir($dir);
}

/**
 * ディレクトリごと削除する（再帰処理）
 */
function update_plugin_remove_dir($dir) {
    if (!is_dir($dir)) {
        return;
    }
    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object)) {
                update_plugin_remove_dir($dir . DIRECTORY_SEPARATOR . $object);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
    }
    rmdir($dir);
}

// ---------------------------------------------------------
// アクション処理
// ---------------------------------------------------------

if ($action === 'check') {
    // GitHub Releases APIからリリース一覧を取得（latestはプレリリースが含まれない場合に404を返すため）
    $repo = defined('GITHUB_REPO') ? GITHUB_REPO : 'gamitaka02-git/short_url';
    $url = "https://api.github.com/repos/{$repo}/releases";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ShortUrl-Updater'); // GitHub APIはUser-Agent必須
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // Xserver等での通信エラー回避用
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $data_list = json_decode($response, true);
        if (is_array($data_list) && isset($data_list[0])) {
            $data = $data_list[0]; // 先頭のリリースを使用
            $latest_version = ltrim($data['tag_name'], 'v.'); // v1.0.1 or v.1.0.1 -> 1.0.1
            $current_version = defined('TOOL_VERSION') ? ltrim(TOOL_VERSION, 'v.') : '1.0.0';

            $has_update = version_compare($latest_version, $current_version, '>');

            echo json_encode([
                'success' => true,
                'has_update' => $has_update,
                'current_version' => $current_version,
                'latest_version' => $latest_version,
                'release_notes' => $data['body'] ?? '',
                'published_at' => $data['published_at'] ?? '',
                'download_url' => $data['html_url'] ?? ''
            ]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => "バージョン情報の取得に失敗しました。(HTTP:{$httpCode} / Error:{$curl_error})"]);
    exit;
}

if ($action === 'execute') {
    // 自動アップデートの実行処理
    
    // APIから最新Release情報を再取得してzipのURLを得る
    $repo = defined('GITHUB_REPO') ? GITHUB_REPO : 'gamitaka02-git/short_url';
    $url = "https://api.github.com/repos/{$repo}/releases";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ShortUrl-Updater');
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        echo json_encode(['success' => false, 'message' => 'リリース情報の取得に失敗しました。']);
        exit;
    }

    $data_list = json_decode($response, true);
    if (!is_array($data_list) || !isset($data_list[0])) {
        echo json_encode(['success' => false, 'message' => 'リリース情報が見つかりません。']);
        exit;
    }

    $data = $data_list[0];
    
    $zip_url = '';
    // まずリリースに添付されたZIPアセットを優先して探す
    if (!empty($data['assets'])) {
        foreach ($data['assets'] as $asset) {
            if (substr($asset['name'], -4) === '.zip') {
                $zip_url = $asset['browser_download_url'];
                break;
            }
        }
    }
    // アセットにZIPがなければ、Github自動生成のソースコードZIP(zipball_url)をフォールバックとして使用
    if (empty($zip_url) && !empty($data['zipball_url'])) {
        $zip_url = $data['zipball_url'];
    }

    if (empty($zip_url)) {
        echo json_encode(['success' => false, 'message' => 'ZIPダウンロードURLが見つかりません。']);
        exit;
    }
    $tmp_dir = __DIR__ . '/_tmp_update_' . time();
    $zip_file = $tmp_dir . '/update.zip';

    // 一時ディレクトリ作成
    if (!mkdir($tmp_dir, 0755, true)) {
        echo json_encode(['success' => false, 'message' => '一時ディレクトリの作成に失敗しました。パーミッションを確認してください。']);
        exit;
    }

    // ZIPダウンロード
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $zip_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ShortUrl-Updater');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // GitHubのzipballはリダイレクトされるため必須
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $zip_data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || $zip_data === false) {
        update_plugin_remove_dir($tmp_dir);
        echo json_encode(['success' => false, 'message' => 'アップデートファイルのダウンロードに失敗しました。' . $error]);
        exit;
    }

    file_put_contents($zip_file, $zip_data);

    // ZIP展開
    $zip = new ZipArchive;
    if ($zip->open($zip_file) === true) {
        $extract_dir = $tmp_dir . '/extracted';
        mkdir($extract_dir, 0755, true);
        $zip->extractTo($extract_dir);
        $zip->close();
    } else {
        update_plugin_remove_dir($tmp_dir);
        echo json_encode(['success' => false, 'message' => 'ZIPファイルの展開に失敗しました。']);
        exit;
    }

    // どういう形式のZIPが解凍されたかを自動判定する
    $extracted_root = '';
    
    // 展開先ディレクトリ内を再帰的に探索して 'admin/init.php' があるディレクトリを探す
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($extract_dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isDir()) {
            if (file_exists($fileinfo->getPathname() . '/admin/init.php')) {
                // 見つかったディレクトリがツール本体のルートディレクトリ
                $extracted_root = $fileinfo->getPathname();
                break;
            }
        }
    }
    
    // 直下にadminディレクトリがあるかどうかもチェック
    if (empty($extracted_root) && file_exists($extract_dir . '/admin/init.php')) {
        $extracted_root = $extract_dir;
    }

    if (empty($extracted_root) || !is_dir($extracted_root)) {
        update_plugin_remove_dir($tmp_dir);
        echo json_encode(['success' => false, 'message' => 'アップデートファイル内に必要なデータ(admin/init.php)が見つかりませんでした。']);
        exit;
    }

    // 更新対象ディレクトリ（ツールのルートディレクトリ）
    $target_dir = dirname(__DIR__); // __DIR__ は admin。その親が short_url

    // ファイルの上書き実行 (保護するファイルを除外)
    try {
        update_plugin_copy_files($extracted_root, $target_dir, $target_dir);
        $success = true;
    } catch (Exception $e) {
        $success = false;
        $error_msg = $e->getMessage();
    }

    // 後始末
    update_plugin_remove_dir($tmp_dir);

    if (isset($success) && $success) {
        echo json_encode([
            'success' => true,
            'message' => 'アップデートが正常に完了しました。最新バージョンに更新されました。'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ファイルの上書きに失敗しました。権限を確認してください。エラー詳細: ' . (isset($error_msg) ? $error_msg : '')
        ]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
exit;
