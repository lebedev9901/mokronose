

<?php $__env->startSection('title', 'Оформление заказа'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

  <div class="checkout">

    <h1 class="section-title">Оформление заказа</h1>

    <div class="checkout-grid">

        <!-- ЛЕВАЯ ЧАСТЬ -->
        <form action="<?php echo e(route('order.confirm')); ?>" method="POST" class="checkout-form"  id="checkout-form">
            <?php echo csrf_field(); ?>

            <!-- КОНТАКТЫ -->
            <div class="checkout-block">
                <h3>Контактные данные</h3>

                <input type="text"
       name="name"
       value="<?php echo e(old('name', auth()->user()->name)); ?>"
       placeholder="Ваше имя"
       required>

<input type="tel"
       name="phone"
       value="<?php echo e(old('phone', auth()->user()->phone)); ?>"
       placeholder="Телефон"
       required>
            </div>

            <!-- ДОСТАВКА -->
            <div class="checkout-block">
                <h3>Доставка</h3>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="pickup">
                    Самовывоз
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="courier">
                    Курьер (Яндекс)
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="cdek">
                    СДЭК
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="post">
                    Почта России
                </label>
            </div>
            <div id="delivery-extra"></div>
            <div id="selected-delivery" style="margin-top:10px;"></div>

            <!-- ОПЛАТА -->
            <div class="checkout-block">
                <h3>Оплата</h3>

                <label class="radio">
                    <input type="radio" name="payment_method" value="cash">
                    Наличными
                </label>

                <label class="radio">
                    <input type="radio" name="payment_method" value="online">
                    Онлайн
                </label>
            </div>
            <script>
                window.userAddresses = <?php echo json_encode(auth()->user()->addresses, 15, 512) ?>;
            </script>
        </form>

        <!-- ПРАВАЯ ЧАСТЬ -->
        <div class="checkout-summary">

            <h3>Ваш заказ</h3>

            <div class="checkout-items">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="checkout-item">
                        <span><?php echo e($item->product->title); ?></span>
                        <span><?php echo e($item->qty); ?> × <?php echo e($item->product->price); ?> ₽</span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div class="checkout-total">
                <span>Итого:</span>
                <strong><?php echo e(number_format($total, 2)); ?> ₽</strong>
            </div>

            <button type="submit" form="checkout-form" class="btn-primary">
                Подтвердить заказ
            </button>

        </div>

    </div>

</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const container = document.getElementById('delivery-extra');
    const selectedBox = document.getElementById('selected-delivery');
    const submitBtn = document.querySelector('button[type="submit"]');

    function clearContainer() {
        container.innerHTML = '';
        selectedBox.innerHTML = '';
        submitBtn.disabled = false;
    }

    // --------------------------
    // COURIER
    // --------------------------
    function renderCourier() {

        if (!window.userAddresses.length) {
            container.innerHTML = `
                <p>У вас нет адресов</p>
                <a href="/profile" class="btn-primary">Добавить адрес</a>
            `;
            submitBtn.disabled = true;
            return;
        }

        const defaultAddress = window.userAddresses.find(a => a.is_default);

        container.innerHTML = `
            <h4>Выберите адрес доставки</h4>

            ${window.userAddresses.map(a => `
                <label class="radio">
                    <input type="radio" name="address_id"
                           value="${a.id}"
                           ${defaultAddress && a.id === defaultAddress.id ? 'checked' : ''}
                           required>

                    ${a.city ?? ''}, ${a.street} ${a.house}

                    ${a.is_default ? '<strong>(Основной)</strong>' : ''}
                </label>
            `).join('')}
        `;

        // сразу показать выбранный (если есть основной)
        if (defaultAddress) {
            renderSelectedAddress(defaultAddress);
        }
    }

    function renderSelectedAddress(a) {
        selectedBox.innerHTML = `
            <div style="padding:10px; border:1px solid #eee; border-radius:8px;">
                <strong>Доставка:</strong><br>
                ${a.city ?? ''}, ${a.street} ${a.house}
                ${a.apartment ? ', кв. ' + a.apartment : ''}
            </div>
        `;
    }

    // --------------------------
    // PICKUP
    // --------------------------
    function renderPickup() {
        container.innerHTML = `
            <h4>Выберите пункт самовывоза</h4>

            <label class="radio">
                <input type="radio" name="pickup_point" value="Ленина 10" required>
                Воронеж, ул. Ленина 10
            </label>

            <label class="radio">
                <input type="radio" name="pickup_point" value="Московский проспект 5">
                Воронеж, Московский проспект 5
            </label>
        `;
    }

    // --------------------------
    // CDEK
    // --------------------------
    function renderCdek() {
        container.innerHTML = `
            <h4>Пункт СДЭК</h4>
            <input type="text" name="cdek_point" placeholder="Введите пункт выдачи" required>
        `;
    }

    // --------------------------
    // POST
    // --------------------------
    function renderPost() {
        container.innerHTML = `
            <h4>Адрес для почты</h4>
            <input type="text" name="post_address" placeholder="Полный адрес" required>
        `;
    }

    // --------------------------
    // SWITCH DELIVERY
    // --------------------------
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

    // --------------------------
    // LISTEN CHANGES
    // --------------------------
    document.addEventListener('change', function(e) {

        // адрес
        if (e.target.name === 'address_id') {
            let a = window.userAddresses.find(x => x.id == e.target.value);
            renderSelectedAddress(a);
        }

        // самовывоз
        if (e.target.name === 'pickup_point') {
            selectedBox.innerHTML = `
                <div style="padding:10px; border:1px solid #eee; border-radius:8px;">
                    <strong>Самовывоз:</strong><br>
                    ${e.target.value}
                </div>
            `;
        }

    });

});

const nameInput = document.querySelector('input[name="name"]');
const phoneInput = document.querySelector('input[name="phone"]');

let timeout;

function autoSave() {

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        fetch('/profile/save-contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: nameInput.value,
                phone: phoneInput.value
            })
        });

    }, 800); // задержка чтобы не спамить

}

nameInput.addEventListener('input', autoSave);
phoneInput.addEventListener('input', autoSave);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/orders/checkout.blade.php ENDPATH**/ ?>