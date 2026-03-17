document.addEventListener('DOMContentLoaded', () => {
    const checkoutButton = document.getElementById('checkout-button');

    if (checkoutButton) {
        checkoutButton.addEventListener('click', (e) => {
            // クリック時のフィードバック（必要に応じて）
            console.log('Redirecting to Stripe Checkout...');
            
            // ボタンの連打防止
            checkoutButton.style.pointerEvents = 'none';
            checkoutButton.style.opacity = '0.7';
            checkoutButton.textContent = '処理中...';
        });
    }
});
