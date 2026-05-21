

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="dashboard">

    <h1 class="mb-4">📊 Dashboard</h1>

    <div class="dashboard-grid">

        <div class="card">
            <h3>📦 Товары</h3>
            <p><?php echo e($productsCount); ?></p>
        </div>

        <div class="card">
            <h3>📦 В наличии</h3>
            <p><?php echo e($productsInStock); ?></p>
        </div>

        <div class="card">
            <h3>🧾 Заказы</h3>
            <p><?php echo e($ordersCount); ?></p>
        </div>

        <div class="card">
            <h3>👤 Пользователи</h3>
            <p><?php echo e($usersCount); ?></p>
        </div>

        <div class="card highlight">
            <h3>💰 Продажи</h3>
            <p><?php echo e(number_format($totalSales, 0, ',', ' ')); ?> ₽</p>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>