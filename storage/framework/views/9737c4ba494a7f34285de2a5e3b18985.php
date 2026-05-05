<h3>Добавить адрес</h3>

<form method="POST" action="<?php echo e(route('addresses.store')); ?>">
    <?php echo csrf_field(); ?>

    <input type="text" name="city" placeholder="Город">
    <input type="text" name="street" placeholder="Улица" required>
    <input type="text" name="house" placeholder="Дом" required>
    <input type="text" name="apartment" placeholder="Квартира">

    <button type="submit">Сохранить</button>
</form><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/create-addr.blade.php ENDPATH**/ ?>