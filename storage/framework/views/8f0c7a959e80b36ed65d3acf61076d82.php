<?php
    $preview = $product->images->where('is_preview', true)->first()
        ?? $product->images->first();
?>

<div class="quick-product">
    <div class="quick-product__image">
        <img
            src="<?php echo e($preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png')); ?>"
            alt="<?php echo e($product->title); ?>"
        >
    </div>

    <div class="quick-product__info">
        <h3><?php echo e($product->title); ?></h3>

        <p class="quick-product__desc">
            <?php echo e($product->description); ?>

        </p>

        <div class="quick-product__meta">
            <span><?php echo e($product->weight); ?></span>
            <strong><?php echo e($product->price); ?>₽</strong>
        </div>

        <div class="quick-product__badges">
            <?php if($product->age_group === 'puppy'): ?>
                <span>Щенкам</span>
            <?php elseif($product->age_group === 'junior'): ?>
                <span>Юниорам</span>
            <?php elseif($product->age_group === 'adult'): ?>
                <span>Взрослым</span>
            <?php endif; ?>

            <?php if($product->breed_size === 'small'): ?>
                <span>Маленькие породы</span>
            <?php elseif($product->breed_size === 'medium'): ?>
                <span>Средние породы</span>
            <?php elseif($product->breed_size === 'large'): ?>
                <span>Крупные породы</span>
            <?php elseif($product->breed_size === 'all'): ?>
                <span>Для всех пород</span>
            <?php endif; ?>
        </div>

        <a href="<?php echo e(route('product', $product->id)); ?>" class="quick-product__link">
            Перейти к товару
        </a>
    </div>
</div><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/partials/quick-product.blade.php ENDPATH**/ ?>