<div class="profile-reviews">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">⭐ Мои отзывы</h1>
            <p>Отзывы, которые вы оставляли на товары</p>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $product = $review->product;
            $preview = $product?->images->where('is_preview', true)->first()
                ?? $product?->images->first();
        ?>

        <div class="review-card">

            <div class="review-card__image">
                <?php if($preview): ?>
                    <img src="<?php echo e(asset('storage/' . $preview->image)); ?>" alt="<?php echo e($product->title); ?>">
                <?php else: ?>
                    <span>Нет фото</span>
                <?php endif; ?>
            </div>

            <div class="review-card__content">

                <div class="review-card__top">
                    <div>
                        <h3>
                            <?php if($product): ?>
                                <a href="<?php echo e(route('product', $product->id)); ?>">
                                    <?php echo e($product->title); ?>

                                </a>
                            <?php else: ?>
                                Товар удалён
                            <?php endif; ?>
                        </h3>

                        <div class="review-date">
                            <?php echo e($review->created_at->format('d.m.Y')); ?>

                        </div>
                    </div>

                    <div class="review-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php echo e($i <= $review->rating ? '★' : '☆'); ?>

                        <?php endfor; ?>
                    </div>
                </div>

                <p class="review-text">
                    <?php echo e($review->text ?? $review->comment ?? 'Без текста'); ?>

                </p>

                <?php if($product): ?>
                    <a href="<?php echo e(route('product', $product->id)); ?>" class="btn-secondary">
                        Смотреть товар
                    </a>
                <?php endif; ?>

            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-block">
            <h3>⭐ У вас пока нет отзывов</h3>
            <p>После покупки товара вы сможете оставить отзыв.</p>

            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">
                Перейти в каталог
            </a>
        </div>
    <?php endif; ?>

</div><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/reviews.blade.php ENDPATH**/ ?>