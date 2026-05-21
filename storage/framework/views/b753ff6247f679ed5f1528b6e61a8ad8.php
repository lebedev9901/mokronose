<div class="orders">

    <h1 class="section-title">Мои заказы</h1>

    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

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
                    <?php echo e($order->status_label); ?>

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

                    <?php if($order->chat): ?>
                        <a href="<?php echo e(route('chat.show', $order->chat->id)); ?>" class="btn-primary">
                            Чат
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <?php echo e($orders->links()); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div class="empty-block">
            📦 У вас пока нет заказов
        </div>

    <?php endif; ?>

    <div class="pagination">
        <?php echo e($orders->links()); ?>

    </div>

</div>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/orders.blade.php ENDPATH**/ ?>