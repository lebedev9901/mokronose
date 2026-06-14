

<?php $__env->startSection('title', 'Товары'); ?>

<?php $__env->startSection('page-title', 'Товары'); ?>
<?php $__env->startSection('page-subtitle', 'Управление товарами магазина'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Список товаров</h2>
        <p>Всего товаров: <?php echo e($products->count()); ?></p>
    </div>

    <a href="<?php echo e(route('admin.products.create')); ?>" class="admin-btn">
        + Добавить товар
    </a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Остаток</th>
                <th>Категории</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="admin-muted">#<?php echo e($product->id); ?></td>

                    <td>
                        <div class="admin-thumbs">
                            <?php $__empty_2 = true; $__currentLoopData = $product->images->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <img src="<?php echo e(asset('storage/' . $img->image)); ?>" alt="<?php echo e($product->title); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <div class="admin-no-image">Нет фото</div>
                            <?php endif; ?>

                            <?php if($product->images->count() > 2): ?>
                                <div class="admin-more">
                                    +<?php echo e($product->images->count() - 2); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td>
                        <strong class="admin-product-title">
                            <?php echo e($product->title); ?>

                        </strong>
                    </td>

                    <td>
                        <strong><?php echo e(number_format($product->price, 0, ',', ' ')); ?> ₽</strong>
                    </td>

                    <td>
                        <?php if($product->stock > 0): ?>
                            <span class="admin-status admin-status--success">
                                <?php echo e($product->stock); ?> шт.
                            </span>
                        <?php else: ?>
                            <span class="admin-status admin-status--danger">
                                Нет
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="admin-tags">
                            <?php $__empty_2 = true; $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <span><?php echo e($category->title); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <span>Без категории</span>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Удалить товар?')">
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
                    <td colspan="7" class="admin-empty">
                        Товары пока не добавлены
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/index.blade.php ENDPATH**/ ?>