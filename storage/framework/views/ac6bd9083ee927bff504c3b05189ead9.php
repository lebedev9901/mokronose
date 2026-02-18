

<?php $__env->startSection('title', 'Профиль'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
<div class="profile-container" style="display:flex; gap:20px; align-items:flex-start; min-height:400px;">

    
    <div class="profile-menu" style="width:250px;">
        <?php echo $__env->make('profile.sections.menu', ['current_page' => $page], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="profile-content" style="flex:1;">
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

        <?php echo $__env->make($section, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\mokronose\resources\views/profile/index.blade.php ENDPATH**/ ?>