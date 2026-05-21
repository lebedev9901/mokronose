



<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="order-page">

        <button onclick="history.back()" class="btn btn-secondary">
            ← Назад
        </button>

        <div class="order-head">
            <div>
                <h1>Заказ #<?php echo e($order->id); ?></h1>
                <p>от <?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
            </div>

            <div class="order-status">
                <?php echo e($order->status_label); ?>

            </div>
        </div>

        <div class="order-layout">

            <div class="order-main">

                <div class="order-card">
                    <h2>Состав заказа</h2>

                    <div class="order-items">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $product = $item->product;
                                $image = $product?->images?->first();
                            ?>

                            <div class="order-item">
                                <div class="order-item-img">
                                    <?php if($image): ?>
                                        <img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="<?php echo e($product->title); ?>">
                                    <?php else: ?>
                                        <span>Нет фото</span>
                                    <?php endif; ?>
                                </div>

                                <div class="order-item-info">
                                    <h3><?php echo e($product?->title ?? 'Товар удалён'); ?></h3>
                                    <p>Количество: <?php echo e($item->qty); ?></p>
                                    <p>Цена: <?php echo e(number_format($item->price, 0, '.', ' ')); ?> ₽</p>
                                </div>

                                <div class="order-item-total">
                                    <?php echo e(number_format($item->price * $item->qty, 0, '.', ' ')); ?> ₽
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="order-card">
                    <h2>Чат по заказу</h2>

                    <?php if($order->chat): ?>
                        <?php
                            $lastMessage = $order->chat->message->last();
                        ?>

                        <?php if($lastMessage): ?>
                            <div class="last-message">
                                <strong>Последнее сообщение:</strong>
                                <p><?php echo e($lastMessage->message); ?></p>
                                <span><?php echo e($lastMessage->created_at->format('d.m.Y H:i')); ?></span>
                            </div>
                        <?php else: ?>
                            <p class="muted">Сообщений пока нет</p>
                        <?php endif; ?>

                        <a href="<?php echo e(route('support.chat', $order->chat->id)); ?>" class="btn btn-primary">
                            Открыть чат
                        </a>
                    <?php else: ?>
                        <p class="muted">Чат не найден</p>
                    <?php endif; ?>
                </div>

            </div>

            <aside class="order-sidebar">

                <div class="order-card">
                    <h2>Итого</h2>

                    <div class="order-total">
                        <?php echo e(number_format($order->total_price ?? $order->total ?? 0, 0, '.', ' ')); ?> ₽
                    </div>
                </div>

                <div class="order-card">
                    <h2>Доставка</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            <?php echo e($order->delivery_label); ?>

                        </p>

                        <?php if($order->delivery_method === 'courier'): ?>
                            <p>
                                <strong>Адрес:</strong>
                                <?php echo e($order->address?->city); ?>,
                                <?php echo e($order->address?->street); ?>,
                                <?php echo e($order->address?->house); ?>,
                                <?php echo e($order->address?->apartment); ?>

                            </p>
                        <?php endif; ?>

                        <?php if($order->delivery_method === 'pickup'): ?>
                            <p>
                                <strong>Пункт самовывоза:</strong>
                                <?php echo e($order->pickup_point ?? '—'); ?>

                            </p>
                        <?php endif; ?>

                        <?php if($order->delivery_method === 'cdek'): ?>
                            <p>
                                <strong>Пункт СДЭК:</strong>
                                <?php echo e($order->cdek_point ?? '—'); ?>

                            </p>
                        <?php endif; ?>

                        <?php if($order->delivery_method === 'post'): ?>
                            <p>
                                <strong>Почтовый адрес:</strong>
                                <?php echo e($order->post_address ?? '—'); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="order-card">
                    <h2>Оплата</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            <?php echo e($order->payment_label); ?>

                        </p>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/orders/show.blade.php ENDPATH**/ ?>