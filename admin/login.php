<?php
session_start();

// すでにログイン済みの場合はメイン画面へ
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$dbPath = __DIR__ . '/database.sqlite';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    try {
        if (!file_exists($dbPath)) {
            // DBがまだない場合（初回アクセス前）、または初期状態の場合はエラー
            $error = 'データベースが初期化されていません。最初に index.php にアクセスしてください。';
        } else {
            $pdo = new PDO('sqlite:' . $dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // index.phpを通らずにマイグレーション（configテーブル作成）が必要な場合のフォールバック
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS config (
                    key TEXT PRIMARY KEY,
                    value TEXT
                )
            ");

            // admin_passwordが存在するかチェック
            $stmtCheck = $pdo->query("SELECT count(*) FROM config WHERE key = 'admin_password'");
            if ($stmtCheck->fetchColumn() == 0) {
                // なければ初期パスワード設定 (admin)
                $initialPasswordHash = password_hash('admin', PASSWORD_DEFAULT);
                $stmtConfig = $pdo->prepare("INSERT INTO config (key, value) VALUES ('admin_password', :hash)");
                $stmtConfig->execute([':hash' => $initialPasswordHash]);
            }

            // パスワードを取得
            $stmt = $pdo->query("SELECT value FROM config WHERE key = 'admin_password'");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $hash = $row['value'];

                // 入力されたパスワードとDBのハッシュを比較
                if (password_verify($password, $hash)) {
                    // ログイン成功
                    $_SESSION['admin_logged_in'] = true;
                    header("Location: index.php");
                    exit;
                } else {
                    $error = 'パスワードが間違っています。';
                }
            } else {
                $error = 'パスワードが設定されていません。管理画面の初期設定を完了してください。';
            }
        }
    } catch (Exception $e) {
        $error = "DBエラーが発生しました: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - Short URL｜短縮URL生成ツール</title>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm border-t-4 border-blue-600">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Short URL｜ログイン</h1>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
                <input type="password" name="password" required autofocus
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="パスワードを入力">
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition shadow">ログイン</button>
        </form>
    </div>

</body>

</html>