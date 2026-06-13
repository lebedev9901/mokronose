

<?php $__env->startSection('title', 'Поддержка'); ?>

<?php $__env->startSection('content'); ?>

<h1>Чаты поддержки</h1>

<div class="admin-support-list">

    <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <a href="<?php echo e(route('admin.support.chat', $chat->id)); ?>"
           class="support-chat-item">

            <div>

                <strong>
                    <?php echo e($chat->user->name); ?>

                </strong>

                <div>
                    Чат #<?php echo e($chat->id); ?>

                </div>

            </div>

            <div>

                <div>
                    <?php echo e($chat->status); ?>

                </div>

                <?php if($chat->message->last()): ?>
                    <small>
                        <?php echo e(\Illuminate\Support\Str::limit(
                            $chat->message->last()->message,
                            40
                        )); ?>

                    </small>
                <?php endif; ?>

            </div>

        </a>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <p>Чатов пока нет</p>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/support/index.blade.php ENDPATH**/ ?>