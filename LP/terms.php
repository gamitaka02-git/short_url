<?php
/**
 * Short_URL - 利用規約
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約 | Short_URL</title>
    
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
            <h1 class="legal-title">利用規約</h1>

            <div class="legal-section">
                <h2 class="legal-section__title">第1条（適用）</h2>
                <p class="legal-section__text">
                    この利用規約（以下「本規約」といいます。）は、販売者（以下「当方」といいます。）が提供するソフトウェア「Short_URL」（以下「本ソフト」といいます。）の利用条件を定めるものです。本ソフトを購入・利用する全てのユーザー（以下「ユーザー」といいます。）は、本規約に従って本ソフトを利用するものとします。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第2条（使用許諾）</h2>
                <p class="legal-section__text">
                    当方は、ユーザーに対し、本ソフトの非独占的な使用を許諾します。本ソフトは1ライセンスにつき1ドメイン（サブドメインを含む）での利用が可能です。複数のドメインで利用する場合は、別途ライセンスの購入が必要です。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第3条（禁止事項）</h2>
                <p class="legal-section__text">
                    ユーザーは、本ソフトの利用にあたり、以下の行為をしてはなりません。<br>
                    1. 本ソフトの二次配布、転売、貸与、またはこれらに類する行為。<br>
                    2. 本ソフトのソースコードの改変（自己利用目的を除く）、リバースエンジニアリング、解析行為。<br>
                    3. 当方または第三者の知的財産権、名誉、プライバシーを侵害する行為。<br>
                    4. 公序良俗に反するサイトでの利用、または法令に違反する行為。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第4条（免責事項）</h2>
                <p class="legal-section__text">
                    1. 本ソフトは現状有姿で提供されるものであり、当方は本ソフトに事実上または法律上の瑕疵がないことを明示的にも黙示的にも保証しておりません。<br>
                    2. 本ソフトはユーザー自身のサーバー環境に設置して利用するものです。サーバーの仕様、OSやPHPのバージョン、他のソフトウェアとの競合、ネットワーク環境等に起因する動作不備について、当方は一切の責任を負いません。<br>
                    3. 本ソフトの利用により生じたデータの破壊、消失、機密漏洩、またはその他のいかなる損害についても、当方は一切の責任を負わないものとします。<br>
                    4. 本ソフトを利用して短縮されたURLが、スパム判定やフィルタリング等によりアクセス不能となった場合でも、当方は一切の責任を負いません。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第5条（規約の変更）</h2>
                <p class="legal-section__text">
                    当方は、当方が必要と判断した場合には、ユーザーに通知することなくいつでも本規約を変更することができるものとします。変更後の本規約は、公式サイトへの掲載をもって効力を生じるものとします。
                </p>
            </div>

            <div class="legal-section">
                <h2 class="legal-section__title">第6条（準拠法・裁判管轄）</h2>
                <p class="legal-section__text">
                    本規約の解釈にあたっては日本法を準拠法とし、本ソフトに関して紛争が生じた場合には、当方の所在地を管轄する裁判所を専属的合意管轄とします。
                </p>
            </div>

            <p class="legal-section__text" style="text-align: right; margin-top: 4rem;">
                以上<br>
                2026年3月22日 改定
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
