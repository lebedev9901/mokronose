

<?php $__env->startSection('title', 'Чат поддержки'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="support-chat-page">

        
        <div class="support-sidebar">

            <div class="support-sidebar-header">
                <h2>Поддержка</h2>

                <a href="<?php echo e(route('support.index')); ?>">
                    ← Назад
                </a>
            </div>

            <div class="support-sidebar-list">

                <?php $__currentLoopData = $allChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a href="<?php echo e(route('support.chat', $item->id)); ?>"
                       class="support-sidebar-item
                       <?php echo e($chat->id === $item->id ? 'active' : ''); ?>">

                        <div class="support-sidebar-subject">
                            <?php echo e($item->subject ?? 'Без темы'); ?>

                        </div>

                        <div class="support-sidebar-message">

                            <?php if($item->message->last()): ?>
                                <?php echo e(\Illuminate\Support\Str::limit($item->message->last()->message, 40)); ?>

                            <?php else: ?>
                                Нет сообщений
                            <?php endif; ?>

                        </div>

                    </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

        
        <div class="support-chat">

            
            <div class="support-chat-header">

                <div>

                    <h2>
                        <?php echo e($chat->subject ?? 'Чат поддержки'); ?>

                    </h2>

                    <div class="support-chat-status">

                        Статус:

                        <span class="<?php echo e($chat->status); ?>">
                            <?php echo e(strtoupper($chat->status_label)); ?>

                        </span>

                    </div>

                </div>

            </div>

            
            <div class="support-messages"
                 id="chat-box">

                <?php $__empty_1 = true; $__currentLoopData = $chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <div class="support-message
                        <?php echo e($message->sender_type === 'user'
                            ? 'user'
                            : 'support'); ?>">

                        <div class="support-message-content">

                            <div class="support-message-author">

                                <?php echo e($message->user->name); ?>


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

                <?php endif; ?>

            </div>

            
            <?php if($chat->status !== 'closed'): ?>

                <form action="<?php echo e(route('support.send', $chat->id)); ?>"
                      method="POST"
                      class="support-form">

                    <?php echo csrf_field(); ?>

                    <textarea name="message"
                              placeholder="Введите сообщение..."
                              required></textarea>

                    <button type="submit">
                        Отправить
                    </button>

                </form>

            <?php else: ?>

                <div class="support-chat-closed">
                    Чат закрыт
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>





<?php $__env->startPush('scripts'); ?>

<script>

const chatBox = document.getElementById('chat-box');

if(chatBox){
    chatBox.scrollTop = chatBox.scrollHeight;
}

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/support/chat.blade.php ENDPATH**/ ?>