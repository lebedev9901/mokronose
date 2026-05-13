

<?php $__env->startSection('title', 'Заказ #' . $order->id); ?>

<?php $__env->startSection('content'); ?>

<div class="order-layout">

    
    <div class="order-info card">

        <div class="order-top">

            <h1>
                Заказ #<?php echo e($order->id); ?>

            </h1>

            <span class="status status-new">
                <?php echo e($order->status); ?>

            </span>

        </div>

        <div class="info-group">
            <label>Клиент</label>
            <div><?php echo e($order->user->name); ?></div>
        </div>

        <div class="info-group">
            <label>Email</label>
            <div><?php echo e($order->user->email); ?></div>
        </div>

        <div class="info-group">
            <label>Телефон</label>
            <div><?php echo e($order->user->phone); ?></div>
        </div>

        <hr>

        <h3>Товары</h3>

        <div class="order-products">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                <div class="product-row">

                    <div>
                        <?php echo e($item->product->title ?? 'Удалён товар'); ?>

                    </div>

                    <div>
                        x<?php echo e($item->quantity); ?>

                    </div>

                    <div>
                        <?php echo e($item->price); ?> ₽
                    </div>

                </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        </div>

        <hr>

        <div class="order-total">
            Итого:
            <strong>
                <?php echo e($order->total_price); ?> ₽
            </strong>
        </div>

    </div>

    
    <div class="chat-box card">

        <div class="chat-header">
            Чат заказа
        </div>

        <div class="chat-messages">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->chat): ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                    <div class="message <?php echo e($message->sender_type); ?>">

                        <div class="message-user">
                            <?php echo e($message->user->name); ?>

                        </div>

                        <div class="message-text">
                            <?php echo e($message->message); ?>

                        </div>

                        <div class="message-date">
                            <?php echo e($message->created_at->format('H:i')); ?>

                        </div>

                    </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <?php else: ?>

                <div class="empty-chat">
                    Сообщений пока нет
                </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>

        <form action="<?php echo e(route('admin.orders.message', $order->id)); ?>"
              method="POST"
              class="chat-form">

            <?php echo csrf_field(); ?>

            <textarea name="message"
                      placeholder="Введите сообщение"></textarea>

            <button class="btn btn-primary">
                Отправить
            </button>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>