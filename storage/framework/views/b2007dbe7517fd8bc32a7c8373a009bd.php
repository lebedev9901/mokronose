


<?php $__env->startSection('content'); ?>

<div class="container">


    <h1>
        ✅ Оплата прошла успешно!
    </h1>


    <p>
        Спасибо за заказ.
        Мы уже начали его обработку.
    </p>



    <a href="<?php echo e(route('home')); ?>">

        Вернуться в магазин

    </a>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/payment/success.blade.php ENDPATH**/ ?>