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
});
