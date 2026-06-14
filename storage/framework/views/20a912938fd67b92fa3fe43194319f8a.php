

<?php $__env->startSection('title', 'Поддержка'); ?>
<?php $__env->startSection('page-title', 'Поддержка'); ?>
<?php $__env->startSection('page-subtitle', 'Чаты пользователей с поддержкой'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Чаты поддержки</h2>
        <p>Всего чатов: <?php echo e($chats->count()); ?></p>
    </div>
</div>

<div class="admin-support-list">

    <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <a href="<?php echo e(route('admin.support.chat', $chat->id)); ?>"
           class="admin-support-item">

            <div class="admin-support-item__main">
                <strong><?php echo e($chat->user->name ?? 'Удалён'); ?></strong>

                <span>
                    Чат #<?php echo e($chat->id); ?>

                </span>

                <?php if($chat->message->last()): ?>
                    <p>
                        <?php echo e(\Illuminate\Support\Str::limit($chat->message->last()->message, 80)); ?>

                    </p>
                <?php else: ?>
                    <p>Нет сообщений</p>
                <?php endif; ?>
            </div>

            <div class="admin-support-item__side">
                <?php if($chat->status === 'open'): ?>
                    <span class="admin-status admin-status--success">Открыт</span>
                <?php elseif($chat->status === 'waiting'): ?>
                    <span class="admin-status admin-status--warning">Ждёт ответа</span>
                <?php elseif($chat->status === 'answered'): ?>
                    <span class="admin-status admin-status--info">Ответили</span>
                <?php elseif($chat->status === 'closed'): ?>
                    <span class="admin-status admin-status--danger">Закрыт</span>
                <?php else: ?>
                    <span class="admin-status"><?php echo e($chat->status); ?></span>
                <?php endif; ?>

                <small>
                    <?php echo e($chat->updated_at->format('d.m.Y H:i')); ?>

                </small>
            </div>

        </a>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div class="admin-form-card">
            <p class="admin-empty-text">Чатов пока нет</p>
        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/support/index.blade.php ENDPATH**/ ?>