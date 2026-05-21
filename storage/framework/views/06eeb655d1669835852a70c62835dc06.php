

<?php $__env->startSection('title', 'Чат поддержки'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="chat-page">

        
        <div class="chat-header">
            <button class="back-btn" onclick="window.history.back()">
                ← Назад
            </button>

            <h2>Чат поддержки</h2>

            <div class="chat-subtitle">
                Заказ #<?php echo e($chat->order_id ?? '—'); ?>

            </div>
        </div>

        
        <div class="chat-box" id="chatBox">

            <?php $__empty_1 = true; $__currentLoopData = $chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="msg <?php echo e($msg->sender_type === 'support' ? 'support' : 'user'); ?>">

                    <div class="bubble">

                        <div class="text">
                            <?php echo e($msg->message); ?>

                        </div>

                        <div class="time">
                            <?php echo e($msg->created_at->format('d.m.Y H:i')); ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">
                    Сообщений пока нет
                </div>
            <?php endif; ?>

        </div>

        
        <form class="chat-form" action="<?php echo e(route('chat.send', $chat->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <textarea name="message" placeholder="Напишите сообщение..." required></textarea>

            <button type="submit">Отправить</button>
        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>




<?php $__env->startPush('scripts'); ?>
<script>
const box = document.getElementById('chatBox');
if(box){
    box.scrollTop = box.scrollHeight;
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/chat/show.blade.php ENDPATH**/ ?>