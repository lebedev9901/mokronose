

<?php $__env->startSection('title', 'Категории'); ?>
<?php $__env->startSection('page-title', 'Категории'); ?>
<?php $__env->startSection('page-subtitle', 'Управление категориями и подкатегориями'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-form-card admin-category-create">
    <h3>Добавить категорию</h3>

    <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST" class="admin-category-form">
        <?php echo csrf_field(); ?>

        <div class="admin-field">
            <label>Название категории</label>
            <input type="text" name="title" placeholder="Например: Сухой корм" required>
        </div>

        <div class="admin-field">
            <label>Родительская категория</label>
            <select name="parent_id">
                <option value="">Без родителя — основная категория</option>

                <?php $__currentLoopData = $categories->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>">
                        <?php echo e($category->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button class="admin-btn">
            Добавить
        </button>
    </form>
</div>

<div class="admin-page-head">
    <div>
        <h2>Список категорий</h2>
        <p>Всего категорий: <?php echo e($categories->count()); ?></p>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Категория</th>
                <th>Тип</th>
                <th>Товаров</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <strong>
                            <?php if($cat->parent_id): ?>
                                — <?php echo e($cat->title); ?>

                            <?php else: ?>
                                <?php echo e($cat->title); ?>

                            <?php endif; ?>
                        </strong>
                    </td>

                    <td>
                        <?php if($cat->parent_id): ?>
                            <span class="admin-status admin-status--info">Подкатегория</span>
                        <?php else: ?>
                            <span class="admin-status admin-status--success">Основная</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <strong><?php echo e($cat->products_count); ?></strong>
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="<?php echo e(route('admin.categories.destroy', $cat->id)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Удалить категорию?')">
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
                    <td colspan="4" class="admin-empty">
                        Категории пока не добавлены
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>