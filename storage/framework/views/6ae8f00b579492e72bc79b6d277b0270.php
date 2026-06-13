

<?php $__env->startSection('title', $product->title . ' — Мокронос'); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($product->description), 160)); ?>

<?php $__env->startSection('content'); ?>
<?php
    $preview = $product->images->where('is_preview', true)->first()
        ?? $product->images->first();

    $mainImage = $preview
        ? asset('storage/' . $preview->image)
        : asset('assets/img/no-image.png');

    $ages = [
        'all' => 'Все возрасты',
        'puppy' => 'Щенки',
        'junior' => 'Юниоры',
        'adult' => 'Взрослые',
    ];

    $breeds = [
        'all' => 'Все породы',
        'small' => 'Мелкие породы',
        'medium' => 'Средние породы',
        'large' => 'Крупные породы',
    ];
?>

<div class="container">
    <section class="product-page">

        <div class="product-page__grid">

            <div class="product-gallery">
                <div class="product-main-image-wrapper">
                    <img
                        id="mainProductImage"
                        src="<?php echo e($mainImage); ?>"
                        class="product-main-img"
                        alt="<?php echo e($product->title); ?>"
                    >
                </div>

                <div class="product-thumbs">
                    <?php $__empty_1 = true; $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <img
                            src="<?php echo e(asset('storage/' . $image->image)); ?>"
                            class="product-thumb <?php echo e($preview && $preview->id === $image->id ? 'active' : ''); ?>"
                            onclick="changeProductImage(this)"
                            alt="<?php echo e($product->title); ?>"
                        >
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <img
                            src="<?php echo e(asset('assets/img/no-image.png')); ?>"
                            class="product-thumb active"
                            onclick="changeProductImage(this)"
                            alt="<?php echo e($product->title); ?>"
                        >
                    <?php endif; ?>
                </div>
            </div>

            <div class="product-info__show">

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

                <p class="product-desc-show">
                    <?php echo e($product->description); ?>

                </p>

                <div class="product-price">
                    <?php echo e($product->price); ?> ₽
                </div>

                <div class="product-actions" data-product-id="<?php echo e($product->id); ?>">
                    <button type="button" class="btn product-btn add-to-cart" data-id="<?php echo e($product->id); ?>">
                        В корзину
                    </button>

                    <?php if(auth()->guard()->check()): ?>
                        <?php
                            $isFavorite = in_array($product->id, $favoriteIds ?? []);
                        ?>

                        <button
                            type="button"
                            class="favorite__btn <?php echo e($isFavorite ? 'is-active' : ''); ?>"
                            data-product-id="<?php echo e($product->id); ?>"
                            onclick="toggleFavorite(this)"
                        >
                            <?php echo e($isFavorite ? 'В избранном' : 'В избранное'); ?>

                        </button>
                    <?php endif; ?>
                </div>

                <div class="product-benefits">
                    <div>🐶 100% натуральный состав</div>
                    <div>🚚 Быстрая доставка</div>
                    <div>🦴 Подходит для ежедневного рациона</div>
                </div>

            </div>
        </div>

        <div class="product-specs">
            <h3>Характеристики</h3>

            <div class="product-spec-row">
                <span>Подходит для</span>
                <strong>
                    <?php echo e($ages[$product->age_group ?? 'all'] ?? 'Все возрасты'); ?>

                    /
                    <?php echo e($breeds[$product->breed_size ?? 'all'] ?? 'Все породы'); ?>

                </strong>
            </div>

            <?php if($product->weight): ?>
                <div class="product-spec-row">
                    <span>Вес</span>
                    <strong><?php echo e($product->weight); ?></strong>
                </div>
            <?php endif; ?>

            <?php if($product->proteins): ?>
                <div class="product-spec-row">
                    <span>Белки</span>
                    <strong><?php echo e($product->proteins); ?></strong>
                </div>
            <?php endif; ?>

            <?php if($product->fats): ?>
                <div class="product-spec-row">
                    <span>Жиры</span>
                    <strong><?php echo e($product->fats); ?></strong>
                </div>
            <?php endif; ?>

            <?php if($product->carbohydrates): ?>
                <div class="product-spec-row">
                    <span>Углеводы</span>
                    <strong><?php echo e($product->carbohydrates); ?></strong>
                </div>
            <?php endif; ?>

            <?php if($product->energy_value): ?>
                <div class="product-spec-row">
                    <span>Энергоценность</span>
                    <strong><?php echo e($product->energy_value); ?></strong>
                </div>
            <?php endif; ?>

            <?php if($product->shelf_life): ?>
                <div class="product-spec-row">
                    <span>Срок годности</span>
                    <strong><?php echo e($product->shelf_life); ?></strong>
                </div>
            <?php endif; ?>
        </div>

        <?php if($product->composition): ?>
            <div class="product-info-block">
                <h3>Состав</h3>
                <p><?php echo e($product->composition); ?></p>
            </div>
        <?php endif; ?>

        <?php if($product->storage_conditions): ?>
            <div class="product-info-block">
                <h3>Условия хранения</h3>
                <p><?php echo e($product->storage_conditions); ?></p>
            </div>
        <?php endif; ?>

        <?php if($product->recommendations): ?>
            <div class="product-info-block">
                <h3>Рекомендации по кормлению</h3>
                <p><?php echo e($product->recommendations); ?></p>
            </div>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
            <form
                method="POST"
                action="<?php echo e(route('product.reviews.store', $product)); ?>"
                enctype="multipart/form-data"
                class="review-form"
            >
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

                <button type="submit" class="btn product-btn">
                    Оставить отзыв
                </button>
            </form>
        <?php else: ?>
            <p class="no-reviews">
                Чтобы оставить отзыв, <a href="<?php echo e(route('login')); ?>">авторизуйтесь</a>.
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
                                            src="<?php echo e($review->user->avatar); ?>"
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

    </section>
</div>

<script>
function changeProductImage(el) {
    const mainImage = document.getElementById('mainProductImage');

    if (!mainImage) return;

    mainImage.src = el.src;

    document.querySelectorAll('.product-thumb').forEach((img) => {
        img.classList.remove('active');
    });

    el.classList.add('active');
}

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

function toggleFavorite(button) {
    const productId = button.dataset.productId;

    fetch(`/favorites/${productId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        button.textContent = data.is_favorite ? 'В избранном' : 'В избранное';
        button.classList.toggle('is-active', data.is_favorite);
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/product/show.blade.php ENDPATH**/ ?>