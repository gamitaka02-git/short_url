<?php
// 1. 設定ファイルとStripeライブラリの読み込み
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/stripe-php/init.php';

// データベース接続関数
function get_db_connection()
{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

// 2. Stripeからのリクエストを取得
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$event = null;

try {
    // 署名検証（なりすまし防止）
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        STRIPE_WEBHOOK_SECRET
    );
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

// 3. 決済完了イベントの処理
if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;
    $customer_email = $session->customer_details->email;

    // ランダムなライセンスキー生成 (例: SU-ABCD-1234-EFGH)
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $key_part = function () use ($chars) {
        return substr(str_shuffle($chars), 0, 4);
    };
    $license_key = "SU-" . $key_part() . "-" . $key_part() . "-" . $key_part();

    // DB（MySQL）に保存
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("INSERT INTO licenses (license_key, user_email, status, created_at) VALUES (?, ?, 'active', NOW())");
        $stmt->execute([$license_key, $customer_email]);

        error_log("License Issued: $license_key for $customer_email");
    } catch (PDOException $e) {
        error_log("DB Error in Webhook: " . $e->getMessage());
        http_response_code(500);
        exit();
    }
}

http_response_code(200);
