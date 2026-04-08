

<?php $__env->startSection('title', 'Чат поддержки'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <button type="button" onclick="window.history.back()">
    ← Назад
</button>
    <h2>Чат поддержки (заказ #<?php echo e($chat->order_id); ?>)</h2>

    <div class="chat-container" style="max-width:600px; margin:auto;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div style="margin:10px 0; display:flex; <?php echo e($msg->sender_type === 'support' ? 'justify-content:flex-start' : 'justify-content:flex-end'); ?>">
            <div style="padding:10px 15px; border-radius:15px; background: <?php echo e($msg->sender_type === 'support' ? '#003566' : '#FFD60A'); ?>; color:<?php echo e($msg->sender_type === 'support' ? 'white' : 'black'); ?>">
                <?php echo e($msg->message); ?>

                <div style="font-size:10px; text-align:right; margin-top:5px;">
                    <?php echo e($msg->created_at->format('d.m.Y H:i')); ?>

                </div>
            </div>
        </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>


    <form action="<?php echo e(route('chat.send', $chat->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <textarea name="message" rows="3" style="width:100%" required></textarea>

        <button type="submit" class="btn btn-primary" style="margin-top:10px">
            Отправить
        </button>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/chat/show.blade.php ENDPATH**/ ?>