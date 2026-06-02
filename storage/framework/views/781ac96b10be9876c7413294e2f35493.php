

<?php $__env->startSection('title', 'Редактировать новость'); ?>

<?php $__env->startSection('content'); ?>

<h1>Редактировать новость</h1>

<form action="<?php echo e(route('admin.news.update', $news)); ?>"
      method="POST"
      enctype="multipart/form-data"
      style="display:grid; gap:15px; max-width:700px;">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div>
        <label>Заголовок</label>
        <input type="text" name="title" value="<?php echo e($news->title); ?>" required>
    </div>

    <div>
        <label>Описание</label>
        <textarea name="description"><?php echo e($news->description); ?></textarea>
    </div>

    <?php if($news->image): ?>
        <div>
            <label>Текущее фото</label>
            <br>
            <img src="<?php echo e(asset('storage/' . $news->image)); ?>"
                 style="width:200px; height:120px; object-fit:cover; border-radius:12px;">
        </div>
    <?php endif; ?>

    <div>
        <label>Новое фото</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <div>
        <label>Текст кнопки</label>
        <input type="text" name="button_text" value="<?php echo e($news->button_text); ?>">
    </div>

    <div>
        <label>Ссылка кнопки</label>
        <input type="text" name="button_url" value="<?php echo e($news->button_url); ?>">
    </div>

    <div>
        <label>Порядок сортировки</label>
        <input type="number" name="sort_order" value="<?php echo e($news->sort_order); ?>">
    </div>

    <div>
        <label>Дата публикации</label>
        <input
            type="datetime-local"
            name="published_at"
            value="<?php echo e($news->published_at ? $news->published_at->format('Y-m-d\TH:i') : ''); ?>"
        >
    </div>

    <label>
        <input type="checkbox" name="is_active" <?php echo e($news->is_active ? 'checked' : ''); ?>>
        Активна
    </label>

    <button class="btn btn-primary">
        Сохранить
    </button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/news/edit.blade.php ENDPATH**/ ?>