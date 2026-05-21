

<?php $__env->startSection('title', 'Создать товар'); ?>

<?php $__env->startSection('content'); ?>

<h1>Создать товар</h1>

<form action="<?php echo e(route('admin.products.store')); ?>"
      method="POST"
      enctype="multipart/form-data">

    <?php echo csrf_field(); ?>

    
    <div>
        <label>Название</label>
        <input type="text" name="title" required>
    </div>

    
    <div>
        <label>Описание</label>
        <textarea name="description"></textarea>
    </div>

    
    <div>
        <label>Вес (кг)</label>
        <input type="number" step="0.01" name="weight" required>
    </div>

    
    <div>
        <label>Цена</label>
        <input type="number" step="0.01" name="price" required>
    </div>

    
    <div>
        <label>Остаток</label>
        <input type="number" name="stock" value="0">
    </div>

    <select name="category_id">

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label style="display:block;">
        <input type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>">
        <?php echo e($category->title); ?>

    </label>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

    
    <div>
        <label>Фото товара</label>
        <input type="file" name="images[]" multiple accept="image/*">
    </div>

    
    <div>
        <label>Какое фото сделать главным?</label>
        <small>Сделаем позже визуально — пока индексом</small>

        <input type="number" name="preview_index" value="0" min="0">
    </div>

    <button type="submit">
        Создать товар
    </button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/create.blade.php ENDPATH**/ ?>