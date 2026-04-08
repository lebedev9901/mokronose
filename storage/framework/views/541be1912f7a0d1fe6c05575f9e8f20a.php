<h1>Профиль</h1>
<div class="dashboard">

    <div class="profile-card">
        <div class="profile-avatar">
            <img src="<?php echo e($user->avatar ?? '/img/default-avatar.png'); ?>" alt="">
        </div>

        <div class="profile-info">
            <h2><?php echo e($user->name); ?></h2>
            <p><?php echo e($user->email); ?></p>
        </div>

        <div class="profile-actions">
            <a href="#" class="btn">Редактировать</a>
        </div>
    </div>

</div><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/profile.blade.php ENDPATH**/ ?>