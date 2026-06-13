document.addEventListener('click', function (e) {

    // Добавить в корзину
    if (e.target.classList.contains('add-to-cart')) {
        const wrap = e.target.closest('.product-actions');
        sendCart('add', wrap);
    }

    // Плюс
    if (e.target.classList.contains('qty-plus')) {
        const wrap = e.target.closest('.product-actions');
        sendCart('inc', wrap);
    }

    // Минус
    if (e.target.classList.contains('qty-minus')) {
        const wrap = e.target.closest('.product-actions');
        sendCart('dec', wrap);
    }
});

function updateCartIcon(qty) {

    const el = document.getElementById('cart-count');

    if (!el) return;

    el.innerText = qty;

    el.classList.toggle('is-hidden', parseInt(qty) <= 0);
}