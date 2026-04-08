



<?php $__env->startSection('content'); ?>
<div class="container">


<div class="dashboard">
    <button onclick="history.back()" class="btn btn-secondary">
    ← Назад
</button>
    <h1>Заказ #<?php echo e($order->id); ?></h1>

    <div class="order-detail">
        <p><strong>Дата:</strong> <?php echo e($order->created_at); ?></p>
        <p><strong>Статус:</strong> <?php echo e($order->status); ?></p>
        <p><strong>Сумма:</strong> <?php echo e($order->total ?? '—'); ?></p>
    </div>

    <hr>

    <div class="order-chat">
    <h3>Чат по заказу</h3>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->chat): ?>

        <?php
            $lastMessage = $order->chat->message->last();
        ?>

        <div class="last-message" style="margin-bottom:10px;">
            <strong>Последнее сообщение:</strong><br>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastMessage): ?>
                <div style="padding:10px; background:#f5f5f5; border-radius:10px; margin-top:5px;">
                    <?php echo e($lastMessage->message); ?>


                    <div style="font-size:10px; text-align:right;">
                        <?php echo e($lastMessage->created_at->format('d.m.Y H:i')); ?>

                    </div>
                </div>
            <?php else: ?>
                <p>Сообщений пока нет</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <a href="<?php echo e(route('chat.show', $order->chat->id)); ?>" class="btn btn-primary">
            Открыть чат
        </a>

    <?php else: ?>
        <p>Чат не найден</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/orders/show.blade.php ENDPATH**/ ?>