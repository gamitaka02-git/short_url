<?php
/**
 * Short_URL - 特定商取引法に基づく表記
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>特定商取引法に基づく表記 | Short_URL</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="style.css">
</head>
<body class="legal-page">

    <!-- ===== Header / Navigation ===== -->
    <nav id="site-nav">
        <div class="lp-nav__inner">
            <a href="index.php" class="lp-nav__logo">
                <i data-lucide="link-2"></i>
                Short_URL
            </a>
            <a href="index.php#cta-section" class="lp-nav__cta">
                今すぐ購入
                <i data-lucide="arrow-right"></i>
            </a>
        </div>
    </nav>

    <div class="legal-container">
        <main class="legal-card">
            <h1 class="legal-title">特定商取引法に基づく表記</h1>

            <table class="legal-table">
                <tr>
                    <th>販売業者</th>
                    <td>ブログサポーターGamitaka</td>
                </tr>
                <tr>
                    <th>代表責任者</th>
                    <td>石上　貴哉</td>
                </tr>
                <tr>
                    <th>所在地</th>
                    <td>〒6750023 兵庫県加古川市尾上町池田1779-2</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>079-426-0906</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>tools@gamitaka.com</td>
                </tr>
                <tr>
                    <th>販売価格</th>
                    <td>500円（税込）</td>
                </tr>
                <tr>
                    <th>商品代金以外の必要料金</th>
                    <td>インターネット接続費用その他通信料はお客様負担となります。</td>
                </tr>
                <tr>
                    <th>お支払方法</th>
                    <td>クレジットカード決済（Stripe）</td>
                </tr>
                <tr>
                    <th>代金の支払時期</th>
                    <td>ご利用のカード会社、決済サービスの規定に基づきます。</td>
                </tr>
                <tr>
                    <th>商品の引き渡し時期</th>
                    <td>お支払い完了後、即時ダウンロード（またはメール送付）にて提供いたします。</td>
                </tr>
                <tr>
                    <th>返品・キャンセルに関する特約</th>
                    <td>デジタルコンテンツという商品の性質上、決済完了後の返品・返金・キャンセルには応じられません。あらかじめ動作環境等を十分にご確認の上、ご購入ください。</td>
                </tr>
            </table>

            <nav class="legal-nav" style="margin-top: 4rem; margin-bottom: 0; text-align: center;">
                <a href="index.php" class="legal-back-link">
                    <i data-lucide="arrow-left"></i>
                    トップページへ戻る
                </a>
            </nav>
        </main>
    </div>

    <!-- ===== Footer ===== -->
    <footer class="lp-footer">
        <div class="container-xl">
            <div class="lp-footer__links">
                <a href="terms.php">利用規約</a>
                <a href="privacy.php">プライバシーポリシー</a>
                <a href="law.php">特定商取引法に基づく表記</a>
            </div>
            <p class="lp-footer__copyright">&copy; 2026 Gamitaka Tools. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
