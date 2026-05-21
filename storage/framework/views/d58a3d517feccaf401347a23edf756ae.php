

<?php $__env->startSection('title', 'Редактирование товара'); ?>

<?php $__env->startSection('content'); ?>

<h1>Редактирование товара</h1>

<form action="<?php echo e(route('admin.products.update', $product->id)); ?>"
      method="POST"
      enctype="multipart/form-data">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div>
        <label>Название</label>
        <input type="text" name="title" value="<?php echo e($product->title); ?>">
    </div>

    
    <div>
        <label>Описание</label>
        <textarea name="description"><?php echo e($product->description); ?></textarea>
    </div>

    
    <div>
        <label>Вес</label>
        <input type="number" step="0.01" name="weight" value="<?php echo e($product->weight); ?>">
    </div>

    
    <div>
        <label>Цена</label>
        <input type="number" step="0.01" name="price" value="<?php echo e($product->price); ?>">
    </div>

    
    <div>
        <label>Остаток</label>
        <input type="number" name="stock" value="<?php echo e($product->stock); ?>">
    </div>




<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label style="display:block;">
        <input type="checkbox"
               name="categories[]"
               value="<?php echo e($category->id); ?>"

               
               <?php echo e($product->categories->contains($category->id) ? 'checked' : ''); ?>>

        <?php echo e($category->title); ?>

    </label>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



    
    <div style="margin-top:15px;">
        <label>Фото товара</label>
        <input type="file" name="images[]" multiple>
    </div>

    
    <div style="margin-top:20px;">
    <h3>Текущие фото</h3>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div style="position:relative;" data-id="<?php echo e($img->id); ?>">

                <img src="<?php echo e(asset('storage/' . $img->image)); ?>"
                     style="width:90px; height:90px; object-fit:cover; border-radius:8px;">

                
                <?php if($img->is_preview): ?>
                    <div style="position:absolute; top:0; left:0; background:#22c55e; color:white; font-size:10px; padding:2px;">
                        MAIN
                    </div>
                <?php endif; ?>

                
                <div style="display:flex; gap:5px; margin-top:5px;">

                    <button type="button"
                            onclick="setPreview(<?php echo e($img->id); ?>)"
                            style="font-size:10px;">
                        ⭐
                    </button>

                    <button type="button"
                            onclick="deleteImage(<?php echo e($img->id); ?>)"
                            style="font-size:10px; color:red;">
                        🗑
                    </button>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>

    <button class="btn btn-primary" style="margin-top:20px;">
        Сохранить
    </button>

</form>

<script>

function deleteImage(id) {

    fetch(`/admin/products/images/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    });

}

function setPreview(id) {

    fetch(`/admin/products/images/${id}/preview`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    });

}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>