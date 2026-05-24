<?php $__env->startSection('title', 'Отзывы'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="reviews__contain flex">

  

    <h1>Отзывы клиентов</h1>

    <div class="reviews-grid">

        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="reviews__card">

    <!-- ⭐ Рейтинг -->
    <div class="reviews__card-rating">
        <?php for($i = 1; $i <= 5; $i++): ?>
            <span class="<?php echo e($i <= $review->rating ? 'star active' : 'star'); ?>">
                ★
            </span>
        <?php endfor; ?>
    </div>

    <!-- 💬 Текст -->
    <p class="reviews__card-text">
        <?php echo e($review->text); ?>

    </p>

    <!-- 👤 Пользователь -->
    <div class="reviews__card-user">
        <div class="avatar">
            <?php echo e(mb_substr($review->user->name, 0, 1)); ?>

        </div>

        <div>
            <div class="name"><?php echo e($review->user->name); ?></div>
            <div class="date"><?php echo e($review->created_at->format('d.m.Y')); ?></div>
        </div>
    </div>

    <!-- 📦 Товар -->
    <a href="<?php echo e(route('product', $review->product->id)); ?>" class="reviews__card-product">
        <?php echo e($review->product->title); ?>

    </a>

</div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
           <div class="custom-pagination">
    <?php if($reviews->onFirstPage()): ?>
        <span class="disabled">«</span>
    <?php else: ?>
        <a href="<?php echo e($reviews->previousPageUrl()); ?>">«</a>
    <?php endif; ?>

    <?php $__currentLoopData = $reviews->getUrlRange(1, $reviews->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($page == $reviews->currentPage()): ?>
            <span class="active"><?php echo e($page); ?></span>
        <?php else: ?>
            <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($reviews->hasMorePages()): ?>
        <a href="<?php echo e($reviews->nextPageUrl()); ?>">»</a>
    <?php else: ?>
        <span class="disabled">»</span>
    <?php endif; ?>
</div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/pages/reviews.blade.php ENDPATH**/ ?>