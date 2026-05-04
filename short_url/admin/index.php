<?php
// セットアップチェックとセッション開始
require_once __DIR__ . '/init.php';

// ログインチェック (init.php でセッションは開始済み)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// ログアウト処理
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

// --- ライセンス認証 ---

global $pdo; // init.php で定義された $pdo を使用

// ライセンスキーがPOSTされたら保存
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_key_update'])) {
    $new_license_key = trim($_POST['license_key']);

    // configテーブルにlicense_keyがあるか確認
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM config WHERE key = 'license_key'");
    $stmt->execute();
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE config SET value = :value WHERE key = 'license_key'");
    } else {
        $stmt = $pdo->prepare("INSERT INTO config (key, value) VALUES ('license_key', :value)");
    }
    $stmt->execute([':value' => encrypt_data($new_license_key)]);
    
    // 更新後はセッションの認証フラグをリセット
    unset($_SESSION['license_verified']);
    
    // ページを再読み込みしてGETリクエストに戻す
    header('Location: index.php');
    exit;
}

// DBからライセンスキーを取得
try {
    $stmt = $pdo->prepare("SELECT value FROM config WHERE key = 'license_key'");
    $stmt->execute();
    $license_key = $stmt->fetchColumn();
    if ($license_key === false) {
        $license_key = '';
    } else {
        $license_key = decrypt_data($license_key);
    }
} catch (Exception $e) {
    $license_key = '';
}


// ライセンスキーが空、または認証失敗の場合
if (empty($license_key) || !check_license($license_key)) {
    // 認証失敗時のUIを表示して終了
    ?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ライセンス認証</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md border-t-4 border-red-600">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">ライセンス認証が必要です</h1>
            <p class="text-center text-gray-600 mb-6">このツールを使用するには、有効なライセンスキーを入力して認証を行ってください。</p>
            
            <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($license_key)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">認証エラー</p>
                    <p>入力されたライセンスキーは無効か、有効期限が切れています。ご確認ください。</p>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php">
                <input type="hidden" name="license_key_update" value="1">
                <div class="mb-4">
                    <label for="license_key" class="block text-sm font-medium text-gray-700 mb-2">ライセンスキー</label>
                    <input type="text" id="license_key" name="license_key" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required>
                </div>
                <button type="submit" class="w-full bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition shadow">認証する</button>
            </form>
            <p class="text-xs text-gray-500 text-center mt-4">ライセンスキーをお持ちでない場合は、提供元にお問い合わせください。</p>
        </div>
    </body>
    </html>
    <?php
    exit; // ここでスクリプトの実行を停止
}

// --- ライセンス認証ここまで ---


