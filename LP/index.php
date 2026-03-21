<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short_URL｜自社ドメイン専用・サーバー設置型短縮URL生成ツール</title>
    <meta name="description" content="自社ドメインで短縮URLを生成・管理できるサーバー設置型ツール。500円買い切り、月額費用0円、クリック解析機能搭載。">
    <meta name="robots" content="noindex">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f4fa',
                            100: '#d9e2f0',
                            200: '#b3c5e1',
                            300: '#8da8d2',
                            400: '#678bc3',
                            500: '#4a6fa5',
                            600: '#1e3a5f',
                            700: '#162d4a',
                            800: '#0f2035',
                            900: '#0a1628',
                        },
                        accent: {
                            DEFAULT: '#f97316',
                            hover: '#ea580c',
                            light: '#fff7ed',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Noto Sans JP', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

    <!-- ===== Header / Navigation ===== -->
    <nav id="site-nav" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2 text-navy-700 font-bold text-xl">
                <i data-lucide="link-2" class="w-6 h-6 text-accent"></i>
                Short_URL
            </a>
            <a href="#cta-section" class="hidden sm:inline-flex items-center gap-2 bg-accent hover:bg-accent-hover text-white font-semibold text-sm px-5 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-orange-200 hover:-translate-y-0.5">
                今すぐ購入
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </nav>

    <!-- ===== Hero Section (FV) ===== -->
    <section id="hero" class="relative overflow-hidden pt-28 pb-20 sm:pt-36 sm:pb-28 bg-gradient-to-br from-navy-800 via-navy-700 to-navy-600">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-accent/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-blue-400/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-navy-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in-up">
                <p class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white/90 text-sm font-medium px-4 py-2 rounded-full mb-8 border border-white/10">
                    <i data-lucide="shield-check" class="w-4 h-4 text-accent"></i>
                    自社ドメイン専用・サーバー設置型
                </p>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-6 animate-fade-in-up" style="animation-delay: 0.1s; opacity: 0;">
                その1クリックを、<br class="sm:hidden"><span class="text-accent">信頼</span>に変える。
            </h1>

            <p class="text-lg sm:text-xl text-navy-200 mb-4 animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0;">
                自社ドメイン（独自ドメイン）専用・サーバー設置型<br class="hidden sm:inline">短縮URL生成ツール<strong class="text-white">『Short_URL』</strong>
            </p>

            <p class="text-base sm:text-lg text-navy-300 mb-10 animate-fade-in-up" style="animation-delay: 0.3s; opacity: 0;">
                あなたのドメインで、信頼と集まるデータを、あなただけのものに。
            </p>

            <!-- Badges -->
            <div class="flex flex-wrap justify-center gap-3 mb-10 animate-fade-in-up" style="animation-delay: 0.4s; opacity: 0;">
                <span class="inline-flex items-center gap-1.5 bg-accent/20 text-accent border border-accent/30 text-sm font-bold px-4 py-2 rounded-full">
                    <i data-lucide="tag" class="w-4 h-4"></i> 500円(税込)・買い切り
                </span>
                <span class="inline-flex items-center gap-1.5 bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-sm font-bold px-4 py-2 rounded-full">
                    <i data-lucide="circle-dollar-sign" class="w-4 h-4"></i> 月額費用0円
                </span>
                <span class="inline-flex items-center gap-1.5 bg-blue-400/20 text-blue-300 border border-blue-400/30 text-sm font-bold px-4 py-2 rounded-full">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i> 解析機能標準搭載
                </span>
            </div>

            <!-- CTA Button -->
            <div class="animate-fade-in-up" style="animation-delay: 0.5s; opacity: 0;">
                <a href="checkout.php" id="hero-cta-button" class="group inline-flex items-center gap-3 bg-accent hover:bg-accent-hover text-white font-bold text-lg px-10 py-4 rounded-full transition-all duration-300 shadow-xl shadow-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1">
                    今すぐ購入して設置する（500円）
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <p class="mt-4 text-sm text-navy-400">
                    <i data-lucide="lock" class="w-3.5 h-3.5 inline-block mr-1 -mt-0.5"></i>
                    決済はStripeで安全に行われます
                </p>
            </div>
        </div>
    </section>

    <!-- ===== Problem Section ===== -->
    <section id="problem" class="py-20 sm:py-28 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 scroll-reveal">
                <p class="text-accent font-semibold text-sm tracking-wider uppercase mb-3">Problem</p>
                <h2 class="text-3xl sm:text-4xl font-black text-navy-800 mb-4">
                    こんな<span class="text-accent">悩み</span>はありませんか？
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">外部の短縮URLサービスに頼り続けることで、こんなリスクを抱えていませんか？</p>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <!-- Problem 1 -->
                <div class="scroll-reveal bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-navy-700 text-lg mb-1">短縮URL、なんか怪しくない？</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">見慣れない外部ドメインの短縮URLは、ユーザーに不信感を与え、クリック率を低下させる原因に。</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 2 -->
                <div class="scroll-reveal bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300" style="animation-delay: 0.1s;">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                            <i data-lucide="power-off" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-navy-700 text-lg mb-1">サービス終了で全URLが無効に？</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">外部サービスが終了したら、これまで作った短縮URLが一斉にリンク切れ。ビジネスへの影響は計り知れません。</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 3 -->
                <div class="scroll-reveal bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300" style="animation-delay: 0.2s;">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                            <i data-lucide="database" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-navy-700 text-lg mb-1">クリックデータ、他社に握られてない？</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">外部サービスのサーバーに蓄積されるアクセスデータ。自分のビジネスの貴重なデータが、他社の資産になっているかもしれません。</p>
                        </div>
                    </div>
                </div>

                <!-- Problem 4 -->
                <div class="scroll-reveal bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300" style="animation-delay: 0.3s;">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                            <i data-lucide="wallet" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-navy-700 text-lg mb-1">月額コストがジワジワ負担に…</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">「月額○○円」の積み重ね。年間で計算すると結構な出費。もっとコスパの良い方法はないだろうか。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Solution / Benefits Section ===== -->
    <section id="benefits" class="py-20 sm:py-28 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 scroll-reveal">
                <p class="text-accent font-semibold text-sm tracking-wider uppercase mb-3">Solution</p>
                <h2 class="text-3xl sm:text-4xl font-black text-navy-800 mb-4">
                    Short_URLが<span class="text-accent">すべて解決</span>します
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">自社ドメインの短縮URLで、信頼性・データ・コストの課題をまとめて解消。</p>
            </div>

            <div class="space-y-16">
                <!-- Benefit 01 -->
                <div class="scroll-reveal flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="flex-shrink-0 w-full md:w-1/3">
                        <div class="relative bg-gradient-to-br from-navy-600 to-navy-800 rounded-2xl p-8 text-center">
                            <span class="text-7xl font-black text-white/10 absolute top-4 left-6">01</span>
                            <i data-lucide="shield-check" class="w-16 h-16 text-accent mx-auto relative z-10"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-navy-800 mb-3">脱・怪しい短縮URL</h3>
                        <p class="text-lg font-semibold text-accent mb-2">信頼性とCTR（クリック率）を向上</p>
                        <p class="text-gray-600 leading-relaxed">自社ドメインで生成された短縮URLは、ユーザーに安心感を与えます。「どこのURLだろう？」という不安がなくなることで、クリック率が自然と向上。ブランドの信頼性も高まります。</p>
                    </div>
                </div>

                <!-- Benefit 02 -->
                <div class="scroll-reveal flex flex-col md:flex-row-reverse items-center gap-8 md:gap-12">
                    <div class="flex-shrink-0 w-full md:w-1/3">
                        <div class="relative bg-gradient-to-br from-navy-600 to-navy-800 rounded-2xl p-8 text-center">
                            <span class="text-7xl font-black text-white/10 absolute top-4 left-6">02</span>
                            <i data-lucide="hard-drive" class="w-16 h-16 text-emerald-400 mx-auto relative z-10"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-navy-800 mb-3">データの完全所有</h3>
                        <p class="text-lg font-semibold text-emerald-600 mb-2">貴重なクリックデータを資産化・リスク回避</p>
                        <p class="text-gray-600 leading-relaxed">クリック数・日時・リファラなどのアクセスデータはすべてあなたのサーバーに蓄積。外部サービスに依存しないから、サービス終了によるリンク切れの心配もゼロ。データはあなたの資産です。</p>
                    </div>
                </div>

                <!-- Benefit 03 -->
                <div class="scroll-reveal flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="flex-shrink-0 w-full md:w-1/3">
                        <div class="relative bg-gradient-to-br from-navy-600 to-navy-800 rounded-2xl p-8 text-center">
                            <span class="text-7xl font-black text-white/10 absolute top-4 left-6">03</span>
                            <i data-lucide="coins" class="w-16 h-16 text-yellow-400 mx-auto relative z-10"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-navy-800 mb-3">圧倒的コスパ</h3>
                        <p class="text-lg font-semibold text-yellow-600 mb-2">500円買い切り・一生モノのツール</p>
                        <p class="text-gray-600 leading-relaxed">一度買えばずっと使える。月額費用は一切かかりません。年間のサブスクリプション費用と比べれば、圧倒的なコストパフォーマンスを実現。ランニングコストを気にせず運用できます。</p>
                    </div>
                </div>

                <!-- Benefit 04 -->
                <div class="scroll-reveal flex flex-col md:flex-row-reverse items-center gap-8 md:gap-12">
                    <div class="flex-shrink-0 w-full md:w-1/3">
                        <div class="relative bg-gradient-to-br from-navy-600 to-navy-800 rounded-2xl p-8 text-center">
                            <span class="text-7xl font-black text-white/10 absolute top-4 left-6">04</span>
                            <i data-lucide="refresh-cw" class="w-16 h-16 text-blue-400 mx-auto relative z-10"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-navy-800 mb-3">メンテナンスフリー</h3>
                        <p class="text-lg font-semibold text-blue-600 mb-2">管理画面からワンクリック更新</p>
                        <p class="text-gray-600 leading-relaxed">アップデートがあっても、管理画面のボタンをワンクリックするだけ。技術的な知識がなくても、常に最新の状態を保てます。面倒な運用・保守作業から解放されます。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Features Section ===== -->
    <section id="features" class="py-20 sm:py-28 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 scroll-reveal">
                <p class="text-accent font-semibold text-sm tracking-wider uppercase mb-3">Features</p>
                <h2 class="text-3xl sm:text-4xl font-black text-navy-800 mb-4">
                    主な<span class="text-accent">機能</span>
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">シンプルながらも必要な機能をしっかり搭載。</p>
            </div>

            <div class="grid sm:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="scroll-reveal group bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-navy-50 text-navy-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-navy-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="mouse-pointer-click" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-bold text-navy-800 text-lg mb-3">詳細クリック解析</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">クリック回数、アクセス日時、リファラ（参照元）を自動で記録。マーケティングの改善に役立つデータが手に入ります。</p>
                </div>

                <!-- Feature 2 -->
                <div class="scroll-reveal group bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center" style="animation-delay: 0.1s;">
                    <div class="w-16 h-16 bg-navy-50 text-navy-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-navy-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="zap" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-bold text-navy-800 text-lg mb-3">超簡単セットアップ</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">サーバーにアップロードして <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs font-mono text-navy-700">setup.php</code> にアクセスするだけ。数分で使い始められます。</p>
                </div>

                <!-- Feature 3 -->
                <div class="scroll-reveal group bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 bg-navy-50 text-navy-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-navy-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="globe" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-bold text-navy-800 text-lg mb-3">独自ドメイン対応</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">あなたが所有するドメインで短縮URLを生成。ブランドイメージを損なわず、ユーザーに安心感を与えます。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Screenshot / Demo Section ===== -->
    <section id="demo" class="py-20 sm:py-28 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 scroll-reveal">
                <p class="text-accent font-semibold text-sm tracking-wider uppercase mb-3">Demo</p>
                <h2 class="text-3xl sm:text-4xl font-black text-navy-800 mb-4">
                    管理画面<span class="text-accent">イメージ</span>
                </h2>
            </div>
            <div class="scroll-reveal bg-navy-800 rounded-2xl p-3 sm:p-4 shadow-2xl">
                <img src="img/placeholder.jpg" alt="Short_URL管理画面のスクリーンショット" class="w-full rounded-xl" id="demo-screenshot">
            </div>
        </div>
    </section>

    <!-- ===== FAQ Section ===== -->
    <section id="faq" class="py-20 sm:py-28 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 scroll-reveal">
                <p class="text-accent font-semibold text-sm tracking-wider uppercase mb-3">FAQ</p>
                <h2 class="text-3xl sm:text-4xl font-black text-navy-800 mb-4">
                    よくある<span class="text-accent">ご質問</span>
                </h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="scroll-reveal faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <button class="faq-toggle w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors" aria-expanded="false">
                        <span class="font-bold text-navy-700 pr-4">共用サーバーでも使えますか？</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 flex-shrink-0 faq-icon transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-6">
                        <p class="text-gray-600 text-sm leading-relaxed">はい、PHPが動作するサーバーであれば、共用サーバー（レンタルサーバー）でもお使いいただけます。エックスサーバー、ロリポップ、ConoHa WINGなどの主要サーバーで動作確認済みです。</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="scroll-reveal faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay: 0.1s;">
                    <button class="faq-toggle w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors" aria-expanded="false">
                        <span class="font-bold text-navy-700 pr-4">追加費用はかかりますか？</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 flex-shrink-0 faq-icon transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-6">
                        <p class="text-gray-600 text-sm leading-relaxed">いいえ、追加費用は一切かかりません。500円の買い切りで、今後のアップデートも無料でご利用いただけます。月額費用・年間費用は発生しません。</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="scroll-reveal faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay: 0.2s;">
                    <button class="faq-toggle w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors" aria-expanded="false">
                        <span class="font-bold text-navy-700 pr-4">短縮URLの作成数に制限はありますか？</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 flex-shrink-0 faq-icon transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-6">
                        <p class="text-gray-600 text-sm leading-relaxed">いいえ、作成数は無制限です。お好きなだけ短縮URLを作成していただけます。</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="scroll-reveal faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay: 0.3s;">
                    <button class="faq-toggle w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors" aria-expanded="false">
                        <span class="font-bold text-navy-700 pr-4">データのエクスポートはできますか？</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 flex-shrink-0 faq-icon transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-6">
                        <p class="text-gray-600 text-sm leading-relaxed">はい、クリックデータは管理画面からCSV形式でエクスポートが可能です。データ分析やレポート作成にご活用ください。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA Section ===== -->
    <section id="cta-section" class="py-20 sm:py-28 bg-gradient-to-br from-navy-800 via-navy-700 to-navy-600 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-accent/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-400/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
        </div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="scroll-reveal">
                <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">
                    『信頼とデータ』を、<br class="sm:hidden"><span class="text-accent">ワンコイン</span>で。
                </h2>
                <p class="text-navy-300 text-lg mb-10">自社ドメインの短縮URLで、ビジネスの可能性を広げましょう。</p>
            </div>

            <div class="scroll-reveal bg-white/10 backdrop-blur-sm rounded-3xl p-8 sm:p-12 border border-white/10 mb-10">
                <p class="text-navy-200 text-sm font-medium mb-2">SHORT_URL</p>
                <div class="flex items-baseline justify-center gap-2 mb-2">
                    <span class="text-6xl sm:text-7xl font-black text-white">500</span>
                    <span class="text-2xl font-bold text-white">円</span>
                </div>
                <p class="text-navy-300 text-sm mb-8">（税込・買い切り）</p>

                <ul class="text-left max-w-sm mx-auto space-y-3 mb-10">
                    <li class="flex items-center gap-3 text-navy-200 text-sm">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                        月額費用なし・永久ライセンス
                    </li>
                    <li class="flex items-center gap-3 text-navy-200 text-sm">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                        クリック解析機能搭載
                    </li>
                    <li class="flex items-center gap-3 text-navy-200 text-sm">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                        URL作成数 無制限
                    </li>
                    <li class="flex items-center gap-3 text-navy-200 text-sm">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                        無料アップデート対応
                    </li>
                    <li class="flex items-center gap-3 text-navy-200 text-sm">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                        独自ドメインで短縮URL生成
                    </li>
                </ul>

                <!-- Stripe決済ボタン プレースホルダー -->
                <a href="checkout.php" id="checkout-button" class="group inline-flex items-center gap-3 bg-accent hover:bg-accent-hover text-white font-bold text-lg px-12 py-5 rounded-full transition-all duration-300 shadow-xl shadow-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 w-full sm:w-auto justify-center">
                    今すぐ購入して設置する（500円）
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </a>

                <p class="mt-5 text-sm text-navy-400">
                    <i data-lucide="lock" class="w-3.5 h-3.5 inline-block mr-1 -mt-0.5"></i>
                    決済はStripeで安全に行われます
                </p>
            </div>
        </div>
    </section>

    <!-- ===== Footer ===== -->
    <footer class="bg-navy-900 py-10 text-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="#" class="inline-flex items-center gap-2 text-white font-bold text-lg mb-4">
                <i data-lucide="link-2" class="w-5 h-5 text-accent"></i>
                Short_URL
            </a>
            <p class="text-navy-400 text-sm">&copy; 2026 Gamitaka Tools. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
