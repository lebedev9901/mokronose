

<?php $__env->startSection('title', 'Редактировать новость'); ?>
<?php $__env->startSection('page-title', 'Редактировать новость'); ?>
<?php $__env->startSection('page-subtitle', $news->title); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.news.update', $news)); ?>"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="admin-form-card">
        <h3>Основная информация</h3>

        <div class="admin-field">
            <label>Заголовок</label>
            <input type="text" name="title" value="<?php echo e(old('title', $news->title)); ?>" required>
        </div>

        <div class="admin-field">
            <label>Описание</label>
            <textarea name="description"><?php echo e(old('description', $news->description)); ?></textarea>
        </div>

        <?php if($news->image): ?>
            <div class="admin-current-news-image">
                <label>Текущее фото</label>
                <img src="<?php echo e(asset('storage/' . $news->image)); ?>" alt="<?php echo e($news->title); ?>">
            </div>
        <?php endif; ?>

        <div class="admin-field">
            <label>Новое фото</label>
            <input type="file" name="image" accept="image/*">
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Кнопка и публикация</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Текст кнопки</label>
                <input type="text" name="button_text" value="<?php echo e(old('button_text', $news->button_text)); ?>">
            </div>

            <div class="admin-field">
                <label>Ссылка кнопки</label>
                <input type="text" name="button_url" value="<?php echo e(old('button_url', $news->button_url)); ?>">
            </div>

            <div class="admin-field">
                <label>Порядок сортировки</label>
                <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $news->sort_order)); ?>">
            </div>

            <div class="admin-field">
                <label>Дата публикации</label>
                <input type="datetime-local"
                       name="published_at"
                       value="<?php echo e(old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '')); ?>">
            </div>
        </div>

        <label class="admin-switch">
            <input type="checkbox" name="is_active" <?php echo e(old('is_active', $news->is_active) ? 'checked' : ''); ?>>
            <span>Активна</span>
        </label>
    </div>

    <div class="admin-form-actions">
        <a href="<?php echo e(route('admin.news')); ?>" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить
        </button>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/news/edit.blade.php ENDPATH**/ ?>