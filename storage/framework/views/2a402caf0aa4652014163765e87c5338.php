

<?php $__env->startSection('title', 'Заказ №' . $order->id); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="order-page">

        <div class="order-head">
            <div>
                <a href="<?php echo e(route('profile.page', ['page' => 'orders'])); ?>" class="btn-secondary">
                    ← Назад к заказам
                </a>

                <h1>Заказ №<?php echo e($order->id); ?></h1>
                <p>Оформлен <?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
            </div>

            <span class="order-status status-<?php echo e($order->status); ?>">
                <?php echo e($order->status_label); ?>

            </span>
        </div>

        <div class="order-layout">

            <main class="order-main">

                <section class="order-card">
                    <div class="order-card-head">
                        <div>
                            <h2>Состав заказа</h2>
                            <p><?php echo e($order->items->sum('qty')); ?> товаров</p>
                        </div>

                        <strong>
                            <?php echo e(number_format($order->total_price ?? $order->total ?? 0, 0, '.', ' ')); ?> ₽
                        </strong>
                    </div>

                    <div class="order-items">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $product = $item->product;
                                $image = $product?->images?->where('is_preview', true)->first()
                                    ?? $product?->images?->first();
                            ?>

                            <div class="order-item">

                                <a
                                    href="<?php echo e($product ? route('product', $product->id) : '#'); ?>"
                                    class="order-item-img"
                                >
                                    <?php if($image): ?>
                                        <img src="<?php echo e(asset('storage/' . $image->image)); ?>" alt="<?php echo e($product->title); ?>">
                                    <?php else: ?>
                                        <span>Нет фото</span>
                                    <?php endif; ?>
                                </a>

                                <div class="order-item-info">
                                    <h3>
                                        <?php if($product): ?>
                                            <a href="<?php echo e(route('product', $product->id)); ?>">
                                                <?php echo e($product->title); ?>

                                            </a>
                                        <?php else: ?>
                                            Товар удалён
                                        <?php endif; ?>
                                    </h3>

                                    <p><?php echo e($item->qty); ?> шт. × <?php echo e(number_format($item->price, 0, '.', ' ')); ?> ₽</p>
                                </div>

                                <div class="order-item-total">
                                    <?php echo e(number_format($item->price * $item->qty, 0, '.', ' ')); ?> ₽
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>


                <section class="order-card">
                    <div class="order-card-head">
                        <div>
                            <h2>Чат по заказу</h2>
                            <p>Связь с поддержкой по этому заказу</p>
                        </div>
                    </div>

                    <?php if($order->chat): ?>
                        <?php
                            $lastMessage = $order->chat->message->last();
                        ?>

                        <?php if($lastMessage): ?>
                            <div class="last-message">
                                <strong>Последнее сообщение</strong>
                                <p><?php echo e($lastMessage->message); ?></p>
                                <span><?php echo e($lastMessage->created_at->format('d.m.Y H:i')); ?></span>
                            </div>
                        <?php else: ?>
                            <p class="muted">Сообщений пока нет.</p>
                        <?php endif; ?>

                        <a href="<?php echo e(route('support.chat', $order->chat->id)); ?>" class="btn-primary">
                            Открыть чат
                        </a>
                    <?php else: ?>
                        <div class="empty-block">
                            Чат по заказу пока не создан.
                        </div>
                    <?php endif; ?>
                </section>

            </main>


            <aside class="order-sidebar">

                <section class="order-card order-summary-card">
                    <h2>Итого</h2>

                    <div class="order-summary-row">
                        <span>Товары</span>
                        <strong>
                            <?php echo e(number_format($order->total_before_discount ?? $order->total_price, 0, '.', ' ')); ?> ₽
                        </strong>
                    </div>

                    <?php if(($order->discount_amount ?? 0) > 0): ?>
                        <div class="order-summary-row order-discount">
                            <span>
                                Скидка
                                <?php if($order->promocode_code): ?>
                                    <small>(<?php echo e($order->promocode_code); ?>)</small>
                                <?php endif; ?>
                            </span>

                            <strong>
                                -<?php echo e(number_format($order->discount_amount, 0, '.', ' ')); ?> ₽
                            </strong>
                        </div>
                    <?php endif; ?>

                    <div class="order-summary-row">
                        <span>Товаров</span>
                        <strong><?php echo e($order->items->sum('qty')); ?></strong>
                    </div>

                    <div class="order-summary-row">
                        <span>Статус</span>
                        <strong><?php echo e($order->status_label); ?></strong>
                    </div>

                    <div class="order-summary-total">
                        <span>Сумма к оплате</span>
                        <strong>
                            <?php echo e(number_format($order->total_after_discount ?? $order->total_price, 0, '.', ' ')); ?> ₽
                        </strong>
                    </div>
                </section>


                <section class="order-card">
                    <h2>Доставка</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            <?php echo e($order->delivery_label ?? '—'); ?>

                        </p>

                        <?php if($order->delivery_method === 'courier'): ?>
                            <p>
                                <strong>Адрес:</strong>
                                <?php echo e($order->address?->city ?? ''); ?>,
                                <?php echo e($order->address?->street ?? ''); ?>,
                                <?php echo e($order->address?->house ?? ''); ?>

                                <?php if($order->address?->apartment): ?>
                                    , кв. <?php echo e($order->address?->apartment); ?>

                                <?php endif; ?>
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
                </section>


                <section class="order-card">
                    <h2>Оплата</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            <?php echo e($order->payment_label ?? '—'); ?>

                        </p>
                    </div>
                </section>

            </aside>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/orders/show.blade.php ENDPATH**/ ?>