// document.addEventListener('click', function (e) {

//     // Добавить в корзину
//     const addBtn = e.target.closest('.add-to-cart');
//     if (addBtn) {
//         const wrap = addBtn.closest('.product-actions');
//         if (!wrap) return;
//         if (typeof sendCart === 'function') sendCart('add', wrap);
//         return;
//     }

//     // Плюс
//     const plusBtn = e.target.closest('.qty-plus');
//     if (plusBtn) {
//         const wrap = plusBtn.closest('.product-actions');
//         if (!wrap) return;
//         if (typeof sendCart === 'function') sendCart('inc', wrap);
//         return;
//     }

//     // Минус
//     const minusBtn = e.target.closest('.qty-minus');
//     if (minusBtn) {
//         const wrap = minusBtn.closest('.product-actions');
//         if (!wrap) return;
//         if (typeof sendCart === 'function') sendCart('dec', wrap);
//         return;
//     }
// });

// function updateCartIcon(qty) {

//     const el = document.getElementById('cart-count');

//     if (!el) return;

//     const n = Number(qty) || 0;

//     el.textContent = n;

//     el.classList.toggle('is-hidden', n <= 0);
// }