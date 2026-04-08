function updateCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
}

// добавление товара
document.addEventListener('click', function (e) {

    let btn = e.target.closest('.add-to-cart');

    if (btn) {
        e.preventDefault();

        let productId = btn.dataset.id;

        fetch(`/cart/add-ajax/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
    }

});

// при загрузке страницы
document.addEventListener('DOMContentLoaded', updateCartCount);