// REST (Fetch API) の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $url = $_POST['url'] ?? '';
        $keyword = $_POST['keyword'] ?? '';

        if (empty($url)) {
            echo json_encode(['success' => false, 'message' => 'URLを入力してください。']);
            exit;
        }

        // スラッグ未入力なら8文字のランダム文字列
        if (empty($keyword)) {
            $keyword = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
        }

        // 重複チェック
        $check = $pdo->prepare("SELECT count(*) FROM urls WHERE keyword = :keyword");
        $check->execute([':keyword' => $keyword]);
        if ($check->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'このスラッグは既に存在します。別のものを指定してください。']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO urls (keyword, original_url, created_at, updated_at) VALUES (:keyword, :url, DATETIME('now', 'localtime'), DATETIME('now', 'localtime'))");
        $res = $stmt->execute([':keyword' => $keyword, ':url' => $url]);

        echo json_encode(['success' => $res]);
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $url = $_POST['url'] ?? '';

        if (empty($id) || empty($url)) {
            echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE urls SET original_url = :url, updated_at = DATETIME('now', 'localtime') WHERE id = :id");
        $res = $stmt->execute([':url' => $url, ':id' => $id]);
        echo json_encode(['success' => $res]);
        exit;
    }

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM urls WHERE id = :id");
        $res = $stmt->execute([':id' => $id]);
        echo json_encode(['success' => $res]);
        exit;
    }

    if ($action === 'reset_clicks') {
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
            exit;
        }

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE urls SET click_count = 0 WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $stmt = $pdo->prepare("DELETE FROM click_logs WHERE url_id = :id");
            $stmt->execute([':id' => $id]);

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'リセットに失敗しました。']);
        }
        exit;
    }

    if ($action === 'click_logs') {
        $url_id = $_POST['url_id'] ?? '';

        if (empty($url_id)) {
            echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
            exit;
        }

        // URL情報を取得
        $urlStmt = $pdo->prepare("SELECT keyword, click_count FROM urls WHERE id = :id LIMIT 1");
        $urlStmt->execute([':id' => $url_id]);
        $urlInfo = $urlStmt->fetch(PDO::FETCH_ASSOC);

        if (!$urlInfo) {
            echo json_encode(['success' => false, 'message' => '該当するURLが見つかりません。']);
            exit;
        }

        // クリックログを取得（新しい順）
        $logStmt = $pdo->prepare("SELECT id, clicked_at, referer FROM click_logs WHERE url_id = :url_id ORDER BY clicked_at DESC");
        $logStmt->execute([':url_id' => $url_id]);
        $logs = $logStmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'keyword' => $urlInfo['keyword'],
            'click_count' => $urlInfo['click_count'],
            'logs' => $logs
        ]);
        exit;
    }

    if ($action === 'password') {
        $newPassword = $_POST['new_password'] ?? '';

        if (empty($newPassword) || strlen($newPassword) < 4) {
            echo json_encode(['success' => false, 'message' => 'パスワードは4文字以上で入力してください。']);
            exit;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE config SET value = :hash WHERE key = 'admin_password'");
        $res = $stmt->execute([':hash' => $hashed]);

        if ($res) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'パスワードの更新に失敗しました。']);
        }
        exit;
    }

    exit;
}

// ページネーション設定
$page = isset($_GET['p']) ? (int) $_GET['p'] : 1;
if ($page < 1)
    $page = 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$totalStmt = $pdo->query("SELECT count(*) FROM urls");
