

<?php $__env->startSection('title', 'Новости'); ?>
<?php $__env->startSection('page-title', 'Новости'); ?>
<?php $__env->startSection('page-subtitle', 'Управление баннерами и новостями на главной'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-head">
    <div>
        <h2>Список новостей</h2>
        <p>Всего новостей: <?php echo e($news->count()); ?></p>
    </div>

    <a href="<?php echo e(route('admin.news.create')); ?>" class="admin-btn">
        + Создать новость
    </a>
</div>

<div class="admin-news-grid">
    <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="admin-news-card">

            <div class="admin-news-card__image">
                <?php if($item->image): ?>
                    <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->title); ?>">
                <?php else: ?>
                    <span>Нет фото</span>
                <?php endif; ?>
            </div>

            <div class="admin-news-card__body">
                <div class="admin-news-card__top">
                    <?php if($item->is_active): ?>
                        <span class="admin-status admin-status--success">Активна</span>
                    <?php else: ?>
                        <span class="admin-status admin-status--danger">Скрыта</span>
                    <?php endif; ?>

                    <span class="admin-muted">Сортировка: <?php echo e($item->sort_order); ?></span>
                </div>

                <h3><?php echo e($item->title); ?></h3>

                <p><?php echo e(\Illuminate\Support\Str::limit($item->description, 140)); ?></p>

                <?php if($item->published_at): ?>
                    <div class="admin-news-date">
                        Дата публикации: <?php echo e($item->published_at->format('d.m.Y H:i')); ?>

                    </div>
                <?php endif; ?>

                <div class="admin-actions">
                    <a href="<?php echo e(route('admin.news.edit', $item)); ?>" class="admin-btn-light">
                        Редактировать
                    </a>

                    <form action="<?php echo e(route('admin.news.destroy', $item)); ?>"
                          method="POST"
                          onsubmit="return confirm('Удалить новость?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button class="admin-btn-danger">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="admin-form-card">
            <p class="admin-empty-text">Новостей пока нет.</p>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/news/index.blade.php ENDPATH**/ ?>