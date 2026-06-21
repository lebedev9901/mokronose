<?php $__env->startSection('title', 'Оформление заказа'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="checkout-page">

        
        <div class="checkout-left">

            <form id="checkout-form"
                  action="<?php echo e(route('order.confirm')); ?>"
                  method="POST">

                <?php echo csrf_field(); ?>

                
                <div class="checkout-card">

                    <h2>Контактные данные</h2>

                    <div class="form-group">
                        <label>Имя</label>

                        <input type="text"
                               name="name"
                               value="<?php echo e(auth()->user()->name ?? ''); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Телефон</label>

                        <input type="text"
                               name="phone"
                               value="<?php echo e(auth()->user()->phone ?? ''); ?>"
                               required>
                    </div>

                </div>

                
                <div class="checkout-card">

                    <h2>Способ доставки</h2>

                    <div class="delivery-methods">

                        <label class="delivery-card">
                            <input type="radio"
                                   name="delivery_method"
                                   value="courier"
                                   required>

                            <span>Курьер</span>
                        </label>

                        <label class="delivery-card">
                            <input type="radio"
                                   name="delivery_method"
                                   value="pickup">

                            <span>Самовывоз</span>
                        </label>

                        <label class="delivery-card">
                            <input type="radio"
                                   name="delivery_method"
                                   value="cdek">

                            <span>СДЭК</span>
                        </label>

                        <label class="delivery-card">
                            <input type="radio"
                                   name="delivery_method"
                                   value="post">

                            <span>Почта</span>
                        </label>

                    </div>

                    
                    <div id="delivery-extra"></div>

                    
                    <div id="selected-delivery"></div>

                </div>

                
                <div class="checkout-card">

                    <h2>Комментарий к заказу</h2>

                    <textarea name="comment"
                              rows="4"
                              placeholder="Например: позвонить за час"></textarea>

                </div>

                
                <div class="checkout-card">

                    <h2>Оплата</h2>

                    <div class="payment-methods">

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="card"
                                   checked>

                            <span>Картой</span>
                        </label>

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="cash">

                            <span>Наличными</span>
                        </label>

                    </div>

                </div>

            </form>

        </div>

        
        <div class="checkout-right">

            <div class="checkout-summary">

                <h2>Ваш заказ</h2>

                <div class="checkout-items">

                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="checkout-item">

                            <div class="checkout-item-info">

                                <?php
                                    $preview = $item->product->images
                                        ->where('is_preview', 1)
                                        ->first();
                                ?>

                                <?php if($preview): ?>
                                    <img src="<?php echo e(asset('storage/' . $preview->image)); ?>">
                                <?php endif; ?>

                                <div>
                                    <div class="title">
                                        <?php echo e($item->product->title); ?>

                                    </div>

                                    <div class="qty">
                                        <?php echo e($item->qty); ?> шт
                                    </div>
                                </div>

                            </div>

                            <div class="price">
                                <?php echo e(number_format($item->product->price * $item->qty, 2)); ?> ₽
                            </div>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <div class="checkout-total">

                    <span>Итого:</span>

                    <strong>
                        <?php echo e(number_format($total, 2)); ?> ₽
                    </strong>

                </div>

                <button type="submit"
                        form="checkout-form"
                        class="checkout-submit">

                    Подтвердить заказ

                </button>

            </div>

        </div>

    </div>

</div>
<div class="map-modal" id="mapModal">
    <div class="map-modal__overlay" id="closeMapModal"></div>

    <div class="map-modal__content">
        <div class="map-modal__head">
            <div>
                <h3>Выберите адрес на карте</h3>
                <p>Кликните по нужному месту, адрес подставится автоматически</p>
            </div>

            <button type="button" id="closeMapModalBtn">✕</button>
        </div>

        <div id="checkoutMap" class="checkout-map"></div>

        <button type="button" class="map-modal__save" id="saveMapAddress">
            Использовать этот адрес
        </button>
    </div>
</div>
<div class="address-modal" id="addressModal">
    <div class="address-modal__overlay" id="closeAddressModal"></div>

    <div class="address-modal__content">
        <div class="address-modal__head">
            <h3>Добавить адрес</h3>
            <button type="button" id="closeAddressModalBtn">✕</button>
        </div>

        <form id="addressAjaxForm">
            <?php echo csrf_field(); ?>

            <input type="text" name="city" placeholder="Город">

            <input type="text" name="street" placeholder="Улица" required>

            <input type="text" name="house" placeholder="Дом" required>

            <input type="text" name="apartment" placeholder="Квартира">

            <button type="submit">Сохранить адрес</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
window.userAddresses = <?php echo json_encode(auth()->user()->addresses ?? [], 15, 512) ?>;

let checkoutMap = null;
let checkoutPlacemark = null;
let selectedMapAddress = '';
let selectedTargetInput = null;

document.addEventListener('DOMContentLoaded', function () {
    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const container = document.getElementById('delivery-extra');
    const selectedBox = document.getElementById('selected-delivery');
    const submitBtn = document.querySelector('.checkout-submit');
    const addressModal = document.getElementById('addressModal');

    function clearContainer() {
        container.innerHTML = '';
        selectedBox.innerHTML = '';
        submitBtn.disabled = false;
    }

    function formatAddress(a) {
    let parts = [];

    if (a.city) parts.push(a.city);
    if (a.street) parts.push(a.street);
    if (a.house) parts.push('д. ' + a.house);
    if (a.apartment) parts.push('кв. ' + a.apartment);

    return parts.join(', ');
}

    function renderSelectedAddress(a) {
        if (!a) {
            selectedBox.innerHTML = '';
            return;
        }

        selectedBox.innerHTML = `
            <div class="selected-delivery-box">
                <strong>Выбран адрес:</strong>
                <p>${formatAddress(a)}</p>
            </div>
        `;
    }

    function renderCourier() {
        const defaultAddress = window.userAddresses.find(a => a.is_default) ?? window.userAddresses[0];

        container.innerHTML = `
            <div class="delivery-box delivery-box--service">
                <div class="delivery-service-head">
                    <div>
                        <h4>Адрес курьерской доставки</h4>
                        <p>Выберите сохранённый адрес или добавьте новый</p>
                    </div>
                </div>

                <div class="checkout-addresses">
                    ${window.userAddresses.length ? window.userAddresses.map(a => `
                        <label class="checkout-address-card">
                            <input
                                type="radio"
                                name="address_id"
                                value="${a.id}"
                                ${defaultAddress && a.id === defaultAddress.id ? 'checked' : ''}
                            >

                            <div>
                                <strong>${a.title ?? 'Адрес доставки'}</strong>
                                <p>${formatAddress(a)}</p>
                            </div>
                        </label>
                    `).join('') : `
                        <div class="empty-address">
                            У вас пока нет сохранённых адресов
                        </div>
                    `}
                </div>

                <button type="button" class="add-address-btn" id="openAddressModal">
                    + Добавить адрес
                </button>
            </div>
        `;

        submitBtn.disabled = !window.userAddresses.length;

        if (defaultAddress) {
            renderSelectedAddress(defaultAddress);
        }
    }

    function renderPickup() {
        container.innerHTML = `
            <div class="delivery-box delivery-box--service">
                <div class="delivery-service-head">
                    <div>
                        <h4>Пункт самовывоза</h4>
                        <p>Выберите удобный пункт выдачи заказа</p>
                    </div>
                </div>

                <div class="checkout-addresses">
                    <label class="checkout-address-card">
                        <input
                            type="radio"
                            name="pickup_point"
                            value="Подольск, п. Железнодорожный, 28"
                            required
                        >

                        <div>
                            <strong>Подольск</strong>
                            <p>п. Железнодорожный, 28</p>
                        </div>
                    </label>

                    <label class="checkout-address-card">
                        <input
                            type="radio"
                            name="pickup_point"
                            value="Москва, ул. Братеевская 16к3"
                            required
                        >

                        <div>
                            <strong>Москва</strong>
                            <p>ул. Братеевская 16к3</p>
                        </div>
                    </label>
                </div>
            </div>
        `;
    }

    function renderCdek() {
        container.innerHTML = `
            <div class="delivery-box delivery-box--service">
                <div class="delivery-service-head">
                    <div>
                        <h4>Пункт выдачи СДЭК</h4>
                        <p>Введите адрес пункта выдачи или выберите его на карте</p>
                    </div>
                </div>

                <div class="delivery-address-row">
                    <input
                        type="text"
                        name="cdek_point"
                        id="cdek_point"
                        placeholder="Например: Москва, ул. Ленина, 10"
                        required
                    >

                    <button type="button" class="delivery-map-btn" data-target="cdek_point">
                        Выбрать на карте
                    </button>
                </div>
            </div>
        `;
    }

    function renderPost() {
        container.innerHTML = `
            <div class="delivery-box delivery-box--service">
                <div class="delivery-service-head">
                    <div>
                        <h4>Адрес доставки Почтой России</h4>
                        <p>Введите полный почтовый адрес или выберите точку на карте</p>
                    </div>
                </div>

                <div class="delivery-address-row">
                    <textarea
                        name="post_address"
                        id="post_address"
                        placeholder="Индекс, город, улица, дом, квартира"
                        required
                    ></textarea>

                    <button type="button" class="delivery-map-btn" data-target="post_address">
                        Выбрать на карте
                    </button>
                </div>
            </div>
        `;
    }

    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            clearContainer();

            switch (this.value) {
                case 'courier':
                    renderCourier();
                    break;

                case 'pickup':
                    renderPickup();
                    break;

                case 'cdek':
                    renderCdek();
                    break;

                case 'post':
                    renderPost();
                    break;
            }
        });
    });

    document.addEventListener('change', function(e) {
        if (e.target.name === 'address_id') {
            const address = window.userAddresses.find(x => x.id == e.target.value);
            renderSelectedAddress(address);
        }
    });

    document.addEventListener('click', function(e) {
        const openAddressBtn = e.target.closest('#openAddressModal');

        if (!openAddressBtn) return;

        addressModal.classList.add('is-active');
    });

    document.getElementById('closeAddressModal')?.addEventListener('click', closeAddressModal);
    document.getElementById('closeAddressModalBtn')?.addEventListener('click', closeAddressModal);

    function closeAddressModal() {
        addressModal.classList.remove('is-active');
    }

    document.getElementById('addressAjaxForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch('<?php echo e(route('checkout.address.store')); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        
            .then(data => {
                const address = data.address;

                window.userAddresses.push(address);

                renderCourier();

                setTimeout(() => {
                    const radio = document.querySelector(`input[name="address_id"][value="${address.id}"]`);

                    if (radio) {
                        radio.checked = true;
                        renderSelectedAddress(address);
                    }
                }, 50);

                form.reset();
                closeAddressModal();
            
        });
    });
});

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delivery-map-btn');

    if (!btn) return;

    selectedTargetInput = document.getElementById(btn.dataset.target);

    openCheckoutMap();
});

