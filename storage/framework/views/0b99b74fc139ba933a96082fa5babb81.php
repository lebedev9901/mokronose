

<?php $__env->startSection('title', 'Заказы'); ?>
<?php $__env->startSection('page-title', 'Заказы'); ?>
<?php $__env->startSection('page-subtitle', 'Управление заказами магазина'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Список заказов</h2>
        <p>Всего заказов: <?php echo e($orders->count()); ?></p>
    </div>

    <div class="admin-order-badge">
        🔔 Новых заказов: <strong><?php echo e($newOrders); ?></strong>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Клиент</th>
                <th>Телефон</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
                <th>Подтверждение</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="admin-muted">#<?php echo e($order->id); ?></td>

                    <td>
                        <strong><?php echo e($order->user->name ?? 'Удалён'); ?></strong>
                    </td>

                    <td><?php echo e($order->user->phone ?? '-'); ?></td>

                    <td>
                        <strong><?php echo e(number_format($order->total_price, 0, ',', ' ')); ?> ₽</strong>
                    </td>

                    <td>
                        <?php if($order->status === 'new'): ?>
                            <span class="admin-status admin-status--warning">Новый</span>
                        <?php elseif($order->status === 'progress'): ?>
                            <span class="admin-status admin-status--info">В работе</span>
                        <?php elseif($order->status === 'done'): ?>
                            <span class="admin-status admin-status--success">Завершён</span>
                        <?php elseif($order->status === 'confirmed'): ?>
                            <span class="admin-status admin-status--success">Подтверждён</span>
                        <?php else: ?>
                            <span class="admin-status"><?php echo e($order->status); ?></span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo e($order->created_at->format('d.m.Y H:i')); ?></td>

                    <td>
                        <?php if($order->status !== 'confirmed'): ?>
                            <form action="<?php echo e(route('admin.orders.confirm', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="admin-btn-light" type="submit">
                                    Подтвердить
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="admin-status admin-status--success">✔ Готово</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="admin-btn-light">
                            Открыть
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="admin-empty">
                        Заказов пока нет
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>