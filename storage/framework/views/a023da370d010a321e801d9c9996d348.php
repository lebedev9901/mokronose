

<?php $__env->startSection('title', 'Чат поддержки'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex; gap:20px;">

    
    <div style="width:320px; border-right:1px solid #ddd;">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

            <a href="<?php echo e(route('admin.support.chat', $item->id)); ?>"
               style="display:block;
                      padding:15px;
                      border-bottom:1px solid #eee;
                      text-decoration:none;">

                <strong>
                    <?php echo e($item->user->name); ?>

                </strong>

                <div>
                    #<?php echo e($item->id); ?>

                </div>

            </a>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    </div>

    
    <div style="flex:1;">

        <h2>
            Чат #<?php echo e($chat->id); ?>

        </h2>

        <div style="
            height:500px;
            overflow-y:auto;
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:20px;
            border-radius:12px;
        ">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chat->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                <div style="
                    margin-bottom:15px;
                    display:flex;
                    justify-content:
                        <?php echo e($message->sender_type === 'support'
                            ? 'flex-end'
                            : 'flex-start'); ?>;
                ">

                    <div style="
                        max-width:70%;
                        padding:12px;
                        border-radius:12px;
                        background:
                            <?php echo e($message->sender_type === 'support'
                                ? '#2563eb'
                                : '#f3f4f6'); ?>;
                        color:
                            <?php echo e($message->sender_type === 'support'
                                ? 'white'
                                : 'black'); ?>;
                    ">

                        <div>
                            <?php echo e($message->message); ?>

                        </div>

                        <small>
                            <?php echo e($message->created_at->format('d.m H:i')); ?>

                        </small>

                    </div>

                </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        </div>

        <form method="POST"
              action="<?php echo e(route('admin.support.send', $chat->id)); ?>">

            <?php echo csrf_field(); ?>

            <div style="display:flex; gap:10px;">

                <input type="text"
                       name="message"
                       placeholder="Введите сообщение..."
                       style="flex:1;">

                <button>
                    Отправить
                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/support/chat.blade.php ENDPATH**/ ?>