<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short_URL｜自社ドメイン専用・サーバー設置型短縮URL生成ツール</title>
    <meta name="description" content="自社ドメインで短縮URLを生成・管理できるサーバー設置型ツール。500円買い切り、月額費用0円、クリック解析機能搭載。">
    <meta name="robots" content="noindex">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- ===== Header / Navigation ===== -->
    <nav id="site-nav">
        <div class="lp-nav__inner">
            <a href="#" class="lp-nav__logo">
                <i data-lucide="link-2"></i>
                Short_URL
            </a>
            <a href="#cta-section" class="lp-nav__cta">
                今すぐ購入
                <i data-lucide="arrow-right"></i>
            </a>
        </div>
    </nav>

    <!-- ===== Hero Section (FV) ===== -->
    <section id="hero">
        <!-- Background decoration -->
        <div class="hero-bg-decor">
            <div class="hero-bg-decor__orb hero-bg-decor__orb--accent"></div>
            <div class="hero-bg-decor__orb hero-bg-decor__orb--blue"></div>
            <div class="hero-bg-decor__orb hero-bg-decor__orb--center"></div>
        </div>

        <div class="lp-hero__inner">
            <div class="animate-fade-in-up">
                <p class="lp-hero__tag">
                    <i data-lucide="shield-check"></i>
                    自社ドメイン専用・サーバー設置型
                </p>
            </div>

            <h1 class="lp-hero__title animate-fade-in-up" style="animation-delay: 0.1s; opacity: 0;">
                その1クリックを、<br class="br-mobile"><span class="accent">信頼</span>に変える。
            </h1>

            <p class="lp-hero__lead animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0;">
                自社ドメイン（独自ドメイン）専用・サーバー設置型<br class="br-desktop">短縮URL生成ツール<strong>『Short_URL』</strong>
            </p>

            <p class="lp-hero__sub animate-fade-in-up" style="animation-delay: 0.3s; opacity: 0;">
                あなたのドメインで、信頼と集まるデータを、あなただけのものに。
            </p>

            <!-- Badges -->
            <div class="lp-hero__badges animate-fade-in-up" style="animation-delay: 0.4s; opacity: 0;">
                <span class="lp-badge lp-badge--price">
                    <i data-lucide="tag"></i> 500円(税込)・買い切り
                </span>
                <span class="lp-badge lp-badge--free">
                    <i data-lucide="circle-dollar-sign"></i> 月額費用0円
                </span>
                <span class="lp-badge lp-badge--analytics">
                    <i data-lucide="bar-chart-3"></i> 解析機能標準搭載
                </span>
            </div>

            <!-- CTA Button -->
            <div class="lp-hero__cta-wrap animate-fade-in-up" style="animation-delay: 0.5s; opacity: 0;">
                <a href="checkout.php" id="hero-cta-button" class="lp-cta-button">
                    今すぐ購入して設置する（500円）
                    <i data-lucide="arrow-right"></i>
                </a>
                <p class="lp-hero__stripe-note">
                    <i data-lucide="lock"></i>
                    決済はStripeで安全に行われます
                </p>
            </div>
        </div>
    </section>

    <!-- ===== Problem Section ===== -->
    <section id="problem" class="section-padding">
        <div class="container-md">
            <div class="section-header scroll-reveal">
                <p class="section-label">Problem</p>
                <h2 class="section-title">
                    こんな<span class="accent">悩み</span>はありませんか？
                </h2>
                <p class="section-subtitle">外部の短縮URLサービスに頼り続けることで、こんなリスクを抱えていませんか？</p>
            </div>

            <div class="problem-grid">
                <!-- Problem 1 -->
                <div class="scroll-reveal problem-card">
                    <div class="problem-card__inner">
                        <div class="problem-card__icon">
                            <i data-lucide="alert-triangle"></i>
                        </div>
                        <div>
                            <h3 class="problem-card__title">短縮URL、なんか怪しくない？</h3>
                            <p class="problem-card__text">見慣れない外部ドメインの短縮URLは、ユーザーに不信感を与え、クリック率を低下させる原因に。</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 2 -->
                <div class="scroll-reveal problem-card">
                    <div class="problem-card__inner">
                        <div class="problem-card__icon">
                            <i data-lucide="power-off"></i>
                        </div>
                        <div>
                            <h3 class="problem-card__title">サービス終了で全URLが無効に？</h3>
                            <p class="problem-card__text">外部サービスが終了したら、これまで作った短縮URLが一斉にリンク切れ。ビジネスへの影響は計り知れません。<br>
                            （例：Googleの短縮URL）</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 3 -->
                <div class="scroll-reveal problem-card">
                    <div class="problem-card__inner">
                        <div class="problem-card__icon">
                            <i data-lucide="database"></i>
                        </div>
                        <div>
                            <h3 class="problem-card__title">クリックデータ、他社に握られてない？</h3>
                            <p class="problem-card__text">外部サービスのサーバーに蓄積されるアクセスデータ。自分のビジネスの貴重なデータが、他社の資産になっているかもしれません。</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 4 -->
                <div class="scroll-reveal problem-card">
                    <div class="problem-card__inner">
                        <div class="problem-card__icon">
                            <i data-lucide="wallet"></i>
                        </div>
                        <div>
                            <h3 class="problem-card__title">月額コストがジワジワ負担に…</h3>
                            <p class="problem-card__text">「月額○○円」の積み重ね。年間で計算すると結構な出費。もっとコスパの良い方法はないだろうか。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Solution / Benefits Section ===== -->
    <section id="benefits" class="section-padding">
        <div class="container-lg">
            <div class="section-header scroll-reveal" style="margin-bottom: 4rem;">
                <p class="section-label">Solution</p>
                <h2 class="section-title">
                    Short_URLが<span class="accent">すべて解決</span>します
                </h2>
                <p class="section-subtitle">自社ドメインの短縮URLで、信頼性・データ・コストの課題をまとめて解消。</p>
            </div>

            <div class="benefits-list">
                <!-- Benefit 01 -->
                <div class="scroll-reveal benefit-row">
                    <div class="benefit-row__visual">
                        <img src="img/placeholder.jpg" alt="自社ドメインでの短縮URL" class="benefit-row__image">
                    </div>
                    <div class="benefit-row__content">
                        <span class="benefit-row__number">01</span>
                        <h3 class="benefit-row__title">脱・怪しい短縮URL</h3>
                        <p class="benefit-row__highlight benefit-row__highlight--accent">信頼性とCTR（クリック率）を向上</p>
                        <p class="benefit-row__text">自社ドメインで生成された短縮URLは、ユーザーに安心感を与えます。「どこのURLだろう？」という不安がなくなることで、クリック率が自然と向上。ブランドの信頼性も高まります。</p>
                    </div>
                </div>

                <!-- Benefit 02 -->
                <div class="scroll-reveal benefit-row benefit-row--reverse">
                    <div class="benefit-row__visual">
                        <img src="img/placeholder.jpg" alt="データの完全所有" class="benefit-row__image">
                    </div>
                    <div class="benefit-row__content">
                        <span class="benefit-row__number">02</span>
                        <h3 class="benefit-row__title">データの完全所有</h3>
                        <p class="benefit-row__highlight benefit-row__highlight--emerald">貴重なクリックデータを資産化・リスク回避</p>
                        <p class="benefit-row__text">クリック数・日時・リファラなどのアクセスデータはすべてあなたのサーバーに蓄積。外部サービスに依存しないから、サービス終了によるリンク切れの心配もゼロ。データはあなたの資産です。</p>
                    </div>
                </div>

                <!-- Benefit 03 -->
                <div class="scroll-reveal benefit-row">
                    <div class="benefit-row__visual">
                        <img src="img/placeholder.jpg" alt="圧倒的コスパ" class="benefit-row__image">
                    </div>
                    <div class="benefit-row__content">
                        <span class="benefit-row__number">03</span>
                        <h3 class="benefit-row__title">圧倒的コスパ</h3>
                        <p class="benefit-row__highlight benefit-row__highlight--yellow">500円買い切り・一生モノのツール</p>
                        <p class="benefit-row__text">一度買えばずっと使える。月額費用は一切かかりません。年間のサブスクリプション費用と比べれば、圧倒的なコストパフォーマンスを実現。ランニングコストを気にせず運用できます。</p>
                    </div>
                </div>

                <!-- Benefit 04 -->
                <div class="scroll-reveal benefit-row benefit-row--reverse">
                    <div class="benefit-row__visual">
                        <img src="img/placeholder.jpg" alt="メンテナンスフリー" class="benefit-row__image">
                    </div>
                    <div class="benefit-row__content">
                        <span class="benefit-row__number">04</span>
                        <h3 class="benefit-row__title">簡単メンテナンス</h3>
                        <p class="benefit-row__highlight benefit-row__highlight--blue">管理画面からクリックするだけの簡単更新</p>
                        <p class="benefit-row__text">アップデートがあっても、管理画面のボタンをクリックするだけ。技術的な知識がなくても、常に最新の状態を保てます。面倒な運用・保守作業から解放されます。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Features Section ===== -->
    <section id="features" class="section-padding">
        <div class="container-lg">
            <div class="section-header scroll-reveal">
                <p class="section-label">Features</p>
                <h2 class="section-title">
                    主な<span class="accent">機能</span>
                </h2>
                <p class="section-subtitle">シンプルながらも必要な機能をしっかり搭載。</p>
            </div>

            <div class="features-grid">
                <!-- Feature 1 -->
                <div class="scroll-reveal feature-card">
                    <div class="feature-card__icon">
                        <i data-lucide="mouse-pointer-click"></i>
                    </div>
                    <h3 class="feature-card__title">詳細クリック解析</h3>
                    <p class="feature-card__text">クリック回数、アクセス日時、リファラ（参照元）を自動で記録。<br>マーケティングの改善に役立つデータが手に入ります。</p>
                </div>

                <!-- Feature 2 -->
                <div class="scroll-reveal feature-card">
                    <div class="feature-card__icon">
                        <i data-lucide="zap"></i>
                    </div>
                    <h3 class="feature-card__title">超簡単セットアップ</h3>
                    <p class="feature-card__text">サーバーにアップロードして <code class="inline-code">https://ドメイン/short_url(フォルダ名は変更可)/</code> にアクセス。あとはパスワードの設定とライセンスの認証をするだけで、数分で使い始められます。</p>
                </div>

                <!-- Feature 3 -->
                <div class="scroll-reveal feature-card">
                    <div class="feature-card__icon">
                        <i data-lucide="globe"></i>
                    </div>
                    <h3 class="feature-card__title">独自ドメイン対応</h3>
                    <p class="feature-card__text">あなたが所有するドメインで短縮URLを生成。ブランドイメージを損なわず、ユーザーに安心感を与えます。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Screenshot / Demo Section ===== -->
    <section id="demo" class="section-padding">
        <div class="container-md">
            <div class="section-header scroll-reveal" style="margin-bottom: 3rem;">
                <p class="section-label">Demo</p>
                <h2 class="section-title">
                    管理画面<span class="accent">イメージ</span>
                </h2>
            </div>
            <div class="scroll-reveal demo-frame">
                <img src="img/placeholder.jpg" alt="Short_URL管理画面のスクリーンショット" id="demo-screenshot">
            </div>
        </div>
    </section>

    <!-- ===== FAQ Section ===== -->
    <section id="faq" class="section-padding">
        <div class="container-sm">
            <div class="section-header scroll-reveal">
                <p class="section-label">FAQ</p>
                <h2 class="section-title">
                    よくある<span class="accent">ご質問</span>
                </h2>
            </div>

            <div class="faq-list">
                <!-- FAQ 1 -->
                <div class="scroll-reveal faq-item">
                    <button class="faq-toggle" aria-expanded="false">
                        <span class="faq-toggle__question">共用サーバーでも使えますか？</span>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </button>
                    <div class="faq-content" style="max-height: 0;">
                        <div class="faq-content__inner">
                            <p class="faq-content__text">はい、PHPが動作するサーバーであれば、共用サーバー（レンタルサーバー）でもお使いいただけます。エックスサーバー、ロリポップ、ConoHa WINGなどの主要サーバーで動作確認済みです。</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="scroll-reveal faq-item">
                    <button class="faq-toggle" aria-expanded="false">
                        <span class="faq-toggle__question">設置は難しいですか？</span>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </button>
                    <div class="faq-content" style="max-height: 0;">
                        <div class="faq-content__inner">
                            <p class="faq-content__text">「Filezilla」などのFTPツール、もしくはサーバーの「ファイルマネージャー」にてツールのフォルダごとドラッグ＆ドロップで設置するだけで設置できます。また初回はログインパスワードを設定し、発行されたライセンスを入力していただくことでご利用になれます。</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="scroll-reveal faq-item">
                    <button class="faq-toggle" aria-expanded="false">
                        <span class="faq-toggle__question">追加費用はかかりますか？</span>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </button>
                    <div class="faq-content" style="max-height: 0;">
                        <div class="faq-content__inner">
                            <p class="faq-content__text">いいえ、追加費用は一切かかりません。500円の買い切りで、今後のアップデートも無料でご利用いただけます。月額費用・年間費用は発生しません。</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="scroll-reveal faq-item">
                    <button class="faq-toggle" aria-expanded="false">
                        <span class="faq-toggle__question">短縮URLの作成数に制限はありますか？</span>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </button>
                    <div class="faq-content" style="max-height: 0;">
                        <div class="faq-content__inner">
                            <p class="faq-content__text">いいえ、サーバーの容量が許す限り無制限ですので、お好きなだけ短縮URLを作成していただけます。</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="scroll-reveal faq-item">
                    <button class="faq-toggle" aria-expanded="false">
                        <span class="faq-toggle__question">データのエクスポートはできますか？</span>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </button>
                    <div class="faq-content" style="max-height: 0;">
                        <div class="faq-content__inner">
                            <p class="faq-content__text">はい、クリックデータは管理画面からCSV形式でエクスポートが可能です。データ分析やレポート作成にご活用ください。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA Section ===== -->
    <section id="cta-section" class="section-padding">
        <!-- Background decoration -->
        <div class="cta-bg-decor">
            <div class="cta-bg-decor__orb--accent"></div>
            <div class="cta-bg-decor__orb--blue"></div>
        </div>

        <div class="container-sm" style="position: relative; text-align: center;">
            <div class="scroll-reveal">
                <h2 class="cta-header__title">
                    『信頼とデータ』を、<br class="br-mobile"><span class="accent">ワンコイン</span>で。
                </h2>
                <p class="cta-header__sub">自社ドメインの短縮URLで、ビジネスの可能性を広げましょう。</p>
            </div>

            <div class="scroll-reveal pricing-box">
                <div class="pricing-box__logo">
                    <i data-lucide="link-2"></i>
                    Short_URL
                </div>
                
                <div class="pricing-box__price-wrapper">
                    <div class="pricing-box__old-price">通常価格</div>
                    <div class="pricing-box__price">
                        <span class="pricing-box__amount">500</span>
                        <span class="pricing-box__currency">円</span>
                    </div>
                    <p class="pricing-box__note">（税込・買い切り・追加費用なし）</p>
                </div>

                <ul class="pricing-features">
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        月額費用なし・永久ライセンス
                    </li>
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        クリック解析機能搭載
                    </li>
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        URL作成数 無制限
                    </li>
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        無料アップデート対応
                    </li>
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        独自ドメインで短縮URL生成
                    </li>
                    <li class="pricing-features__item">
                        <i data-lucide="check-circle-2"></i>
                        簡単セットアップ
                    </li>
                </ul>

                <!-- Stripe決済ボタン -->
                <a href="checkout.php" id="checkout-button" class="lp-cta-button lp-cta-button--lg">
                    今すぐ購入して設置する（500円）
                    <i data-lucide="arrow-right"></i>
                </a>

                <p class="pricing-box__stripe-note">
                    <i data-lucide="lock"></i>
                    決済はStripeで安全に行われます
                </p>
            </div>
        </div>
    </section>

    <!-- ===== Footer ===== -->
    <footer class="lp-footer">
        <div class="container-xl">
            <a href="#" class="lp-footer__logo">
                <i data-lucide="link-2"></i>
                Short_URL
            </a>
            <p class="lp-footer__copyright">&copy; 2026 Gamitaka Tools. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
