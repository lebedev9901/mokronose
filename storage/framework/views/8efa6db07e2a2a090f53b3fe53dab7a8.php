

<?php $__env->startSection('title', 'Товары'); ?>

<?php $__env->startSection('content'); ?>

<h1>Товары</h1>
<div style="margin-bottom: 20px;">
    <a href="<?php echo e(route('admin.products.create')); ?>"
       class="btn btn-primary">
        + Добавить товар
    </a>
</div>
<table class="table">

    <thead>
        <tr>
            <th>ID</th>
            <th>Фото</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Остаток</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
    </thead>

    <tbody>

        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>

                <td>
                    <?php echo e($product->id); ?>

                </td>

                <td>
                    <div class="thumbs">
                        <?php $__currentLoopData = $product->images->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $img->image)); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($product->images->count() > 2): ?>
                            <div class="more">
                                +<?php echo e($product->images->count() - 2); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </td>

                <td>
                    <?php echo e($product->title); ?>

                </td>

                <td>
                    <?php echo e($product->price); ?> ₽
                </td>
                <td>
                    <?php echo e($product->stock); ?> 
                </td>
                <td>
                    <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span style="
                        display:inline-block;
                        padding:3px 8px;
                        background:#eee;
                        border-radius:6px;
                        margin:2px;
                        font-size:12px;
                        color: black;
                    ">
                        <?php echo e($category->title); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                   class="btn btn-primary" style="padding: 6px 10px">
                        Редактировать
                    </a>

                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Удалить товар?')">

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                         <button class="btn btn-danger" style="padding:6px 10px;">
                            Удалить
                        </button>

                    </form>
                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/index.blade.php ENDPATH**/ ?>