$total = $totalStmt->fetchColumn();
$totalPages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM urls ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 現在のプロトコルとURL基準のプレフィックス計算
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
// adminディレクトリの一つ上の階層をルートプレフィックスと想定します
$dirStr = dirname(dirname($_SERVER['SCRIPT_NAME']));
$dirStr = rtrim($dirStr, '/\\') . '/';
$fullBaseUrl = $protocol . $domain . $dirStr;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short URL｜短縮URL生成ツール</title>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- カスタムスタイル -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100 text-gray-800 font-sans p-4 md:p-8">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">Short URL｜短縮URL生成ツール</h1>
            <div class="flex gap-2">
                <button type="button" id="openSettingsModalBtn"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded transition text-sm font-bold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    設定
                    <span id="updateBadge" class="hidden flex h-3 w-3 relative ml-1">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </button>
                <a href="index.php?action=logout"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded transition text-sm font-bold">ログアウト</a>
            </div>
        </div>

        <!-- 生成フォーム -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 border-t-4 border-blue-600">
            <form id="createForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">転送先URL (Original URL) *</label>
                    <input type="url" name="url" required placeholder="https://example.com/long-url..."
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">カスタムスラッグ (省略時は8桁自動生成)</label>
                    <div
                        class="flex items-stretch border rounded-md focus-within:ring-2 focus-within:ring-blue-500 overflow-hidden">
                        <span class="bg-gray-200 px-3 py-2 text-gray-500 text-sm flex items-center border-r"
                            id="baseUrlPrefix">
                            <?= htmlspecialchars($fullBaseUrl) ?>
                        </span>
                        <input type="text" name="keyword" placeholder="my-custom-link" pattern="[a-zA-Z0-9_-]+"
                            title="英数字、ハイフン、アンダースコアのみ使用可能"
                            class="w-full px-4 py-2 border-none focus:ring-0 focus:outline-none">
                    </div>
                </div>
                <div id="createMessage" class="hidden text-sm"></div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition shadow">生成する</button>
            </form>
        </div>

        <!-- 一覧エリア -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">生成済みURL一覧 (全 <?= $total ?> 件)</h2>

            <div class="space-y-4">
                <?php if (empty($items)): ?>
                    <p class="text-gray-500 text-center py-8 bg-gray-50 rounded">まだ短縮URLがありません。</p>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                        <div
                            class="border rounded p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-gray-50 transition border-gray-200">
                            <div class="overflow-hidden w-full md:w-2/3">
                                <div class="flex items-center gap-2 mb-1">
                                    <button type="button" class="click-log-btn px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded cursor-pointer hover:bg-green-200 transition"
                                        data-id="<?= $item['id'] ?>" data-keyword="<?= htmlspecialchars($item['keyword']) ?>"
                                        title="クリック解析を表示">📊 クリック:
                                        <?= htmlspecialchars($item['click_count']) ?></button>
                                    <span class="text-xs text-gray-400"><?= htmlspecialchars($item['created_at']) ?></span>
                                </div>
                                <p class="text-sm text-gray-600 truncate mb-1"
                                    title="<?= htmlspecialchars($item['original_url']) ?>">
                                    転送先: <?= htmlspecialchars($item['original_url']) ?>
                                </p>

                                <div class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded">
                                    <a href="<?= htmlspecialchars($fullBaseUrl . $item['keyword']) ?>" target="_blank"
                                        class="text-blue-600 font-medium hover:underline break-all truncate w-full">
                                        <?= htmlspecialchars($fullBaseUrl . $item['keyword']) ?>
                                    </a>
                                    <button type="button"
                                        class="copy-btn whitespace-nowrap text-xs bg-gray-300 hover:bg-gray-400 px-2 py-1 rounded text-gray-800 font-medium"
                                        data-url="<?= htmlspecialchars($fullBaseUrl . $item['keyword']) ?>">
                                        コピー
                                    </button>
                                </div>
                            </div>
                            <div class="w-full md:w-auto flex flex-wrap gap-2 mt-2 md:mt-0">
                                <button type="button"
                                    class="reset-btn text-xs bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded shadow w-full md:w-auto font-bold"
                                    data-id="<?= $item['id'] ?>" data-keyword="<?= htmlspecialchars($item['keyword']) ?>" title="クリック数とログをリセット">
                                    リセット
                                </button>
                                <button type="button"
                                    class="delete-btn text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded shadow w-full md:w-auto font-bold"
                                    data-id="<?= $item['id'] ?>" data-keyword="<?= htmlspecialchars($item['keyword']) ?>">
                                    削除
                                </button>
                                <button type="button"
                                    class="edit-btn text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded shadow w-full md:w-auto font-bold"
                                    data-id="<?= $item['id'] ?>" data-url="<?= htmlspecialchars($item['original_url']) ?>">
                                    編集
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- ページネーション -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-8 gap-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?p=<?= $i ?>"
                            class="px-3 py-1 border rounded <?= $i === $page ? 'bg-blue-600 text-white font-bold' : 'bg-white text-blue-600 hover:bg-blue-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- クリック解析モーダル -->
    <div id="clickLogModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl shadow-xl relative max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    📊 クリック解析
                    <span id="clickLogKeyword" class="text-sm font-normal text-gray-500"></span>
                </h3>
                <button type="button" id="closeClickLogModal" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="clickLogSummary" class="bg-blue-50 p-3 rounded-lg mb-4 text-sm flex items-center justify-between">
                <div>
                    <span class="text-blue-800 font-medium">総クリック数:</span>
                    <span id="clickLogTotalCount" class="font-bold text-blue-800">0</span>
                </div>
                <button type="button" id="csvDownloadBtn" class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded shadow transition" title="クリックログをCSVでダウンロード">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    CSV出力
                </button>
            </div>

            <!-- ローディング -->
            <div id="clickLogLoading" class="hidden text-center py-8">
                <span class="animate-spin inline-block text-2xl">⟳</span>
                <p class="text-gray-500 mt-2">読み込み中...</p>
            </div>

            <!-- ログテーブル -->
            <div id="clickLogTableContainer" class="hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-3 py-2 text-left rounded-tl-lg w-12">No.</th>
                            <th class="px-3 py-2 text-left">クリック日時</th>
                            <th class="px-3 py-2 text-left rounded-tr-lg">リファラ</th>
                        </tr>
                    </thead>
                    <tbody id="clickLogTableBody">
                    </tbody>
                </table>
            </div>

            <!-- ログなし -->
            <div id="clickLogEmpty" class="hidden text-center py-8">
                <p class="text-gray-500">クリックログはまだありません。</p>
                <p class="text-xs text-gray-400 mt-1">この機能を有効にしてからのクリックが記録されます。</p>
            </div>
        </div>
    </div>

    <!-- 設定モーダル (パスワード変更 & 更新チェック) -->
    <div id="settingsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl shadow-xl relative max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    設定
                </h3>
                <button type="button" id="closeSettingsModal" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- パスワード変更セクション -->
                <div>
                    <h4 class="text-md font-bold text-gray-700 mb-3 border-l-4 border-gray-500 pl-2">パスワード変更</h4>
                    <form id="passwordForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">新しいパスワード (4文字以上)</label>
                            <input type="password" name="new_password" required minlength="4" placeholder="新しいパスワードを入力"
                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-gray-500 focus:outline-none bg-gray-50">
                        </div>
                        <div id="passwordMessage" class="hidden text-sm"></div>
                        <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded shadow transition">変更する</button>
                    </form>
                    <p class="text-xs text-gray-500 mt-3 flex items-start gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        変更後、直ちにログアウトされ、新しいパスワードでの再ログインが必要になります。
                    </p>
                </div>

                <!-- 更新チェックセクション -->
                <div>
                    <h4 class="text-md font-bold text-gray-700 mb-3 border-l-4 border-blue-500 pl-2">システムの更新</h4>
                    <div class="bg-blue-50 p-4 rounded-lg text-sm mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-blue-800 font-medium">現在のバージョン:</span>
                            <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded font-bold"><?= defined('TOOL_VERSION') ? TOOL_VERSION : '1.0.0' ?></span>
                        </div>
                        <button type="button" id="checkUpdateBtn" class="w-full mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow transition flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            最新バージョンをチェック
                        </button>
                    </div>
                    
                    <div id="updateResultArea" class="hidden">
                        <div id="updateMessage" class="mb-3 text-sm font-bold"></div>
                        <div id="updateDetails" class="bg-gray-50 p-3 rounded border text-xs text-gray-700 mb-3 hidden max-h-32 overflow-y-auto whitespace-pre-wrap"></div>
                        
                        <div id="updateActionArea" class="hidden">
                            <button type="button" id="executeUpdateBtn" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded shadow transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                最新版へアップデート
                            </button>
                            <p class="text-xs text-red-500 mt-2">※アップデート実行前に、必ずデータのバックアップを取ることを推奨します。自動更新によるファイル上書きが行われます。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 編集モーダル -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl relative">
            <h3 class="text-lg font-bold mb-4 border-b pb-2">転送先URLを編集</h3>
            <form id="editForm" class="space-y-4">
                <input type="hidden" name="id" id="editId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">新しい転送先URL</label>
                    <input type="url" name="url" id="editUrl" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-yellow-500 focus:outline-none">
                </div>
                <div id="editMessage" class="hidden text-sm"></div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="closeModal"
                        class="px-4 py-2 border rounded bg-white hover:bg-gray-100 text-gray-700 font-medium">キャンセル</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded shadow">更新する</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js?v=<?= time() ?>"></script>
</body>

</html>