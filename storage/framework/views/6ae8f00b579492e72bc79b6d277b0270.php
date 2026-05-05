

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="product-page">
        <div class="product-page__grid">
            <div class="product-gallery">
                <?php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preview): ?>
                    <img src="<?php echo e(asset('storage/' . $preview->image)); ?>" class="product-main-img">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="product-info">

                <h1 class="product-title"><?php echo e($product->title); ?></h1>

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
                    <div>❤️ Подходит для всех пород</div>
                </div>
            </div>
        </div>
        <div class="product-reviews">

            <h2 class="section-title">Отзывы о товаре</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->reviews->count()): ?>
                <div class="reviews-grid">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="review-card">

                            <div class="review-rating">
                                ⭐ <?php echo e($review->rating); ?>

                            </div>

                            <p class="review-text">
                                <?php echo e($review->text); ?>

                            </p>

                            <div class="review-author">
                                <div class="review-avatar">
                                    <?php echo e(mb_substr($review->user_name, 0, 1)); ?>

                                </div>

                                <div>
                                    <div class="review-name">
                                        <?php echo e($review->user_name); ?>

                                    </div>
                                    <div class="review-date">
                                        <?php echo e($review->created_at->format('d.m.Y')); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </div>
            <?php else: ?>
                <p class="no-reviews">Пока нет отзывов. Будьте первым!</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/product/show.blade.php ENDPATH**/ ?>