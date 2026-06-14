

<?php $__env->startSection('title', 'Редактирование пользователя'); ?>
<?php $__env->startSection('page-title', 'Редактирование пользователя'); ?>
<?php $__env->startSection('page-subtitle', $user->name); ?>

<?php $__env->startSection('content'); ?>

<form method="POST"
      action="<?php echo e(route('admin.users.update', $user->id)); ?>"
      class="admin-form">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="admin-form-card">
        <h3>Данные пользователя</h3>

        <div class="admin-field">
            <label>Имя</label>
            <input type="text"
                   name="name"
                   value="<?php echo e(old('name', $user->name)); ?>"
                   required>
        </div>

        <div class="admin-field">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="<?php echo e(old('email', $user->email)); ?>"
                   required>
        </div>

        <div class="admin-field">
            <label>Роль</label>
            <select name="role">
                <option value="user" <?php if(old('role', $user->role) === 'user'): echo 'selected'; endif; ?>>
                    Пользователь
                </option>

                <option value="support" <?php if(old('role', $user->role) === 'support'): echo 'selected'; endif; ?>>
                    Поддержка
                </option>

                <option value="admin" <?php if(old('role', $user->role) === 'admin'): echo 'selected'; endif; ?>>
                    Администратор
                </option>
            </select>
        </div>
    </div>

    <div class="admin-form-actions">
        <a href="<?php echo e(route('admin.users')); ?>" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить
        </button>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>