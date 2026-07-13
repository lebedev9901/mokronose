

<?php $__env->startSection('title', 'Панель управления'); ?>

<?php $__env->startSection('page-title', 'Панель управления'); ?>
<?php $__env->startSection('page-subtitle', 'Статистика магазина Мокронос'); ?>

<?php $__env->startSection('content'); ?>

<div class="dashboard-cards">

    <div class="dashboard-card">
        <div class="dashboard-card__icon">📦</div>
        <div>
            <span>Всего товаров</span>
            <strong><?php echo e($productsCount); ?></strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">✅</div>
        <div>
            <span>В наличии</span>
            <strong><?php echo e($productsInStock); ?></strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">🧾</div>
        <div>
            <span>Заказы</span>
            <strong><?php echo e($ordersCount); ?></strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">👤</div>
        <div>
            <span>Пользователи</span>
            <strong><?php echo e($usersCount); ?></strong>
        </div>
    </div>

    <div class="dashboard-card dashboard-card--sales">
        <div class="dashboard-card__icon">💰</div>
        <div>
            <span>Продажи</span>
            <strong><?php echo e(number_format($totalSales, 0, ',', ' ')); ?> ₽</strong>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>