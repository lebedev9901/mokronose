function updateCartIcon(qty) {
    const el = document.getElementById('cart-count');

    if (!el) return;

    qty = Number(qty) || 0;

    el.innerText = qty;
    el.classList.toggle('is-hidden', qty <= 0);
}

function fetchCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => updateCartIcon(data.count))
        .catch(() => {});
}

async function sendCartRequest(url) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        }
    });

    return await response.json();
}

document.addEventListener('click', async function (e) {
    const addBtn = e.target.closest('.add-to-cart');
    const plusBtn = e.target.closest('.qty-plus');
    const minusBtn = e.target.closest('.qty-minus');

    if (!addBtn && !plusBtn && !minusBtn) return;

    e.preventDefault();

    if (addBtn) {
        const id = addBtn.dataset.id;
        const wrapper = addBtn.closest('.product-cart-control') || addBtn.closest('.product-actions');

        if (!id || !wrapper) return;

        const qtyBlock = wrapper.querySelector('.cart-qty-control');
        const qtyValue = wrapper.querySelector('.qty-value');

        const data = await sendCartRequest('/cart/add/' + id);

        updateCartIcon(data.cart_count);

        if (qtyValue) qtyValue.textContent = data.qty;
        if (qtyBlock) qtyBlock.classList.remove('hidden');

        addBtn.style.display = 'none';

        return;
    }

    if (plusBtn) {
        const wrapper = plusBtn.closest('.product-cart-control') || plusBtn.closest('.product-actions');

        if (!wrapper) return;

        const id = wrapper.dataset.product || plusBtn.dataset.id;
        const qtyValue = wrapper.querySelector('.qty-value');

        if (!id) return;

        const data = await sendCartRequest('/cart/increase/' + id);

        updateCartIcon(data.cart_count);

        if (qtyValue) qtyValue.textContent = data.qty;

        return;
    }

    if (minusBtn) {
        const wrapper = minusBtn.closest('.product-cart-control') || minusBtn.closest('.product-actions');

        if (!wrapper) return;

        const id = wrapper.dataset.product || minusBtn.dataset.id;
        const qtyValue = wrapper.querySelector('.qty-value');
        const qtyBlock = wrapper.querySelector('.cart-qty-control');
        const addBtnInside = wrapper.querySelector('.add-to-cart');

        if (!id) return;

        const data = await sendCartRequest('/cart/decrease/' + id);

        updateCartIcon(data.cart_count);

        if (data.qty <= 0) {
            if (qtyBlock) qtyBlock.classList.add('hidden');
            if (addBtnInside) addBtnInside.style.display = 'block';
            if (qtyValue) qtyValue.textContent = 1;
            return;
        }

        if (qtyValue) qtyValue.textContent = data.qty;
    }
});

document.addEventListener('DOMContentLoaded', fetchCartCount);

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('newsModal');

    if (!modal) return;

    const image = document.getElementById('newsModalImage');
    const title = document.getElementById('newsModalTitle');
    const text = document.getElementById('newsModalText');
    const date = document.getElementById('newsModalDate');
    const button = document.getElementById('newsModalButton');

    document.querySelectorAll('.stories-news__item').forEach(item => {
        item.addEventListener('click', () => {
            if (image) {
                image.src = item.dataset.newsImage || '';
                image.alt = item.dataset.newsTitle || '';
            }

            if (title) title.textContent = item.dataset.newsTitle || '';
            if (text) text.textContent = item.dataset.newsText || '';
            if (date) date.textContent = item.dataset.newsDate || '';

            if (button) {
                if (item.dataset.newsButtonText && item.dataset.newsButtonUrl) {
                    button.textContent = item.dataset.newsButtonText;
                    button.href = item.dataset.newsButtonUrl;
                    button.style.display = 'inline-flex';
                } else {
                    button.style.display = 'none';
                }
            }

            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeNewsModal() {
        modal.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-news-close]').forEach(btn => {
        btn.addEventListener('click', closeNewsModal);
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeNewsModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.stories-news__list').forEach(slider => {
        slider.addEventListener('wheel', function (e) {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                slider.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('headerBurger');
    const menu = document.getElementById('headerMenu');

    if (!burger || !menu) return;

    burger.addEventListener('click', () => {
        burger.classList.toggle('is-active');
        menu.classList.toggle('is-active');
    });

    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            burger.classList.remove('is-active');
            menu.classList.remove('is-active');
        });
    });
});
function loadNotificationCount() {
    const count = document.getElementById('notificationCount');

    if (!count) return;

    fetch('/notifications/count')
        .then(res => res.json())
        .then(data => {
            count.innerText = data.count;
            count.classList.toggle('is-hidden', parseInt(data.count) <= 0);
        })
        .catch(() => {});
}

function getNotificationIcon(type) {
    if (type === 'support_message') return '💬';
    if (type === 'new_order') return '🛒';
    if (type === 'order_status') return '📦';

    return '🔔';
}

function loadNotifications() {
    const list = document.getElementById('notificationList');

    if (!list) return;

    fetch('/notifications/list')
        .then(res => res.json())
        .then(data => {
            if (!data.notifications.length) {
                list.innerHTML = '<div class="notification-empty">Уведомлений нет</div>';
                return;
            }

            list.innerHTML = data.notifications.map(item => `
                <a href="${item.url}" class="notification-item" data-id="${item.id}">
                    <div class="notification-item__icon">${getNotificationIcon(item.type)}</div>
                    <div class="notification-item__body">
                        <strong>${item.title}</strong>
                        <span>${item.message}</span>
                        <small>${item.created_at}</small>
                    </div>
                </a>
            `).join('');
        })
        .catch(() => {
            list.innerHTML = '<div class="notification-empty">Ошибка загрузки</div>';
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadNotificationCount();

    setInterval(loadNotificationCount, 5000);

    const btn = document.getElementById('notificationBtn');
    const dropdown = document.getElementById('notificationDropdown');
    const readAll = document.getElementById('notificationReadAll');

    if (btn && dropdown) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('active');
            loadNotifications();
        });
    }

    if (readAll) {
        readAll.addEventListener('click', () => {
            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => {
                loadNotificationCount();
                loadNotifications();
            });
        });
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.notification-widget')) {
            dropdown?.classList.remove('active');
        }
    });
});