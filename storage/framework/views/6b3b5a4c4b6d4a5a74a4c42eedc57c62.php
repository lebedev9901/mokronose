

<?php $__env->startSection('title', 'Создание промокода'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="dashboard-header">
        <h1>Создать промокод</h1>

        <a href="<?php echo e(route('admin.promocodes.index')); ?>" class="btn-secondary">
            Назад
        </a>
    </div>

    <div class="dashboard-card">

        <form action="<?php echo e(route('admin.promocodes.store')); ?>" method="POST">

            <?php echo csrf_field(); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Код промокода</label>
                    <input
                        type="text"
                        name="code"
                        value="<?php echo e(old('code')); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Название</label>
                    <input
                        type="text"
                        name="title"
                        value="<?php echo e(old('title')); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Тип скидки</label>

                    <select name="type">
                        <option value="percent">Процент</option>
                        <option value="fixed">Фиксированная сумма</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Значение</label>
                    <input
                        type="number"
                        step="0.01"
                        name="value"
                        value="<?php echo e(old('value')); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Минимальная сумма заказа</label>
                    <input
                        type="number"
                        step="0.01"
                        name="min_order_amount"
                        value="<?php echo e(old('min_order_amount')); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Лимит использований</label>
                    <input
                        type="number"
                        name="usage_limit"
                        value="<?php echo e(old('usage_limit')); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Дата начала</label>
                    <input
                        type="datetime-local"
                        name="starts_at"
                    >
                </div>

                <div class="form-group">
                    <label>Дата окончания</label>
                    <input
                        type="datetime-local"
                        name="expires_at"
                    >
                </div>

            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                    >
                    Активный промокод
                </label>
            </div>

            <button class="btn-primary">
                Создать промокод
            </button>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/promocodes/create.blade.php ENDPATH**/ ?>