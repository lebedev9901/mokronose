<div class="favorites-page">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">❤️ Избранное</h1>
            <p>Товары, которые вы сохранили</p>
        </div>
    </div>

    <?php if($products->count()): ?>

        <div class="favorites-grid">

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                ?>

                <div class="favorite-product-card">

                    <a href="<?php echo e(route('product', $product->id)); ?>" class="favorite-product-card__image">
                        <img
                            src="<?php echo e($preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png')); ?>"
                            alt="<?php echo e($product->title); ?>"
                        >
                    </a>

                    <div class="favorite-product-card__body">
                        <h3>
                            <a href="<?php echo e(route('product', $product->id)); ?>">
                                <?php echo e($product->title); ?>

                            </a>
                        </h3>

                        <div class="favorite-product-card__price">
                            <?php echo e(number_format($product->price, 0, '.', ' ')); ?> ₽
                        </div>

                        <div class="favorite-product-card__actions">
                            <button
                                class="btn-secondary favorite-toggle"
                                type="button"
                                data-product-id="<?php echo e($product->id); ?>"
                            >
                                Убрать
                            </button>

                            <a href="<?php echo e(route('product', $product->id)); ?>" class="btn-primary">
                                Смотреть
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php else: ?>

        <div class="empty-block">
            <h3>❤️ В избранном пока пусто</h3>
            <p>Добавляйте товары в избранное, чтобы быстро вернуться к ним позже.</p>

            <a href="<?php echo e(route('catalog')); ?>" class="btn-primary">
                Перейти в каталог
            </a>
        </div>

    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-toggle').forEach(button => {
        button.addEventListener('click', async function () {
            const productId = this.dataset.productId;
            const card = this.closest('.favorite-product-card');

            const res = await fetch(`/favorites/${productId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (data.success) {
                card.remove();
            }
        });
    });
});
</script><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/favorites.blade.php ENDPATH**/ ?>