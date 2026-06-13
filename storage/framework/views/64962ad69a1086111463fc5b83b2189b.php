

<?php $__env->startSection('title', 'Редактирование промокода'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="dashboard-header">
        <h1>Редактирование промокода</h1>

        <a href="<?php echo e(route('admin.promocodes.index')); ?>" class="btn-secondary">
            Назад
        </a>
    </div>

    <div class="dashboard-card">

        <form
            action="<?php echo e(route('admin.promocodes.update', $promocode)); ?>"
            method="POST"
        >

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Код промокода</label>
                    <input
                        type="text"
                        name="code"
                        value="<?php echo e(old('code', $promocode->code)); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Название</label>
                    <input
                        type="text"
                        name="title"
                        value="<?php echo e(old('title', $promocode->title)); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Тип скидки</label>

                    <select name="type">
                        <option
                            value="percent"
                            <?php if($promocode->type === 'percent'): echo 'selected'; endif; ?>
                        >
                            Процент
                        </option>

                        <option
                            value="fixed"
                            <?php if($promocode->type === 'fixed'): echo 'selected'; endif; ?>
                        >
                            Фиксированная сумма
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Значение</label>
                    <input
                        type="number"
                        step="0.01"
                        name="value"
                        value="<?php echo e(old('value', $promocode->value)); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Минимальная сумма заказа</label>
                    <input
                        type="number"
                        step="0.01"
                        name="min_order_amount"
                        value="<?php echo e(old('min_order_amount', $promocode->min_order_amount)); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Лимит использований</label>
                    <input
                        type="number"
                        name="usage_limit"
                        value="<?php echo e(old('usage_limit', $promocode->usage_limit)); ?>"
                    >
                </div>

            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        <?php if($promocode->is_active): echo 'checked'; endif; ?>
                    >
                    Активный промокод
                </label>
            </div>

            <button class="btn-primary">
                Сохранить изменения
            </button>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/promocodes/edit.blade.php ENDPATH**/ ?>