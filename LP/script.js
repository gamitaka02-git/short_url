/**
 * Short_URL LP - JavaScript
 */
document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // 1. Lucide Icons の初期化
    // =============================================
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // =============================================
    // 2. スクロールリビールアニメーション
    // =============================================
    const revealElements = document.querySelectorAll('.scroll-reveal');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => {
        revealObserver.observe(el);
    });

    // =============================================
    // 3. ナビゲーションバーのスクロール影
    // =============================================
    const nav = document.getElementById('site-nav');

    const handleNavScroll = () => {
        if (window.scrollY > 10) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', handleNavScroll, { passive: true });
    handleNavScroll();

    // =============================================
    // 4. FAQ アコーディオン
    // =============================================
    const faqToggles = document.querySelectorAll('.faq-toggle');

    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const faqItem = toggle.closest('.faq-item');
            const content = faqItem.querySelector('.faq-content');
            const isOpen = faqItem.classList.contains('is-open');

            // 他のFAQ項目を閉じる
            document.querySelectorAll('.faq-item.is-open').forEach(openItem => {
                if (openItem !== faqItem) {
                    openItem.classList.remove('is-open');
                    const openContent = openItem.querySelector('.faq-content');
                    openContent.style.maxHeight = '0'; // 修正: 数値または文字列で0を指定
                    openItem.querySelector('.faq-toggle').setAttribute('aria-expanded', 'false');
                }
            });

            // 対象のFAQ項目をトグル
            if (isOpen) {
                faqItem.classList.remove('is-open');
                content.style.maxHeight = '0';
                toggle.setAttribute('aria-expanded', 'false');
            } else {
                faqItem.classList.add('is-open');
                content.style.maxHeight = content.scrollHeight + 'px';
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // =============================================
    // 5. CTAボタンの連打防止
    // =============================================
    const ctaButtons = document.querySelectorAll('#checkout-button, #hero-cta-button');

    ctaButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            console.log('Redirecting to Stripe Checkout...');

            // 連打防止
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.7';
            button.innerHTML = `
                <svg class="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                処理中...
            `;
        });
    });

    // =============================================
    // 6. スムーズスクロール（アンカーリンク）
    // =============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const navHeight = nav.offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - navHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // =============================================
    // 7. Network Particles Animation (Multiple Canvases Support)
    // =============================================
    const canvases = document.querySelectorAll('.network-canvas');
    canvases.forEach(canvas => {
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];
        let mouse = { x: null, y: null, radius: 150 };

        // サイズ調整
        const resize = () => {
            const parent = canvas.parentElement;
            width = parent.offsetWidth;
            height = parent.offsetHeight;
            canvas.width = width;
            canvas.height = height;
            initParticles();
        };

        // デバウンス付きリサイズイベント
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(resize, 200);
        });

        // マウストラッキング
        canvas.parentElement.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });

        canvas.parentElement.addEventListener('mouseleave', () => {
            mouse.x = null;
            mouse.y = null;
        });

        // 粒子クラス
        class Particle {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 0.6; // 非常にゆっくり
                this.vy = (Math.random() - 0.5) * 0.6;
                this.radius = Math.random() * 1.5 + 0.5;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;

                // 画面端でループ
                if (this.x < 0) this.x = width;
                if (this.x > width) this.x = 0;
                if (this.y < 0) this.y = height;
                if (this.y > height) this.y = 0;

                // マウスからの反発効果
                if (mouse.x !== null && mouse.y !== null) {
                    const dx = mouse.x - this.x;
                    const dy = mouse.y - this.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < mouse.radius) {
                        const forceDirectionX = dx / distance;
                        const forceDirectionY = dy / distance;
                        const force = (mouse.radius - distance) / mouse.radius;
                        // カーソルから遠ざかるように微調整
                        this.x -= forceDirectionX * force * 1.5;
                        this.y -= forceDirectionY * force * 1.5;
                    }
                }
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.4)'; // 控えめな不透明度
                ctx.fill();
            }
        }

        // 粒子の初期化
        const initParticles = () => {
            particles = [];
            // 画面サイズに応じて粒子数を調整（最大100個程度で負荷低減）
            let numParticles = Math.floor((width * height) / 12000);
            if (numParticles > 100) numParticles = 100;
            if (numParticles < 40) numParticles = 40;
            
            for (let i = 0; i < numParticles; i++) {
                particles.push(new Particle());
            }
        };

        // アニメーションループ
        const animate = () => {
            ctx.clearRect(0, 0, width, height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();

                // 近くの粒子同士を線で結ぶ
                for (let j = i; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 120) {
                        ctx.beginPath();
                        // 距離が近いほど線を濃くする（最大opacity 0.15程度）
                        ctx.strokeStyle = `rgba(255, 255, 255, ${0.15 - distance / 800})`;
                        ctx.lineWidth = 0.5;
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        };

        // 初回起動
        resize();
        animate();
    });
});
