

<?php $__env->startSection('title', 'Новости'); ?>

<?php $__env->startSection('content'); ?>

<h1>Новости</h1>

<a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary">
    + Создать новость
</a>

<div style="margin-top:20px; display:grid; gap:15px;">
    <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="display:flex; gap:15px; align-items:center; padding:15px; border:1px solid #ddd; border-radius:12px;">
            <?php if($item->image): ?>
                <img src="<?php echo e(asset('storage/' . $item->image)); ?>"
                     style="width:100px; height:70px; object-fit:cover; border-radius:8px;">
            <?php endif; ?>

            <div style="flex:1;">
                <h3><?php echo e($item->title); ?></h3>
                <p><?php echo e($item->description); ?></p>

                <small>
                    <?php echo e($item->is_active ? 'Активна' : 'Скрыта'); ?>

                    |
                    Сортировка: <?php echo e($item->sort_order); ?>

                </small>
            </div>

            <a href="<?php echo e(route('admin.news.edit', $item)); ?>" class="btn">
                Редактировать
            </a>

            <form action="<?php echo e(route('admin.news.destroy', $item)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <button onclick="return confirm('Удалить новость?')" class="btn btn-danger">
                    Удалить
                </button>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>Новостей пока нет.</p>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/news/index.blade.php ENDPATH**/ ?>