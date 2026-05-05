

<?php $__env->startSection('title', 'Профиль'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
<<<<<<< HEAD
<div class="dashboard" >

    
    <div class="dashboard__sidebar" >
=======
<div class="profile-container" >

    
    <div class="profile-menu" >
>>>>>>> 6c8703de2f5adfd1e5348e4946eaaf01427e01e0
        <?php echo $__env->make('profile.sections.menu', ['current_page' => $page], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
<<<<<<< HEAD
    <div class="dashboard__content" >
=======
    <div class="profile-content" >
>>>>>>> 6c8703de2f5adfd1e5348e4946eaaf01427e01e0
        <?php
            $section = match($page) {
                'orders'    => 'profile.sections.orders',
                'pet'       => 'profile.sections.pet',
                'addresses' => 'profile.sections.addresses',
                'support'   => 'profile.sections.support',
                'reviews'   => 'profile.sections.reviews',
                default     => 'profile.sections.profile',
            };
        ?>

        <?php echo $__env->make($section, ['page' => $page, 'orders' => $orders], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/index.blade.php ENDPATH**/ ?>