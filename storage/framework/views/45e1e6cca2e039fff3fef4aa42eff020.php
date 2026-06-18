<?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <div class="support-message <?php echo e($message->sender_type === 'user' ? 'user' : 'support'); ?>">
        <div class="support-message-content">

            <div class="support-message-author">
                <?php echo e($message->user->name ?? 'Система'); ?>

            </div>

            <div class="support-message-text">
                <?php echo e($message->message); ?>

            </div>

            <div class="support-message-time">
                <?php echo e($message->created_at->format('d.m.Y H:i')); ?>

            </div>

        </div>
    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <div class="support-empty-chat">
        Сообщений пока нет
    </div>

<?php endif; ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/support/partials/messages.blade.php ENDPATH**/ ?>