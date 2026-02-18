


<?php $__env->startSection('title', 'корзина'); ?>
<?php $__env->startSection('content'); ?>
<h1>Корзина</h1>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->isEmpty()): ?>
    <p>Корзина пуста</p>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Товар</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
       <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<tr>
    <td><?php echo e($item->product->title); ?></td>
    <td><?php echo e(number_format($item->product->price, 2)); ?> ₽</td>
    <td>
        <form action="<?php echo e(route('cart.update', $item)); ?>" method="POST" style="display:inline-block;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="qty" value="<?php echo e($item->qty - 1); ?>">
            <button type="submit" <?php if($item->qty <= 1): ?> disabled <?php endif; ?>>-</button>
        </form>

        <?php echo e($item->qty); ?>


        <form action="<?php echo e(route('cart.update', $item)); ?>" method="POST" style="display:inline-block;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="qty" value="<?php echo e($item->qty + 1); ?>">
            <button type="submit">+</button>
        </form>
    </td>
    <td><?php echo e(number_format($item->qty * $item->product->price, 2)); ?> ₽</td>
    <td>
        <form action="<?php echo e(route('cart.remove', $item)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit">Удалить</button>
        </form>
    </td>
</tr>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </tbody>
     <tfoot>
            <tr>
                <td><strong>Всего товаров:</strong></td>
                <td></td>
                <td><?php echo e($cart->total_qty); ?></td>
                <td><?php echo e(number_format($cart->total_price, 2)); ?> ₽</td>
            </tr>
        </tfoot>
</table>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<form action="<?php echo e(route('cart.clear')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <button type="submit">Очистить корзину</button>
</form>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::check()): ?>
    <form action="<?php echo e(route('order.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit">Оформить заказ</button>
    </form>
<?php else: ?>
    <p>Чтобы оформить заказ, пожалуйста, <a href="<?php echo e(route('login')); ?>">войдите</a>.</p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\mokronose\resources\views/pages/cart.blade.php ENDPATH**/ ?>