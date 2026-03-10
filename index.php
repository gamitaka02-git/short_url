<?php
$dbPath = __DIR__ . '/admin/database.sqlite';

// DBファイルが存在しない場合は管理画面へ（初期セットアップ用）
if (!file_exists($dbPath)) {
    header("Location: admin/");
    exit;
}

$keyword = $_GET['slug'] ?? '';

// rootへのアクセスや対象指定なしの場合は管理画面へ
if (empty($keyword)) {
    header("Location: admin/");
    exit;
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 該当するスラッグを検索
    $stmt = $pdo->prepare("SELECT id, original_url FROM urls WHERE keyword = :keyword LIMIT 1");
    $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // カウント更新
        $update = $pdo->prepare("UPDATE urls SET click_count = click_count + 1 WHERE id = :id");
        $update->bindValue(':id', $row['id'], PDO::PARAM_INT);
        $update->execute();

        // 302キャッシュ防止のリダイレクト
        header("Location: " . $row['original_url'], true, 302);
        exit;
    } else {
        // 存在しないスラッグは管理画面へ
        header("Location: admin/");
        exit;
    }
} catch (Exception $e) {
    die("System Error.");
}
