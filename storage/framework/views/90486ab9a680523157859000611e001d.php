


<?php $__env->startSection('title', 'Корзина товаров'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="cart">

    <h1 class="section-title">Корзина</h1>

    <?php if($items->isEmpty()): ?>
        <div class="cart-empty">
            <p>Корзина пуста</p>
            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">Перейти в каталог</a>
        </div>
    <?php else: ?>

    <div class="cart-grid">

        <!-- ТОВАРЫ -->
        <div class="cart-items">

            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="cart-item">

                <div class="cart-item__info">
                    <h3><?php echo e($item->product->title); ?></h3>
                    <p><?php echo e(number_format($item->product->price, 2)); ?> ₽</p>
                </div>

                <!-- КОЛИЧЕСТВО -->
                <div class="cart-qty">

                    <form action="<?php echo e(route('cart.update', $item)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="qty" value="<?php echo e($item->qty - 1); ?>">
                        <button <?php if($item->qty <= 1): ?> disabled <?php endif; ?>>−</button>
                    </form>

                    <span><?php echo e($item->qty); ?></span>

                    <form action="<?php echo e(route('cart.update', $item)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="qty" value="<?php echo e($item->qty + 1); ?>">
                        <button>+</button>
                    </form>

                </div>

                <!-- СУММА -->
                <div class="cart-sum">
                    <?php echo e(number_format($item->qty * $item->product->price, 2)); ?> ₽
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
                <span><?php echo e($cart->total_qty); ?></span>
            </div>

            <div class="cart-summary__row">
                <span>Сумма:</span>
                <span><?php echo e(number_format($cart->total_price, 2)); ?> ₽</span>
            </div>

            <?php if(session('promocode')): ?>
                <div class="cart-summary__row cart-summary__row--discount">
                    <span>Скидка:</span>
                    <span>-<?php echo e(number_format(session('promocode.discount'), 2)); ?> ₽</span>
                </div>

                <div class="cart-summary__row cart-summary__row--total">
                    <span>К оплате:</span>
                    <span><?php echo e(number_format(max($cart->total_price - session('promocode.discount'), 0), 2)); ?> ₽</span>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/pages/cart.blade.php ENDPATH**/ ?>