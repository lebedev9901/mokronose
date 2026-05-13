<?php $__env->startSection('title', 'Профиль'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
<div class="dashboard" >

    
    <div class="dashboard__sidebar" >
        <?php echo $__env->make('profile.sections.menu', ['current_page' => $page], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="dashboard__content" >
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