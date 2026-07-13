


<?php $__env->startSection('title', 'Корзина товаров'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="cart flex">

    <h1 class="section-title">Корзина</h1>

    <?php if($items->isEmpty()): ?>
        <div class="cart-empty">
            <p>Корзина пуста</p>
            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">Перейти в каталог</a>
        </div>
        <?php if($recommendedProducts->count()): ?>
    <section class="cart-recommendations">

        <div class="profile-section-head">
            <div>
                <h2>🐾 Возможно, вам подойдёт</h2>
                <p>Подборка товаров для быстрого старта</p>
            </div>
        </div>

        <div class="recommendations-grid">
            <?php $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                ?>

                <a href="<?php echo e(route('product', $product->id)); ?>" class="recommendation-card">
                    <img
                        src="<?php echo e($preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png')); ?>"
                        alt="<?php echo e($product->title); ?>"
                    >

                    <div>
                        <h3><?php echo e($product->title); ?></h3>
                        <p><?php echo e(number_format($product->price, 0, '.', ' ')); ?> ₽</p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </section>
<?php endif; ?>
    <?php else: ?>

    <div class="cart-grid">

        <!-- ТОВАРЫ -->
        <div class="cart-items">

            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="cart-item" id="cart-item-<?php echo e($item->id); ?>">

                <div class="cart-item__info">
                    <h3><?php echo e($item->product->title); ?></h3>
                    <p><?php echo e(number_format($item->product->price, 2)); ?> ₽</p>
                </div>

                <!-- КОЛИЧЕСТВО -->
              <div class="cart-qty" data-item-id="<?php echo e($item->id); ?>">
    <button
        type="button"
        class="cart-qty__btn cart-qty__minus"
        data-url="<?php echo e(route('cart.update', $item)); ?>"
        data-qty="<?php echo e($item->qty - 1); ?>"
        <?php if($item->qty <= 1): ?> disabled <?php endif; ?>
    >
        −
    </button>

    <span class="cart-qty__value" id="cart-qty-<?php echo e($item->id); ?>">
        <?php echo e($item->qty); ?>

    </span>

    <button
        type="button"
        class="cart-qty__btn cart-qty__plus"
        data-url="<?php echo e(route('cart.update', $item)); ?>"
        data-qty="<?php echo e($item->qty + 1); ?>"
    >
        +
    </button>
</div>

                <!-- СУММА -->
                <div class="cart-sum" id="cart-item-total-<?php echo e($item->id); ?>">
                    <?php echo e(number_format($item->qty * $item->product->price, 2, '.', ' ')); ?> ₽
                </div>

                <!-- УДАЛИТЬ -->
                <form action="<?php echo e(route('cart.remove', $item)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="cart-remove">✕</button>
                </form>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <!-- ИТОГ -->
        <div class="cart-summary">

            <h3>Итого</h3>

            <div class="cart-summary__row">
                <span>Товаров:</span>
                <span id="cart-total-count"><?php echo e($cart->total_qty); ?></span>
            </div>

            <div class="cart-summary__row">
                <span>Сумма:</span>
               <span id="cart-total-price"><?php echo e(number_format($cart->total_price, 2, '.', ' ')); ?> ₽</span>
            </div>

            <?php if(session('promocode')): ?>
                <div class="cart-summary__row cart-summary__row--discount">
                    <span>Скидка:</span>
                    <span>-<?php echo e(number_format(session('promocode.discount'), 2)); ?> ₽</span>
                </div>

                <div class="cart-summary__row cart-summary__row--total">
                    <span>К оплате:</span>
                    <span id="cart-pay-total">
                        <?php echo e(number_format(max($cart->total_price - session('promocode.discount'), 0), 2, '.', ' ')); ?> ₽
                    </span>
                </div>
            <?php endif; ?>
            <div class="cart-promocode">
                <label for="promocode">Промокод</label>

                <form action="<?php echo e(route('cart.promocode.apply')); ?>" method="POST" class="cart-promocode__form">
                    <?php echo csrf_field(); ?>

                    <input
                        type="text"
                        id="promocode"
                        name="code"
                        placeholder="Введите промокод"
                        value="<?php echo e(session('promocode.code')); ?>"
                    >

                    <button type="submit">Применить</button>
                </form>

                <?php if(session('promocode')): ?>
                    <div class="cart-promocode__success">
                        Промокод <?php echo e(session('promocode.code')); ?> применён

                        <form action="<?php echo e(route('cart.promocode.remove')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit">убрать</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if(session('promocode_error')): ?>
                    <div class="cart-promocode__error">
                        <?php echo e(session('promocode_error')); ?>

                    </div>
                <?php endif; ?>
            </div>
            <?php if(Auth::check()): ?>
                <a href="<?php echo e(route('order.checkout')); ?>" class="btn-primary">
                    Оформить заказ
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-primary">
                    Войти и оформить
                </a>
            <?php endif; ?>

            <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="cart-clear">Очистить корзину</button>
            </form>

        </div>

    </div>

    <?php endif; ?>
</div>
</div>
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.cart-qty__btn');

    if (!btn) return;

    const qtyBox = btn.closest('.cart-qty');
    const itemId = qtyBox.dataset.itemId;

    fetch(btn.dataset.url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            _method: 'PUT',
            qty: btn.dataset.qty,
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById(`cart-qty-${itemId}`).innerText = data.qty;

        const minusBtn = qtyBox.querySelector('.cart-qty__minus');
        const plusBtn = qtyBox.querySelector('.cart-qty__plus');

        minusBtn.dataset.qty = data.next_minus_qty;
        plusBtn.dataset.qty = data.next_plus_qty;
        minusBtn.disabled = data.minus_disabled;

        document.getElementById(`cart-item-total-${itemId}`).innerText = data.item_total;
        document.getElementById('cart-total-count').innerText = data.count;
        document.getElementById('cart-total-price').innerText = data.total;

        const payTotal = document.getElementById('cart-pay-total');

        if (payTotal && data.pay_total !== undefined) {
            payTotal.innerText = data.pay_total;
        }

        if (typeof updateCartIcon === 'function') {
            updateCartIcon(data.count);
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/pages/cart.blade.php ENDPATH**/ ?>