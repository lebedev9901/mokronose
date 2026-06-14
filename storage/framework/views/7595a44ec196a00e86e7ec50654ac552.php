<?php if($products->count()): ?>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <?php
    $preview = $product->images->where('is_preview', true)->first()
        ?? $product->images->first();

    $ageLabels = [
        'puppy' => 'Щенкам',
        'junior' => 'Юниорам',
        'adult' => 'Взрослым',
    ];

    $breedLabels = [
        'small' => 'Мелким породам',
        'medium' => 'Средним породам',
        'large' => 'Крупным породам',
    ];

    $productAgeGroups = is_array($product->age_group)
        ? $product->age_group
        : (json_decode($product->age_group, true) ?: []);

    $productBreedSizes = is_array($product->breed_size)
        ? $product->breed_size
        : (json_decode($product->breed_size, true) ?: []);
?>

        <article
            class="product-card"
            data-title="<?php echo e(e($product->title)); ?>"
            data-desc="<?php echo e(e($product->description)); ?>"
            data-price="<?php echo e($product->price); ?>₽"
            data-weight="<?php echo e(e($product->weight)); ?>"
            data-rating="<?php echo e($product->rating); ?>"
            data-image="<?php echo e($preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png')); ?>"
            data-link="<?php echo e(route('product', $product->id)); ?>"
        >

            <?php if(auth()->guard()->check()): ?>
                <?php
                    $isFavorite = in_array($product->id, $favoriteIds ?? []);
                ?>

                <button
                    type="button"
                    class="favorite-btn <?php echo e($isFavorite ? 'is-active' : ''); ?>"
                    data-product-id="<?php echo e($product->id); ?>"
                    onclick="toggleFavorite(this)"
                    aria-label="Добавить в избранное"
                >
                    <svg class="favorite-icon" viewBox="0 0 24 24">
                        <path d="M12 21s-6.8-4.4-9.4-8.5C.8 9.6 1.4 5.8 4.4 4.2c2.1-1.2 4.7-.6 6.1 1.2L12 7.2l1.5-1.8c1.4-1.8 4-2.4 6.1-1.2 3 1.6 3.6 5.4 1.8 8.3C18.8 16.6 12 21 12 21z"/>
                    </svg>
                </button>
            <?php endif; ?>

            <button type="button" class="product-quick-btn" data-product-id="<?php echo e($product->id); ?>">
                Быстрый просмотр
            </button>

            <div class="product-image">
                <img
                    src="<?php echo e($preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png')); ?>"
                    alt="<?php echo e($product->title); ?>"
                    loading="lazy"
                >
            </div>

            <div class="product-info">

                <div class="product-badges">
                    <?php $__currentLoopData = $productAgeGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($ageLabels[$age])): ?>
                            <span class="product-badge">
                                <?php echo e($ageLabels[$age]); ?>

                            </span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $productBreedSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($breedLabels[$breed])): ?>
                            <span class="product-badge product-badge--soft">
                                <?php echo e($breedLabels[$breed]); ?>

                            </span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <a href="<?php echo e(route('product', $product->id)); ?>" class="product-title">
                    <?php echo e($product->title); ?>

                </a>

                <p class="product-desc">
                    <?php echo e($product->description); ?>

                </p>

                <div class="product-rating">
                    <span class="rating_text">⭐ <?php echo e($product->rating); ?></span>
                </div>

                <div class="product-meta">
                    <span class="product-weight"><?php echo e($product->weight); ?></span>
                    <span class="product-price"><?php echo e($product->price); ?>₽</span>
                </div>

                <div class="product-actions" data-id="<?php echo e($product->id); ?>">

                    <form class="product-cart-form">
                        <?php echo csrf_field(); ?>

                        <?php
                            $cartQty = $cartQuantities[$product->id] ?? 0;
                        ?>

                        <div class="product-cart-control" data-product="<?php echo e($product->id); ?>">

                            <button
                                type="button"
                                class="btn product-btn add-to-cart"
                                data-id="<?php echo e($product->id); ?>"
                                style="<?php echo e($cartQty > 0 ? 'display:none;' : ''); ?>"
                            >
                                В корзину
                            </button>

                            <div class="cart-qty-control <?php echo e($cartQty > 0 ? '' : 'hidden'); ?>">

                                <button type="button" class="qty-btn qty-minus">−</button>

                                <span class="qty-value">
                                    <?php echo e($cartQty > 0 ? $cartQty : 1); ?>

                                </span>

                                <button type="button" class="qty-btn qty-plus">+</button>

                            </div>

                        </div>
                    </form>

                    <a href="<?php echo e(route('product', $product->id)); ?>" class="btn-accent product__link">
                        Подробнее
                    </a>

                </div>
                
            </div>
                
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>

    <div class="catalog-empty">
        <h3>Товары не найдены</h3>
        <p>Попробуйте изменить фильтры или выбрать другую категорию.</p>
    </div>

<?php endif; ?>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/partials/product.blade.php ENDPATH**/ ?>