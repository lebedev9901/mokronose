

<?php $__env->startSection('title', 'Создать новость'); ?>

<?php $__env->startSection('content'); ?>

<h1>Создать новость</h1>

<form action="<?php echo e(route('admin.news.store')); ?>"
      method="POST"
      enctype="multipart/form-data"
      style="display:grid; gap:15px; max-width:700px;">

    <?php echo csrf_field(); ?>

    <div>
        <label>Заголовок</label>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Описание</label>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>Фото</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <div>
        <label>Текст кнопки</label>
        <input type="text" name="button_text" placeholder="Подробнее">
    </div>

    <div>
        <label>Ссылка кнопки</label>
        <input type="text" name="button_url" placeholder="/catalog">
    </div>

    <div>
        <label>Порядок сортировки</label>
        <input type="number" name="sort_order" value="0">
    </div>

    <div>
        <label>Дата публикации</label>
        <input type="datetime-local" name="published_at">
    </div>

    <label>
        <input type="checkbox" name="is_active" checked>
        Активна
    </label>

    <button class="btn btn-primary">
        Создать
    </button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/news/create.blade.php ENDPATH**/ ?>