

<div class="container">

    <div class="support-page">

        
        <div class="support-header">

            <div>
                <h1>Поддержка</h1>
                <p>Ваши обращения и чаты с поддержкой</p>
            </div>

            <a href="<?php echo e(route('support.create')); ?>"
               class="support-create-btn">
                + Новый чат
            </a>

        </div>

        
        <div class="support-list">

            <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <a href="<?php echo e(route('support.chat', $chat->id)); ?>"
                   class="support-item">

                    <div class="support-item-top">

                        <div class="support-subject">
                            <?php echo e($chat->subject ?? 'Без темы'); ?>

                        </div>

                        <div class="support-status <?php echo e($chat->status); ?>">
                            <?php echo e(strtoupper($chat->status)); ?>

                        </div>

                    </div>

                    <div class="support-last-message">

                        <?php if($chat->message->last()): ?>
                            <?php echo e(Str::limit($chat->message->last()->message, 80)); ?>

                        <?php else: ?>
                            Сообщений пока нет
                        <?php endif; ?>

                    </div>

                    <div class="support-meta">

                        <span>
                            #<?php echo e($chat->id); ?>

                        </span>

                        <span>
                            <?php echo e($chat->updated_at->format('d.m.Y H:i')); ?>

                        </span>

                    </div>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="support-empty">
                    У вас пока нет обращений
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/support.blade.php ENDPATH**/ ?>