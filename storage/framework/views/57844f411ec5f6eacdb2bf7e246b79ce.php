

<?php $__env->startSection('title', 'Пользователи'); ?>
<?php $__env->startSection('page-title', 'Пользователи'); ?>
<?php $__env->startSection('page-subtitle', 'Управление аккаунтами пользователей'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Список пользователей</h2>
        <p>Всего пользователей: <?php echo e($users->count()); ?></p>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Дата регистрации</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="admin-muted">#<?php echo e($user->id); ?></td>

                    <td>
                        <strong><?php echo e($user->name); ?></strong>
                    </td>

                    <td><?php echo e($user->email); ?></td>

                    <td>
                        <?php if($user->role === 'admin'): ?>
                            <span class="admin-status admin-status--danger">Админ</span>
                        <?php elseif($user->role === 'support'): ?>
                            <span class="admin-status admin-status--info">Поддержка</span>
                        <?php else: ?>
                            <span class="admin-status admin-status--success">Пользователь</span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>

                    <td>
                        <div class="admin-actions">
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="<?php echo e(route('admin.users.destroy', $user->id)); ?>"
                                  onsubmit="return confirm('Удалить пользователя?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button class="admin-btn-danger">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="admin-empty">
                        Пользователи не найдены
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/users/index.blade.php ENDPATH**/ ?>