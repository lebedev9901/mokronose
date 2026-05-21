

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="product-page">
        <div class="product-page__grid">
            <div class="product-gallery">

            <?php
                $preview = $product->images->where('is_preview', true)->first()
                    ?? $product->images->first();
            ?>

            <?php if($preview): ?>

                <div class="product-main-image-wrapper">
                    <img
                        id="mainProductImage"
                        src="<?php echo e(asset('storage/' . $preview->image)); ?>"
                        class="product-main-img"
                    >
                </div>

                <?php if($product->images->count() > 1): ?>

                    <div class="product-thumbs">

                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <img
                                src="<?php echo e(asset('storage/' . $image->image)); ?>"
                                class="product-thumb <?php echo e($preview->id === $image->id ? 'active' : ''); ?>"
                                onclick="changeProductImage(this)"
                            >

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>
            <div class="product-info">

                <h1 class="product-title"><?php echo e($product->title); ?></h1>

                <?php if($product->categories->isNotEmpty()): ?>
                    <div class="product-card-categories">
                        <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('catalog', ['category' => $category->id])); ?>" class="product-card-category">
                                <?php echo e($category->title); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="product-rating">
                    ⭐ <?php echo e($product->rating ?? '4.8'); ?>

                </div>

                <p class="product-desc">
                    <?php echo e($product->description); ?>

                </p>

                <div class="product-price">
                    <?php echo e($product->price); ?> ₽
                </div>

                <form>
                        <?php echo csrf_field(); ?>
                        <button type="button" class="btn product-btn add-to-cart" data-id="<?php echo e($product->id); ?>">
                            В корзину
                        </button>
                </form>
                <div class="product-benefits">
                    <div>🐶 100% натуральный состав</div>
                    <div>🚚 Быстрая доставка</div>
                </div>
            </div>
        </div>
        <?php if(auth()->guard()->check()): ?>
        <form method="POST"
      action="<?php echo e(route('product.reviews.store', $product)); ?>"
      enctype="multipart/form-data"
      class="review-form">
    <?php echo csrf_field(); ?>

    <label>Оценка</label>
    <select name="rating" required>
        <option value="5">5 — Отлично</option>
        <option value="4">4 — Хорошо</option>
        <option value="3">3 — Нормально</option>
        <option value="2">2 — Плохо</option>
        <option value="1">1 — Ужасно</option>
    </select>

    <label>Отзыв</label>
    <textarea name="text" required placeholder="Напишите отзыв"></textarea>

    <label class="review-upload">
        <input type="file" name="images[]" multiple accept="image/*" id="reviewImages">
        <span>📷 Добавить фото</span>
        <small>Можно выбрать несколько изображений</small>
    </label>

    <div class="review-preview" id="reviewPreview"></div>

    <button type="submit" class="btn">Оставить отзыв</button>
</form>
        <?php else: ?>
        <p>
            Чтобы оставить отзыв, 
            <a href="<?php echo e(route('vk.sdk-login')); ?>">войдите через VK</a>
            или авторизуйтесь.
        </p>
        <?php endif; ?>
        <div class="product-reviews">

            <h2 class="section-title">Отзывы о товаре</h2>

            <?php if($product->reviews->count()): ?>
                <div class="reviews-grid">

                    <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="review-card">

                            <div class="review-rating">
                                ⭐ <?php echo e($review->rating); ?>

                            </div>

                            <p class="review-text">
                                <?php echo e($review->text); ?>

                            </p>

                            <?php if($review->images->count()): ?>
                                <div class="review-images">
                                    <?php $__currentLoopData = $review->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(asset('storage/' . $image->path)); ?>" target="_blank">
                                            <img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="Фото отзыва">
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="review-author">
                                <div class="review-avatar">

                                    <?php if($review->user?->avatar): ?>

                                        <img
                                            
                                            src="<?php echo e($review->user->avatar ?? '/img/default-avatar.png'); ?>" 
                                            alt="<?php echo e($review->user?->first_name ?? $review->user?->name); ?>"
                                            class="review-avatar-img"
                                        >

                                    <?php else: ?>

                                        <span>
                                            <?php echo e(mb_substr($review->user?->first_name ?? $review->user?->name ?? 'П', 0, 1)); ?>

                                        </span>

                                    <?php endif; ?>

                                </div>

                                <div>
                                    <div class="review-name">
                                        <?php echo e($review->user?->first_name ?? $review->user?->name ?? 'Пользователь'); ?>

                                    </div>
                                    <div class="review-date">
                                        <?php echo e($review->created_at->format('d.m.Y')); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            <?php else: ?>
                <p class="no-reviews">Пока нет отзывов. Будьте первым!</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    function changeProductImage(el) {
        document.getElementById('mainProductImage').src = el.src;

        document.querySelectorAll('.product-thumb').forEach((img) => {
            img.classList.remove('active');
        });

        el.classList.add('active');
    }
</script>
<script>
document.addEventListener('change', function (event) {
    if (event.target.id !== 'reviewImages') return;

    const preview = document.getElementById('reviewPreview');
    preview.innerHTML = '';

    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();

        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        };

        reader.readAsDataURL(file);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/product/show.blade.php ENDPATH**/ ?>