document.addEventListener('DOMContentLoaded', function() {
    const cartList = document.querySelector('.cart__list');
    const totalPriceEl = document.querySelector('.total-price');

    // Пересчёт итоговой цены (локально)
    function updateCartTotals() {
        let total = 0;
        cartList.querySelectorAll('li').forEach(li => {
            const priceEl = li.querySelector('.product__price p');
            const qtyEl = li.querySelector('.qty_count');
            if(!priceEl || !qtyEl) return;

            const price = parseFloat(priceEl.textContent) || 0;
            const qty = parseInt(qtyEl.textContent) || 0;
            total += price * qty;
        });
        totalPriceEl.textContent = total + ' ₽';
    }

    // Отправка на сервер и обновление шапки
    function updateCartOnServer(productId, qty, action = 'update') {
        if(!productId && action !== 'clear') return;

        const payload = { productId, qty, action };
        fetch(window.BASE_URL + '/actions/cart_update.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(!data.success) {
                console.error('Ошибка сервера:', data.message);
                return;
            }

            // Обновляем локальные данные
            updateCartTotals();

            // Обновляем шапку
            const headerCartCount = document.querySelector('.cart-count');
            if(headerCartCount) headerCartCount.textContent = data.totalQty || 0;
        })
        .catch(err => console.error('Ошибка fetch:', err));
    }

    // Делегирование кликов по списку товаров
    cartList.addEventListener('click', function(e) {
        const li = e.target.closest('li');
        if(!li) return;

        const productCard = li.querySelector('.product__cart-card');
        const productId = productCard ? productCard.dataset.id : null;
        const qtyEl = li.querySelector('.qty_count');

        // +
        if(e.target.classList.contains('qty_plus')) {
            let qty = parseInt(qtyEl.textContent) + 1;
            qtyEl.textContent = qty;
            updateCartOnServer(productId, qty, 'update');
        }

        // −
        if(e.target.classList.contains('qty_minus')) {
            let qty = parseInt(qtyEl.textContent);
            if(qty > 1) {
                qtyEl.textContent = qty - 1;
                updateCartOnServer(productId, qty - 1, 'update');
            } else {
                li.remove();
                updateCartOnServer(productId, 0, 'remove');
            }
        }

        // Удалить
        if(e.target.classList.contains('remove-item')) {
            li.remove();
            updateCartOnServer(productId, 0, 'remove');
        }
    });

    // Очистка корзины
    const clearBtn = document.querySelector('.btn-clear-cart');
    if(clearBtn) {
        clearBtn.addEventListener('click', function() {
            cartList.querySelectorAll('li').forEach(li => li.remove());
            updateCartOnServer(null, 0, 'clear');
        });
    }

    // Инициализация суммы при загрузке
    updateCartTotals();
});
