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

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                        <div class="checkout-item">

                            <div class="checkout-item-info">

                                <?php
                                    $preview = $item->product->images
                                        ->where('is_preview', 1)
                                        ->first();
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preview): ?>
                                    <img src="<?php echo e(asset('storage/' . $preview->image)); ?>">
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>

window.userAddresses = <?php echo json_encode(auth()->user()->addresses ?? [], 15, 512) ?>;

document.addEventListener('DOMContentLoaded', function () {

    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');

    const container = document.getElementById('delivery-extra');

    const selectedBox = document.getElementById('selected-delivery');

    const submitBtn = document.querySelector('.checkout-submit');

    function clearContainer() {

        container.innerHTML = '';
        selectedBox.innerHTML = '';

        submitBtn.disabled = false;

    }

    // COURIER
    function renderCourier() {

        if (!window.userAddresses.length) {

            container.innerHTML = `
                <div class="empty-address">
                    У вас нет адресов
                    <br><br>
                    <a href="/profile" class="btn-add-address">
                        Добавить адрес
                    </a>
                </div>
            `;

            submitBtn.disabled = true;

            return;
        }

        const defaultAddress = window.userAddresses.find(a => a.is_default);

        container.innerHTML = `
            <div class="delivery-box">

                <h4>Выберите адрес</h4>

                ${window.userAddresses.map(a => `
                    <label class="radio-item">

                        <input type="radio"
                               name="address_id"
                               value="${a.id}"
                               ${defaultAddress && a.id === defaultAddress.id ? 'checked' : ''}>

                        ${a.city ?? ''}, ${a.street} ${a.house}

                    </label>
                `).join('')}

            </div>
        `;

        if (defaultAddress) {
            renderSelectedAddress(defaultAddress);
        }

    }

    function renderSelectedAddress(a) {

        selectedBox.innerHTML = `
            <div class="selected-delivery-box">

                <strong>Доставка:</strong><br>

                ${a.city ?? ''},
                ${a.street} ${a.house}

            </div>
        `;

    }

    // PICKUP
    function renderPickup() {

        container.innerHTML = `
            <div class="delivery-box">

                <label class="radio-item">
                    <input type="radio"
                           name="pickup_point"
                           value="Воронеж, Ленина 10">

                    Воронеж, Ленина 10
                </label>

                <label class="radio-item">
                    <input type="radio"
                           name="pickup_point"
                           value="Воронеж, Московский проспект 5">

                    Воронеж, Московский проспект 5
                </label>

            </div>
        `;

    }

    // CDEK
    function renderCdek() {

        container.innerHTML = `
            <div class="delivery-box">

                <input type="text"
                       name="cdek_point"
                       placeholder="Введите пункт СДЭК">

            </div>
        `;

    }

    // POST
    function renderPost() {

        container.innerHTML = `
            <div class="delivery-box">

                <textarea name="post_address"
                          placeholder="Введите адрес"></textarea>

            </div>
        `;

    }

    // SWITCH
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

    // LISTENER
    document.addEventListener('change', function(e) {

        if (e.target.name === 'address_id') {

            let a = window.userAddresses.find(x => x.id == e.target.value);

            renderSelectedAddress(a);

        }

    });

});

</script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/orders/checkout.blade.php ENDPATH**/ ?>