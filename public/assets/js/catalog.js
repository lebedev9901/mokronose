// document.addEventListener("DOMContentLoaded", function() {
//     let categoryFilter = 'all';
//     let ratingFilter = 'all';
//     let minPrice = 0;
//     let maxPrice = Infinity;
//     let priceSort = ''; // 'asc' или 'desc'

//     const catalogGrid = document.querySelector('.catalog-grid');

//     const updateProducts = () => {
//         document.querySelectorAll('.product-card').forEach(card => {
//             const categories = card.dataset.category.split(',');
//             const rating = parseInt(card.dataset.rating);
//             const price = parseFloat(card.dataset.price);

//             const categoryMatch = (categoryFilter === 'all') || categories.includes(categoryFilter);
//             const ratingMatch = (ratingFilter === 'all') || rating === parseInt(ratingFilter);
//             const priceMatch = price >= minPrice && price <= maxPrice;

//             card.style.display = (categoryMatch && ratingMatch && priceMatch) ? 'block' : 'none';
//         });

//         // Сортировка после фильтрации
//         if (priceSort) {
//             const cards = Array.from(catalogGrid.children)
//                 .filter(card => card.style.display !== 'none'); // сортируем только видимые
//             if (priceSort === 'asc') {
//                 cards.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
//             } else if (priceSort === 'desc') {
//                 cards.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
//             }
//             cards.forEach(card => catalogGrid.appendChild(card));
//         }
//     }

//     // Категории
//     document.querySelectorAll('[data-filter-category]').forEach(btn => {
//         btn.addEventListener('click', () => {
//             categoryFilter = btn.dataset.filterCategory;
//             document.querySelectorAll('[data-filter-category]').forEach(b => b.classList.remove('active'));
//             btn.classList.add('active');
//             updateProducts();
//         });
//     });

//     // Рейтинг
//     document.querySelectorAll('[data-filter-rating]').forEach(btn => {
//         btn.addEventListener('click', () => {
//             ratingFilter = btn.dataset.filterRating;
//             document.querySelectorAll('[data-filter-rating]').forEach(b => b.classList.remove('active'));
//             btn.classList.add('active');
//             updateProducts();
//         });
//     });

//     // Сортировка по цене с классом active
//     const priceButtons = document.querySelectorAll('#sort-price-asc, #sort-price-desc');
//     priceButtons.forEach(btn => {
//         btn.addEventListener('click', () => {
//             priceButtons.forEach(b => b.classList.remove('active'));
//             btn.classList.add('active');
//             priceSort = btn.id === 'sort-price-asc' ? 'asc' : 'desc';
//             updateProducts();
//         });
//     });

//     updateProducts(); // показать все при загрузке
// });
