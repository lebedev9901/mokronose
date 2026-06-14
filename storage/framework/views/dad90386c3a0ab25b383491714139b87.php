

<?php $__env->startSection('title', 'Создать товар'); ?>
<?php $__env->startSection('page-title', 'Создать товар'); ?>
<?php $__env->startSection('page-subtitle', 'Добавление нового товара в каталог'); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.products.store')); ?>"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    <?php echo csrf_field(); ?>

    <div class="admin-form-grid">

        <div class="admin-form-card">
            <h3>Основная информация</h3>

            <div class="admin-field">
                <label>Название</label>
                <input type="text" name="title" required>
            </div>

            <div class="admin-field">
                <label>Описание</label>
                <textarea name="description"></textarea>
            </div>

            <div class="admin-field">
                <label>Вес (кг)</label>
                <input type="number" step="0.01" name="weight" required>
            </div>

            <div class="admin-field">
                <label>Цена</label>
                <input type="number" step="0.01" name="price" required>
            </div>

            <div class="admin-field">
                <label>Остаток</label>
                <input type="number" name="stock" value="0">
            </div>
        </div>

        <div class="admin-form-card">
            <h3>Категории</h3>

            <div class="admin-checkbox-list">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label>
                        <input type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>">
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
                <input type="text" name="proteins" placeholder="24%">
            </div>

            <div class="admin-field">
                <label>Жиры</label>
                <input type="text" name="fats" placeholder="14%">
            </div>

            <div class="admin-field">
                <label>Углеводы</label>
                <input type="text" name="carbohydrates" placeholder="45%">
            </div>

            <div class="admin-field">
                <label>Энергетическая ценность</label>
                <input type="text" name="energy_value" placeholder="380 ккал / 100г">
            </div>

            <div class="admin-field">
                <label>Срок годности</label>
                <input type="text" name="shelf_life">
            </div>
        </div>
        <div class="admin-form-card">
    <h3>Подходит для</h3>

    <div class="admin-form-grid">
        <div>
            <label class="admin-section-label">Возраст</label>

            <div class="admin-checkbox-list">
                <label>
                    <input type="checkbox" name="age_group[]" value="puppy">
                    <span>Щенки</span>
                </label>

                <label>
                    <input type="checkbox" name="age_group[]" value="junior">
                    <span>Юниоры</span>
                </label>

                <label>
                    <input type="checkbox" name="age_group[]" value="adult">
                    <span>Взрослые</span>
                </label>
            </div>
        </div>

        <div>
            <label class="admin-section-label">Размер породы</label>

            <div class="admin-checkbox-list">
                <label>
                    <input type="checkbox" name="breed_size[]" value="small">
                    <span>Мелкие породы</span>
                </label>

                <label>
                    <input type="checkbox" name="breed_size[]" value="medium">
                    <span>Средние породы</span>
                </label>

                <label>
                    <input type="checkbox" name="breed_size[]" value="large">
                    <span>Крупные породы</span>
                </label>
            </div>
        </div>
    </div>
</div>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Состав</label>
                <textarea name="composition"></textarea>
            </div>

            <div class="admin-field">
                <label>Условия хранения</label>
                <textarea name="storage_conditions"></textarea>
            </div>

            <div class="admin-field">
                <label>Рекомендации по кормлению</label>
                <textarea name="recommendations"></textarea>
            </div>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Фото товара</h3>

        <div class="admin-field">
            <input type="file" name="images[]" id="imagesInput" multiple accept="image/*">
        </div>

        <div id="imagePreviewContainer" class="admin-image-preview"></div>
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="admin-btn">
            Создать товар
        </button>
    </div>

</form>

<script>
const imagesInput = document.getElementById('imagesInput');

if (imagesInput) {
    imagesInput.addEventListener('change', function (e) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (event) {
                const wrapper = document.createElement('div');
                wrapper.className = 'admin-preview-item';

                wrapper.innerHTML = `
                    <img src="${event.target.result}">
                    <label>
                        <input
                            type="radio"
                            name="preview_index"
                            value="${index}"
                            ${index === 0 ? 'checked' : ''}
                        >
                        Главное фото
                    </label>
                `;

                container.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/create.blade.php ENDPATH**/ ?>