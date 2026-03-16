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

// データベース接続
try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("DB Connection Error: " . $e->getMessage());
}

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
                <button type="button" id="openPasswordModalBtn"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded transition text-sm font-bold">パスワード変更</button>
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
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded">クリック:
                                        <?= htmlspecialchars($item['click_count']) ?></span>
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
                            <div class="w-full md:w-auto flex gap-2">
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

    <!-- パスワード変更モーダル -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl relative">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700">管理画面のパスワード変更</h3>
            <form id="passwordForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">新しいパスワード (4文字以上)</label>
                    <input type="password" name="new_password" required minlength="4" placeholder="新しいパスワードを入力"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-gray-500 focus:outline-none">
                </div>
                <div id="passwordMessage" class="hidden text-sm"></div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="closePasswordModal"
                        class="px-4 py-2 border rounded bg-white hover:bg-gray-100 text-gray-700 font-medium">キャンセル</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded shadow">変更する</button>
                </div>
            </form>
            <p class="text-xs text-gray-400 mt-4 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                変更後、直ちにログアウトされ、新しいパスワードでの再ログインが必要になります。
            </p>
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