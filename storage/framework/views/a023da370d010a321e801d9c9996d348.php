

<?php $__env->startSection('title', 'Чат поддержки'); ?>
<?php $__env->startSection('page-title', 'Чат поддержки #' . $chat->id); ?>
<?php $__env->startSection('page-subtitle', $chat->user->name ?? 'Пользователь удалён'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-support-chat-layout">

    <aside class="admin-support-sidebar">

        <div class="admin-support-sidebar__head">
            <h3>Все чаты</h3>
        </div>

        <div class="admin-support-sidebar__list">
            <?php $__currentLoopData = $allChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a href="<?php echo e(route('admin.support.chat', $item->id)); ?>"
                   class="admin-support-sidebar__item <?php echo e($chat->id === $item->id ? 'active' : ''); ?>">

                    <strong><?php echo e($item->user->name ?? 'Удалён'); ?></strong>

                    <span>
                        Чат #<?php echo e($item->id); ?>

                    </span>

                    <?php if($item->message->last()): ?>
                        <p><?php echo e(\Illuminate\Support\Str::limit($item->message->last()->message, 35)); ?></p>
                    <?php endif; ?>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </aside>

    <section class="admin-chat-panel">

        <div class="admin-chat-panel__head">
            <div>
                <h3><?php echo e($chat->user->name ?? 'Удалён'); ?></h3>
                <p>Чат #<?php echo e($chat->id); ?></p>
            </div>

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
        </div>

        <div class="admin-chat-panel__body" id="adminSupportChatBox">

            <?php $__empty_1 = true; $__currentLoopData = $chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

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

            <?php endif; ?>

        </div>

        <form method="POST"
              action="<?php echo e(route('admin.support.send', $chat->id)); ?>"
              class="admin-chat-panel__form">

            <?php echo csrf_field(); ?>

            <textarea name="message" placeholder="Введите сообщение..." required></textarea>

            <button class="admin-btn">
                Отправить
            </button>

        </form>

    </section>

</div>

<script>
const adminSupportChatBox = document.getElementById('adminSupportChatBox');

if (adminSupportChatBox) {
    adminSupportChatBox.scrollTop = adminSupportChatBox.scrollHeight;
}
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('<?php echo e(route('notifications.markByData')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            type: 'support_message',
            key: 'chat_id',
            value: '<?php echo e($chat->id); ?>'
        })
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/support/chat.blade.php ENDPATH**/ ?>