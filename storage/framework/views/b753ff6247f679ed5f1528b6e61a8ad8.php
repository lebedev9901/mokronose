<div class="orders">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">📦 Мои заказы</h1>
            <p>История ваших покупок в Мокроносе</p>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <div class="order-card">

            <div class="order-card__top">
                <div>
                    <div class="order-id">Заказ №<?php echo e($order->id); ?></div>
                    <div class="order-date"><?php echo e($order->created_at->format('d.m.Y H:i')); ?></div>
                </div>

                <span class="order-status status-<?php echo e($order->status); ?>">
                    <?php echo e($order->status_label); ?>

                </span>
            </div>

            <div class="order-products-preview">

                <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $product = $item->product;
                        $preview = $product?->images->where('is_preview', true)->first()
                            ?? $product?->images->first();
                    ?>

                    <div class="order-preview-item">
                        <div class="order-preview-img">
                            <?php if($preview): ?>
                                <img src="<?php echo e(asset('storage/' . $preview->image)); ?>" alt="<?php echo e($product->title); ?>">
                            <?php else: ?>
                                <span>Нет фото</span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <strong><?php echo e($product->title ?? 'Товар удалён'); ?></strong>
                            <p><?php echo e($item->qty); ?> шт. × <?php echo e(number_format($item->price, 0, '.', ' ')); ?> ₽</p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($order->items->count() > 3): ?>
                    <div class="order-more-products">
                        + ещё <?php echo e($order->items->count() - 3); ?> товара
                    </div>
                <?php endif; ?>

            </div>

            <div class="order-card__body">
                <div>
                    <div class="muted">Итого</div>
                    <div class="order-total">
                        <?php echo e(number_format($order->total_price, 0, '.', ' ')); ?> ₽
                    </div>
                </div>

                <div class="order-actions">
                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn-secondary">
                        Подробнее
                    </a>

                    <?php if($order->chat): ?>
                        <a href="<?php echo e(route('support.chat', $order->chat->id)); ?>" class="btn-primary">
                            Чат
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-block">
            <h3>📦 У вас пока нет заказов</h3>
            <p>После оформления заказа он появится здесь.</p>
            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">Перейти в каталог</a>
        </div>
    <?php endif; ?>

    <?php if($orders->hasPages()): ?>
        <div class="pagination">
            <?php echo e($orders->links()); ?>

        </div>
    <?php endif; ?>

</div><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/orders.blade.php ENDPATH**/ ?>