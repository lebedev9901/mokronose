

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

    <hr>

    <h3>Характеристики товара</h3>

    <div>
        <label>Белки</label>
        <input type="text" name="proteins" placeholder="24%">
    </div>

    <div>
        <label>Жиры</label>
        <input type="text" name="fats" placeholder="14%">
    </div>

    <div>
        <label>Углеводы</label>
        <input type="text" name="carbohydrates" placeholder="45%">
    </div>

    <div>
        <label>Энергетическая ценность</label>
        <input type="text" name="energy_value" placeholder="380 ккал / 100г">
    </div>

    <div>
        <label>Срок годности</label>
        <input type="text" name="shelf_life">
    </div>

    <div>
        <label>Состав</label>
        <textarea name="composition"></textarea>
    </div>

    <div>
        <label>Условия хранения</label>
        <textarea name="storage_conditions"></textarea>
    </div>

    <div>
        <label>Рекомендации по кормлению</label>
        <textarea name="recommendations"></textarea>
    </div>

    <div>
        <label>Возраст</label>

        <select name="age_group">
            <option value="all">Все возрасты</option>
            <option value="puppy">Щенок</option>
            <option value="junior">Юниор</option>
            <option value="adult">Взрослый</option>
        </select>
    </div>

    <div>
        <label>Порода</label>

        <select name="breed_size">
            <option value="all">Все породы</option>
            <option value="small">Мелкие</option>
            <option value="medium">Средние</option>
            <option value="large">Крупные</option>
        </select>
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

    <div>
    <label>Категории</label>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label style="display:block;">
            <input
                type="checkbox"
                name="categories[]"
                value="<?php echo e($category->id); ?>"
            >
            <?php echo e($category->title); ?>

        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

</select>


    
    <div>
        <label>Фото товара</label>

        <input
            type="file"
            name="images[]"
            id="imagesInput"
            multiple
            accept="image/*"
        >
    </div>

    <div
        id="imagePreviewContainer"
        style="
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            margin-top:20px;
        "
    ></div>

    <button type="submit">
        Создать товар
    </button>

</form>
<script>

document
    .getElementById('imagesInput')
    .addEventListener('change', function (e) {

        const container =
            document.getElementById(
                'imagePreviewContainer'
            );

        container.innerHTML = '';

        Array.from(e.target.files)
            .forEach((file, index) => {

                const reader =
                    new FileReader();

                reader.onload = function (event) {

                    const wrapper =
                        document.createElement('div');

                    wrapper.style.width = '180px';

                    wrapper.innerHTML = `
                        <img
                            src="${event.target.result}"
                            style="
                                width:180px;
                                height:180px;
                                object-fit:cover;
                                border-radius:10px;
                                border:1px solid #ddd;
                            "
                        >

                        <div style="margin-top:10px">
                            <label>
                                <input
                                    type="radio"
                                    name="preview_index"
                                    value="${index}"
                                    ${index === 0 ? 'checked' : ''}
                                >
                                Главное фото
                            </label>
                        </div>
                    `;

                    container.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/products/create.blade.php ENDPATH**/ ?>