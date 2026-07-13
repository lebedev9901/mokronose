<?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <div class="admin-chat-msg admin-chat-msg--<?php echo e($message->sender_type); ?>">
        <div class="admin-chat-msg__bubble">
            <div class="admin-chat-msg__name">
                <?php echo e($message->user->name ?? 'Система'); ?>

            </div>

            <div class="admin-chat-msg__text">
                <?php echo e($message->message); ?>

            </div>

            <div class="admin-chat-msg__time">
                <?php echo e($message->created_at->format('d.m.Y H:i')); ?>

            </div>
        </div>
    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <div class="admin-chat-empty">
        Сообщений пока нет
    </div>

<?php endif; ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/orders/partials/messages.blade.php ENDPATH**/ ?>