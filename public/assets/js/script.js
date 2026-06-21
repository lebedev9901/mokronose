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
        .then(data => updateCartIcon(data.count ?? data.cart_count ?? 0))
        .catch(() => {});
}

async function sendCartRequest(url) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    });

    const contentType = response.headers.get('content-type') || '';

    if (!contentType.includes('application/json')) {
        const text = await response.text();
        console.error('Ожидали JSON, пришёл HTML:', response.status, text);
        return null;
    }

    const data = await response.json();

    if (!response.ok || data.ok === false) {
        console.error('Cart request error:', data);
        return null;
    }

    return data;
}

function updateProductCartControl(wrapper, qty) {
    const qtyBlock = wrapper.querySelector('.cart-qty-control');
    const qtyValue = wrapper.querySelector('.qty-value');
    const addBtn = wrapper.querySelector('.add-to-cart');

    qty = Number(qty) || 0;

    if (qty <= 0) {
        if (qtyBlock) qtyBlock.classList.add('hidden');
        if (qtyValue) qtyValue.textContent = 1;

        if (addBtn) {
            addBtn.style.display = 'inline-flex';
        }

        return;
    }

    if (qtyValue) qtyValue.textContent = qty;
    if (qtyBlock) qtyBlock.classList.remove('hidden');

    if (addBtn) {
        addBtn.style.display = 'none';
    }
}

document.addEventListener('click', async function (e) {
    const addBtn = e.target.closest('.add-to-cart');
    const plusBtn = e.target.closest('.qty-plus');
    const minusBtn = e.target.closest('.qty-minus');

    if (!addBtn && !plusBtn && !minusBtn) return;

    const wrapper =
        e.target.closest('.product-cart-control') ||
        e.target.closest('.product-actions');

    if (!wrapper) return;

    e.preventDefault();

    const id =
        wrapper.dataset.product ||
        addBtn?.dataset.id ||
        plusBtn?.dataset.id ||
        minusBtn?.dataset.id;

    if (!id) return;

    let url = '';

    if (addBtn) {
        url = '/cart/add/' + id;
    }

    if (plusBtn) {
        url = '/cart/increase/' + id;
    }

    if (minusBtn) {
        url = '/cart/decrease/' + id;
    }

    const data = await sendCartRequest(url);

    if (!data) return;

    updateCartIcon(data.cart_count ?? data.count ?? 0);
    updateProductCartControl(wrapper, data.qty ?? 0);
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
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

document.addEventListener('DOMContentLoaded', () => {
    const orderModal = document.getElementById('orderNoticeModal');
    const vkModal = document.getElementById('vkNoticeModal');

    if (!orderModal || !vkModal) return;

    const alreadySeen = localStorage.getItem('mokronos_site_notices_seen');

    if (alreadySeen === '1') return;

    function openModal(modal) {
        modal.classList.add('is-active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modal) {
        modal.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    function showVkModal() {
        setTimeout(() => {
            openModal(vkModal);
        }, 250);
    }

    setTimeout(() => {
        openModal(orderModal);
    }, 600);

    document.querySelectorAll('[data-notice-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(orderModal);
            showVkModal();
        });
    });

    document.querySelectorAll('[data-vk-notice-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(vkModal);
            localStorage.setItem('mokronos_site_notices_seen', '1');
        });
    });

    document.addEventListener('keydown', event => {
        if (event.key !== 'Escape') return;

        if (orderModal.classList.contains('is-active')) {
            closeModal(orderModal);
            showVkModal();
            return;
        }

        if (vkModal.classList.contains('is-active')) {
            closeModal(vkModal);
            localStorage.setItem('mokronos_site_notices_seen', '1');
        }
    });
});