function openCheckoutMap() {
    document.getElementById('mapModal').classList.add('is-active');

    setTimeout(() => {
        if (!checkoutMap) {
            initCheckoutMap();
        } else {
            checkoutMap.container.fitToViewport();
        }
    }, 200);
}

function closeCheckoutMap() {
    document.getElementById('mapModal').classList.remove('is-active');
}

document.getElementById('closeMapModal')?.addEventListener('click', closeCheckoutMap);
document.getElementById('closeMapModalBtn')?.addEventListener('click', closeCheckoutMap);

function initCheckoutMap() {
    ymaps.ready(function () {
        checkoutMap = new ymaps.Map('checkoutMap', {
            center: [55.751244, 37.618423],
            zoom: 10,
            controls: ['zoomControl', 'searchControl']
        });

        checkoutMap.events.add('click', function (e) {
            setMapPoint(e.get('coords'));
        });
    });
}

function setMapPoint(coords) {
    if (checkoutPlacemark) {
        checkoutPlacemark.geometry.setCoordinates(coords);
    } else {
        checkoutPlacemark = new ymaps.Placemark(coords, {}, {
            preset: 'islands#brownDotIcon',
            draggable: true
        });

        checkoutMap.geoObjects.add(checkoutPlacemark);

        checkoutPlacemark.events.add('dragend', function () {
            getAddressByCoords(checkoutPlacemark.geometry.getCoordinates());
        });
    }

    getAddressByCoords(coords);
}

function getAddressByCoords(coords) {
    ymaps.geocode(coords).then(function (res) {
        const firstGeoObject = res.geoObjects.get(0);

        if (!firstGeoObject) return;

        selectedMapAddress = firstGeoObject.getAddressLine();
    });
}

document.getElementById('saveMapAddress')?.addEventListener('click', function () {
    if (!selectedTargetInput || !selectedMapAddress) {
        alert('Сначала выберите точку на карте');
        return;
    }

    selectedTargetInput.value = selectedMapAddress;
    closeCheckoutMap();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/orders/checkout.blade.php ENDPATH**/ ?>