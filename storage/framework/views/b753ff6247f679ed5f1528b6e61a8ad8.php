<<<<<<< HEAD
<div class="orders">

    <h1 class="section-title">Мои заказы</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

        <div class="order-card">

            <div class="order-card__top">
                <div>
                    <h3 class="order-id">
                        Заказ #<?php echo e($order->id); ?>

                    </h3>
                    <span class="order-date">
                        <?php echo e($order->created_at->format('d.m.Y')); ?>

                    </span>
                </div>

                <span class="order-status status-<?php echo e($order->status); ?>">
                    <?php echo e($order->status); ?>

                </span>
            </div>

            <div class="order-card__body">
                <div class="order-price">
                    <?php echo e($order->total_price); ?> ₽
                </div>

                <div class="order-actions">
                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn-outline">
                        Подробнее
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->chat): ?>
                        <a href="<?php echo e(route('chat.show', $order->chat->id)); ?>" class="btn-primary">
                            Чат
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

        </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <div class="empty-block">
            📦 У вас пока нет заказов
        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="pagination">
        <?php echo e($orders->links()); ?>

    </div>

</div><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/orders.blade.php ENDPATH**/ ?>
=======

<div class="container">

    <h1>Мои заказы</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px">

            <h3><a href="<?php echo e(route('orders.show', $order->id)); ?>">Заказ #<?php echo e($order->id); ?></a></h3>

            <p>Статус: <?php echo e($order->status); ?></p>
            <p>Сумма: <?php echo e($order->total_price); ?> ₽</p>
            <p>Дата: <?php echo e($order->created_at->format('d.m.Y')); ?></p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->chat): ?>
                <a href="<?php echo e(route('chat.show', $order->chat->id)); ?>" class="btn btn-primary">
                    Открыть чат поддержки
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
        </div>
        <?php echo e($orders->links()); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <p>У вас пока нет заказов</p>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
</div>

<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/orders.blade.php ENDPATH**/ ?>
>>>>>>> 6c8703de2f5adfd1e5348e4946eaaf01427e01e0
