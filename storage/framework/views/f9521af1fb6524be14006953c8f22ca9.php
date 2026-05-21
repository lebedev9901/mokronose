

<?php $__env->startSection('title', 'Категории'); ?>

<?php $__env->startSection('content'); ?>

<h1>Категории</h1>

<form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <input type="text" name="title" placeholder="Название категории">
    <select name="parent_id">
        <option value="">Без родителя — основная категория</option>

        <?php $__currentLoopData = $categories->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($category->id); ?>">
                <?php echo e($category->title); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn btn-primary">Добавить</button>

</form>

<hr>

<table class="table">

    <tr>
        <th>Категория</th>
        <th>Товаров</th>
        <th>Действия</th>
    </tr>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <tr>

        <td><?php echo e($cat->title); ?></td>

        
        <td>
            <?php echo e($cat->products_count); ?>

        </td>

        <td>

            <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>"
               class="btn btn-primary" style="padding:5px 10px;">
                Изменить
            </a>

            <form action="<?php echo e(route('admin.categories.destroy', $cat->id)); ?>"
                  method="POST"
                  style="display:inline-block;">

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <button class="btn btn-danger" style="padding:5px 10px;">
                    Удалить
                </button>

            </form>

        </td>

    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>