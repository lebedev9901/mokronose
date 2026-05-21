

<?php $__env->startSection('title', 'Заказы'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">

    <div>
        <h1 class="page-title">Заказы</h1>
        <p class="page-subtitle">
            Всего заказов: <?php echo e($orders->count()); ?>

        </p>
    </div>

    <div class="order-badge">
        🔔 Новых заказов:
        <span><?php echo e($newOrders); ?></span>
    </div>

</div>

<div class="card">

    <table class="admin-table">

        <thead>
        <tr>
            <th>#</th>
            <th>Клиент</th>
            <th>Телефон</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Действия</th>
            <th></th>
        </tr>
        </thead>

        <tbody>

        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>

                <td>
                    #<?php echo e($order->id); ?>

                </td>

                <td>
                    <?php echo e($order->user->name ?? 'Удалён'); ?>

                </td>

                <td>
                    <?php echo e($order->user->phone ?? '-'); ?>

                </td>

                <td class="price">
                    <?php echo e(number_format($order->total_price, 0, '.', ' ')); ?> ₽
                </td>

                <td>

                    <?php if($order->status == 'new'): ?>
                        <span class="status status-new">
                            Новый
                        </span>
                    <?php endif; ?>

                    <?php if($order->status == 'progress'): ?>
                        <span class="status status-progress">
                            В работе
                        </span>
                    <?php endif; ?>

                    <?php if($order->status == 'done'): ?>
                        <span class="status status-done">
                            Завершён
                        </span>
                    <?php endif; ?>

                </td>

                <td>
                    <?php echo e($order->created_at->format('d.m.Y H:i')); ?>

                </td>

                 <td>

                <?php if($order->status !== 'confirmed'): ?>

                    <form action="<?php echo e(route('admin.orders.confirm', $order->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit">
                            Подтвердить
                        </button>
                    </form>

                <?php else: ?>
                    ✔ подтверждён
                <?php endif; ?>

            </td>

                <td>

                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                       class="btn btn-primary">
                        Открыть
                    </a>

                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

    </table>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>