

<?php $__env->startSection('title', 'Новое обращение'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="support-create">

        <div class="support-create-card">

            <h1 class="support-title">
                Новое обращение
            </h1>

            <form action="<?php echo e(route('support.store')); ?>"
                  method="POST"
                  class="support-form">

                <?php echo csrf_field(); ?>

                
                <div class="form-group">

                    <label>
                        Тема обращения
                    </label>

                    <input
                        type="text"
                        name="subject"
                        class="form-input"
                        placeholder="Например: Проблема с заказом"
                        value="<?php echo e(old('subject')); ?>"
                        required
                    >

                    <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

                
                <div class="form-group">

                    <label>
                        Сообщение
                    </label>

                    <textarea
                        name="message"
                        class="form-textarea"
                        rows="8"
                        placeholder="Опишите вашу проблему..."
                        required
                    ><?php echo e(old('message')); ?></textarea>

                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

                <button class="support-btn">
                    Отправить обращение
                </button>

            </form>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/support/create.blade.php ENDPATH**/ ?>