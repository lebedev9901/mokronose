

<?php $__env->startSection('title', 'Промокоды'); ?>
<?php $__env->startSection('page-title', 'Промокоды'); ?>
<?php $__env->startSection('page-subtitle', 'Управление скидками и промокодами'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Список промокодов</h2>
        <p>Всего промокодов: <?php echo e($promocodes->total()); ?></p>
    </div>

    <a href="<?php echo e(route('admin.promocodes.create')); ?>" class="admin-btn">
        + Создать промокод
    </a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Код</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Значение</th>
                <th>Использовано</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $promocodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promocode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="admin-muted">#<?php echo e($promocode->id); ?></td>

                    <td>
                        <span class="admin-promocode-code">
                            <?php echo e($promocode->code); ?>

                        </span>
                    </td>

                    <td>
                        <strong><?php echo e($promocode->title ?? 'Без названия'); ?></strong>
                    </td>

                    <td>
                        <?php if($promocode->type === 'percent'): ?>
                            <span class="admin-status admin-status--info">Процент</span>
                        <?php else: ?>
                            <span class="admin-status admin-status--warning">Фиксированная</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <strong>
                            <?php if($promocode->type === 'percent'): ?>
                                <?php echo e($promocode->value); ?>%
                            <?php else: ?>
                                <?php echo e(number_format($promocode->value, 0, ',', ' ')); ?> ₽
                            <?php endif; ?>
                        </strong>
                    </td>

                    <td>
                        <?php echo e($promocode->used_count); ?>

                        <?php if($promocode->usage_limit): ?>
                            / <?php echo e($promocode->usage_limit); ?>

                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($promocode->is_active): ?>
                            <span class="admin-status admin-status--success">Активен</span>
                        <?php else: ?>
                            <span class="admin-status admin-status--danger">Выключен</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="<?php echo e(route('admin.promocodes.edit', $promocode)); ?>"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="<?php echo e(route('admin.promocodes.destroy', $promocode)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Удалить промокод?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button class="admin-btn-danger">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="admin-empty">
                        Промокодов пока нет
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="admin-pagination">
    <?php echo e($promocodes->links()); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/promocodes/index.blade.php ENDPATH**/ ?>