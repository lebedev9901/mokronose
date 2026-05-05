


<?php $__env->startSection('title', 'корзина'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="cart">

    <h1 class="section-title">Корзина</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->isEmpty()): ?>
        <div class="cart-empty">
            <p>Корзина пуста</p>
            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">Перейти в каталог</a>
        </div>
    <?php else: ?>

    <div class="cart-grid">

        <!-- ТОВАРЫ -->
        <div class="cart-items">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

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

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::check()): ?>
                <a href="<?php echo e(route('order.checkout')); ?>" class="btn-primary">
                    Оформить заказ
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-primary">
                    Войти и оформить
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="cart-clear">Очистить корзину</button>
            </form>

        </div>

    </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/pages/cart.blade.php ENDPATH**/ ?>