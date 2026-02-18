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

function sendCart(action, wrap) {
    const productId = wrap.dataset.id;

    fetch(window.BASE_URL + '/actions/cart_action.php', {
        method: 'POST',
        body: new URLSearchParams({
            action: action,
            product_id: productId
        })
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;

        const qtyBox = wrap.querySelector('.cart-qty-controls');
        const qtyNum = wrap.querySelector('.qty-number');
        const addBtn = wrap.querySelector('.add-to-cart');

        if (data.qty > 0) {
            qtyBox.style.display = 'flex';
            qtyNum.innerText = data.qty;
            addBtn.style.display = 'none';
        } else {
            qtyBox.style.display = 'none';
            addBtn.style.display = 'inline-block';
        }

        updateCartIcon(data.total_qty);
    });
}

function updateCartIcon(qty) {
    const el = document.querySelector('.cart-count');
    if (el) el.innerText = qty;
}
