

<?php $__env->startSection('title', 'Редактирование товара'); ?>
<?php $__env->startSection('page-title', 'Редактирование товара'); ?>
<?php $__env->startSection('page-subtitle', $product->title); ?>

<?php $__env->startSection('content'); ?>

<?php
    $ageGroups = old('age_group', $product->age_group ?? []);
    $breedSizes = old('breed_size', $product->breed_size ?? []);
?>

<form action="<?php echo e(route('admin.products.update', $product->id)); ?>"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="admin-form-grid">

        <div class="admin-form-card">
            <h3>Основная информация</h3>

            <div class="admin-field">
                <label>Название</label>
                <input type="text" name="title" value="<?php echo e(old('title', $product->title)); ?>" required>
            </div>

            <div class="admin-field">
                <label>Описание</label>
                <textarea name="description"><?php echo e(old('description', $product->description)); ?></textarea>
            </div>

            <div class="admin-field">
                <label>Вес</label>
                <input type="number" step="0.01" name="weight" value="<?php echo e(old('weight', $product->weight)); ?>" required>
            </div>

            <div class="admin-field">
                <label>Цена</label>
                <input type="number" step="0.01" name="price" value="<?php echo e(old('price', $product->price)); ?>" required>
            </div>

            <div class="admin-field">
                <label>Остаток</label>
                <input type="number" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>">
            </div>
        </div>

        <div class="admin-form-card">
            <h3>Категории</h3>

            <div class="admin-checkbox-list">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label>
                        <input type="checkbox"
                               name="categories[]"
                               value="<?php echo e($category->id); ?>"
                               <?php echo e($product->categories->contains($category->id) ? 'checked' : ''); ?>>
                        <span><?php echo e($category->title); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>

    <div class="admin-form-card">
        <h3>Характеристики товара</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Белки</label>
                <input type="text" name="proteins" value="<?php echo e(old('proteins', $product->proteins)); ?>">
            </div>

            <div class="admin-field">
                <label>Жиры</label>
                <input type="text" name="fats" value="<?php echo e(old('fats', $product->fats)); ?>">
            </div>

            <div class="admin-field">
                <label>Углеводы</label>
                <input type="text" name="carbohydrates" value="<?php echo e(old('carbohydrates', $product->carbohydrates)); ?>">
            </div>

            <div class="admin-field">
                <label>Энергетическая ценность</label>
                <input type="text" name="energy_value" value="<?php echo e(old('energy_value', $product->energy_value)); ?>">
            </div>

            <div class="admin-field">
                <label>Срок годности</label>
                <input type="text" name="shelf_life" value="<?php echo e(old('shelf_life', $product->shelf_life)); ?>">
            </div>
        </div>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Состав</label>
                <textarea name="composition"><?php echo e(old('composition', $product->composition)); ?></textarea>
            </div>

            <div class="admin-field">
                <label>Условия хранения</label>
                <textarea name="storage_conditions"><?php echo e(old('storage_conditions', $product->storage_conditions)); ?></textarea>
            </div>

            <div class="admin-field">
                <label>Рекомендации</label>
                <textarea name="recommendations"><?php echo e(old('recommendations', $product->recommendations)); ?></textarea>
            </div>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Подходит для</h3>

        <div class="admin-form-grid">
            <div>
                <label class="admin-section-label">Возраст</label>

                <div class="admin-checkbox-list">
                    <label>
                        <input type="checkbox" name="age_group[]" value="puppy"
                            <?php echo e(in_array('puppy', $ageGroups) ? 'checked' : ''); ?>>
                        <span>Щенки</span>
                    </label>

                    <label>
                        <input type="checkbox" name="age_group[]" value="junior"
                            <?php echo e(in_array('junior', $ageGroups) ? 'checked' : ''); ?>>
                        <span>Юниоры</span>
                    </label>

                    <label>
                        <input type="checkbox" name="age_group[]" value="adult"
                            <?php echo e(in_array('adult', $ageGroups) ? 'checked' : ''); ?>>
                        <span>Взрослые</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="admin-section-label">Размер породы</label>

                <div class="admin-checkbox-list">
                    <label>
                        <input type="checkbox" name="breed_size[]" value="small"
                            <?php echo e(in_array('small', $breedSizes) ? 'checked' : ''); ?>>
                        <span>Мелкие породы</span>
                    </label>

                    <label>
                        <input type="checkbox" name="breed_size[]" value="medium"
                            <?php echo e(in_array('medium', $breedSizes) ? 'checked' : ''); ?>>
                        <span>Средние породы</span>
                    </label>

                    <label>
                        <input type="checkbox" name="breed_size[]" value="large"
                            <?php echo e(in_array('large', $breedSizes) ? 'checked' : ''); ?>>
                        <span>Крупные породы</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Текущие фото</h3>

        <div class="admin-current-images">
            <?php $__empty_1 = true; $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="admin-current-image">
                    <img src="<?php echo e(asset('storage/' . $img->image)); ?>">

                    <?php if($img->is_preview): ?>
                        <span class="admin-current-image__main">Главное</span>
                    <?php endif; ?>

                    <div class="admin-current-image__actions">
                        <button type="button" onclick="setPreview(<?php echo e($img->id); ?>)">
                            ⭐ Главное
                        </button>

                        <button type="button" onclick="deleteImage(<?php echo e($img->id); ?>)">
                            🗑 Удалить
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="admin-empty-text">Фото пока не добавлены</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Добавить новые фото</h3>

        <div class="admin-field">
            <input type="file" name="images[]" id="imagesInput" multiple accept="image/*">
        </div>

        <div id="imagePreviewContainer" class="admin-image-preview"></div>
    </div>

    <div class="admin-form-actions">
        <button class="admin-btn">
            Сохранить изменения
        </button>
    </div>

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
    .then(() => location.reload());
}

function setPreview(id) {
    fetch(`/admin/products/images/${id}/preview`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(res => res.json())
    .then(() => location.reload());
}

const imagesInput = document.getElementById('imagesInput');

if (imagesInput) {
    imagesInput.addEventListener('change', function (e) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';

        Array.from(e.target.files).forEach((file) => {
            const reader = new FileReader();

            reader.onload = function (event) {
                const wrapper = document.createElement('div');
                wrapper.className = 'admin-preview-item';

                wrapper.innerHTML = `
                    <img src="${event.target.result}">
                    <div class="admin-preview-label">Новое фото</div>
                `;

                container.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>