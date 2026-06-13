

<?php $__env->startSection('title', 'Промокоды'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="dashboard-header">
        <h1>Промокоды</h1>

        <a href="<?php echo e(route('admin.promocodes.create')); ?>" class="btn-primary">
            Создать промокод
        </a>
    </div>

    <div class="dashboard-card">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Значение</th>
                    <th>Использовано</th>
                    <th>Активен</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $promocodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promocode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($promocode->id); ?></td>

                    <td>
                        <strong><?php echo e($promocode->code); ?></strong>
                    </td>

                    <td>
                        <?php echo e($promocode->title); ?>

                    </td>

                    <td>
                        <?php if($promocode->type === 'percent'): ?>
                            Процент
                        <?php else: ?>
                            Фиксированная
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($promocode->type === 'percent'): ?>
                            <?php echo e($promocode->value); ?>%
                        <?php else: ?>
                            <?php echo e($promocode->value); ?> ₽
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php echo e($promocode->used_count); ?>


                        <?php if($promocode->usage_limit): ?>
                            / <?php echo e($promocode->usage_limit); ?>

                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($promocode->is_active): ?>
                            <span class="status status-success">
                                Активен
                            </span>
                        <?php else: ?>
                            <span class="status status-danger">
                                Выключен
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>

                        <div class="table-actions">

                            <a
                                href="<?php echo e(route('admin.promocodes.edit', $promocode)); ?>"
                                class="btn-small"
                            >
                                Изменить
                            </a>

                            <form
                                action="<?php echo e(route('admin.promocodes.destroy', $promocode)); ?>"
                                method="POST"
                            >
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button
                                    class="btn-small btn-danger"
                                    onclick="return confirm('Удалить промокод?')"
                                >
                                    Удалить
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="8">
                        Промокодов пока нет
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

        <div style="margin-top:20px;">
            <?php echo e($promocodes->links()); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/promocodes/index.blade.php ENDPATH**/ ?>