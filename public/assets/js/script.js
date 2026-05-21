function updateCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
}


document.addEventListener('click', async function (e) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    async function send(url) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            }
        });

        return await response.json();
    }

    const addBtn = e.target.closest('.add-to-cart');

    if (addBtn) {
        const id = addBtn.dataset.id;
        const wrapper = addBtn.closest('.product-cart-control');
        const qtyBlock = wrapper.querySelector('.cart-qty-control');
        const qtyValue = wrapper.querySelector('.qty-value');

        const data = await send('/cart/add/' + id);
        updateCartCount(data.cart_count);
        qtyValue.textContent = data.qty;
        addBtn.style.display = 'none';
        qtyBlock.classList.remove('hidden');

        return;
    }

    const plusBtn = e.target.closest('.qty-plus');

    if (plusBtn) {
        const wrapper = plusBtn.closest('.product-cart-control');
        const id = wrapper.dataset.product;
        const qtyValue = wrapper.querySelector('.qty-value');

        const data = await send('/cart/increase/' + id);
        updateCartCount(data.cart_count);
        qtyValue.textContent = data.qty;

        return;
    }

    const minusBtn = e.target.closest('.qty-minus');

    if (minusBtn) {
        const wrapper = minusBtn.closest('.product-cart-control');
        const id = wrapper.dataset.product;
        const qtyValue = wrapper.querySelector('.qty-value');
        const qtyBlock = wrapper.querySelector('.cart-qty-control');
        const addBtn = wrapper.querySelector('.add-to-cart');

        const data = await send('/cart/decrease/' + id);
        updateCartCount(data.cart_count);
        if (data.qty <= 0) {
            qtyBlock.classList.add('hidden');
            addBtn.style.display = 'block';
            qtyValue.textContent = 1;
            return;
        }

        qtyValue.textContent = data.qty;
    }
});

// при загрузке страницы
document.addEventListener('DOMContentLoaded', updateCartCount);
