<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div><?php echo e(session('success')); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<form action="<?php echo e(route('order.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <input type="text" name="title" placeholder="Название заказа" required>
    <input type="number" step="0.01" name="price" placeholder="Цена" required>
    <button type="submit">Создать заказ</button>
</form>
<?php /**PATH D:\xampp\htdocs\mokronose\resources\views/orders/create.blade.php ENDPATH**/ ?>