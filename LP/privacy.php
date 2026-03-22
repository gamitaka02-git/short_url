<?php
/**
 * Short_URL - プライバシーポリシー
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー | Short_URL</title>
    
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
            <h1 class="legal-title">プライバシーポリシー</h1>

            <div class="legal-section">
                <h2 class="legal-section__title">個人情報の取得</h2>
                <p class="legal-section__text">
                    当方は、本ソフトの販売およびサポート提供にあたり、以下の個人情報を取得することがあります。<br>
                    1. 決済時に入力される情報（氏名、メールアドレス、クレジットカード情報等。なお、カード情報は決済代行会社であるStripe社によって管理され、当方が直接保持することはありません。）<br>
                    2. お問い合わせ時に提供される情報（氏名、メールアドレス、お問い合わせ内容等）
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">利用目的</h2>
                <p class="legal-section__text">
                    取得した個人情報は、以下の目的で利用いたします。<br>
                    1. 本ソフトの提供、ライセンス認証、およびアップデートの通知のため。<br>
                    2. ユーザーからの問い合わせに対する回答、サポート提供のため。<br>
                    3. 重要なお知らせや、当方の新サービスに関する案内のため。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第三者提供の制限</h2>
                <p class="legal-section__text">
                    当方は、法令に基づく場合を除き、あらかじめユーザーの同意を得ることなく第三者に個人情報を提供することはありません。ただし、決済処理やデータ管理のために必要な範囲で、業務委託先（Stripe等）に情報を提供することがあります。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">Cookie（クッキー）の使用</h2>
                <p class="legal-section__text">
                    当サイトでは、サービスの向上や利用状況の分析、および適切な広告配信のためにCookieを使用することがあります。ユーザーはブラウザの設定によりCookieの受け取りを拒否することができます。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">お問い合わせ先</h2>
                <p class="legal-section__text">
                    個人情報の取り扱いに関するお問い合わせは、以下の窓口までお願いいたします。<br><br>
                    tools@gamitaka.com
                </p>
            </div>

            <p class="legal-section__text" style="text-align: right; margin-top: 4rem;">
                2026年3月22日 制定
            </p>

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
