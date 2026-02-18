

<?php $__env->startSection('title', 'Профиль'); ?>
<?php $__env->startSection('content'); ?>

<?php
// Определяем текущую страницу, если нет - profile
$page = $page ?? 'profile';
?>

<div class="profile-container" style="display:flex; gap:20px; align-items:flex-start; min-height:400px;">

    
    <div class="profile-menu" style="width:250px;">
        <?php echo $__env->make('profile.sections.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="profile-content" style="flex:1;">
        <?php
            // Выбираем, какую секцию подключать
            $section = match($page) {
                'orders'    => 'profile.sections.orders',
                'pet'       => 'profile.sections.pet',
                'addresses' => 'profile.sections.addresses',
                'support'   => 'profile.sections.support',
                'reviews'   => 'profile.sections.reviews',
                default     => 'profile.sections.menu', // защита от несуществующей страницы
            };
        ?>

        <?php echo $__env->make($section, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>


<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\mokronose\resources\views/profile/index.blade.php ENDPATH**/ ?>