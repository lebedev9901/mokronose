

<?php $__env->startSection('content'); ?>
<?php
    $deliveryLabels = [
        'courier' => 'Курьерская доставка',
        'pickup' => 'Самовывоз',
        'cdek' => 'СДЭК',
        'post' => 'Почта России',
    ];

    $paymentLabels = [
        'cash' => 'Наличными',
        'card' => 'Картой',
        'online' => 'Онлайн-оплата',
        'sbp' => 'СБП',
    ];
?>
<h2 style="margin:0 0 15px;font-size:24px;">
    Заказ №<?php echo e($order->id); ?> оформлен
</h2>

<p style="font-size:16px;line-height:1.6;">
    Спасибо за заказ! Мы получили вашу заявку и передали её в поддержку.
</p>

<div style="background:#FAF7F2;border-radius:14px;padding:18px;margin:25px 0;">
    <p><strong>Статус:</strong> <?php echo e($order->status_label); ?></p>
    <p><strong>Сумма:</strong> <?php echo e($order->total_after_discount ?? $order->total_price); ?> ₽</p>
    <p><strong>Способ доставки:</strong> <?php echo e($deliveryLabels[$order->delivery_method] ?? $order->delivery_method ?? 'Не указано'); ?></p>
    <p><strong>Способ оплаты:</strong> <?php echo e($paymentLabels[$order->payment_method] ?? $order->payment_method ?? 'Не указано'); ?></p>
</div>

<h3 style="margin:25px 0 12px;">
    Состав заказа
</h3>

<?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div style="border-bottom:1px solid #eee;padding:10px 0;">
        <strong><?php echo e($item->product->title ?? 'Товар удалён'); ?></strong><br>
        <?php echo e($item->qty); ?> шт. × <?php echo e($item->price); ?> ₽
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<a href="<?php echo e(route('orders.show', $order->id)); ?>"
   style="display:inline-block;background:#A86E2C;color:#fff;text-decoration:none;padding:14px 22px;border-radius:12px;margin-top:25px;">
    Открыть заказ
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/emails/new-order.blade.php ENDPATH**/ ?>