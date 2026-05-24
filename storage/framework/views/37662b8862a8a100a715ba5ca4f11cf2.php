


<?php $__env->startSection('title', 'Каталог товаров — Мокронос'); ?>

<?php $__env->startSection('description', 'Каталог товаров для животных в интернет-магазине Мокронос.'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="section-title">Каталог лакомств</h2>
        <div class="catalog-filters">
            <div class="catalog-main-categories">
                <a href="<?php echo e(route('catalog')); ?>"
                class="catalog-filter-main <?php echo e(request('category') ? '' : 'is-active'); ?>">
                    Все товары
                </a>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('catalog', ['category' => $category->id])); ?>"
                    class="catalog-filter-main <?php echo e(request('category') == $category->id ? 'is-active' : ''); ?>">
                        <?php echo e($category->title); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(
                    request('category') == $category->id ||
                    $category->children->pluck('id')->contains((int) request('category'))
                ): ?>
                    <?php if($category->children->isNotEmpty()): ?>
                        <div class="catalog-subcategory-row">
                            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('catalog', ['category' => $child->id])); ?>"
                                class="catalog-filter-child <?php echo e(request('category') == $child->id ? 'is-active' : ''); ?>">
                                    <?php echo e($child->title); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="catalog-grid">
              <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="product-card" >
                <div class="product-image">
                    <?php
                        $preview = $product->images->where('is_preview', true)->first()
                            ?? $product->images->first();
                    ?>

                    <img
                        src="<?php echo e($preview
                            ? asset('storage/' . $preview->image)
                            : asset('assets/img/no-image.png')); ?>"
                        alt="<?php echo e($product->title); ?>"
                    >
                </div>

                <div class="product-info">
                    <a href="<?php echo e(route('product', $product->id)); ?>" class="product-title"><?php echo e($product->title); ?></a>
                    <p class="product-desc">
                        <?php echo e($product->description); ?>

                    </p>
                    <div class="product-rating">
                    <span class="rating_text">⭐<?php echo e($product->rating); ?></span>
                    </div>
                    <div class="product-meta">
                        <span class="product-weight"><?php echo e($product->weight); ?></span>
                        <span class="product-price"><?php echo e($product->price); ?>₽</span>
                    </div>

                    <div class="product-actions"  data-id="<?php echo e($product->id); ?>">
                        
                         <form>
                        <?php echo csrf_field(); ?>

                        <?php 
                            $cartQty = $cartQuantities[$product->id] ?? 0;
                        ?>

                        <div
                            class="product-cart-control"
                            data-product="<?php echo e($product->id); ?>"
                        >
                            <button
                                type="button"
                                class="btn product-btn add-to-cart"
                                data-id="<?php echo e($product->id); ?>"
                                style="<?php echo e($cartQty > 0 ? 'display:none;' : ''); ?>"
                            >
                                В корзину
                            </button>

                            <div class="cart-qty-control <?php echo e($cartQty > 0 ? '' : 'hidden'); ?>">
                                
                                <button type="button" class="qty-btn qty-minus">
                                    −
                                </button>

                                <span class="qty-value">
                                    <?php echo e($cartQty > 0 ? $cartQty : 1); ?>

                                </span>

                                <button type="button" class="qty-btn qty-plus">
                                    +
                                </button>

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
            
            

        </div>
        <div class="custom-pagination">
    <?php if($products->onFirstPage()): ?>
        <span class="disabled">«</span>
    <?php else: ?>
        <a href="<?php echo e($products->previousPageUrl()); ?>">«</a>
    <?php endif; ?>

    <?php $__currentLoopData = $products->getUrlRange(1, $products->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($page == $products->currentPage()): ?>
            <span class="active"><?php echo e($page); ?></span>
        <?php else: ?>
            <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($products->hasMorePages()): ?>
        <a href="<?php echo e($products->nextPageUrl()); ?>">»</a>
    <?php else: ?>
        <span class="disabled">»</span>
    <?php endif; ?>
</div>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/catalog/index.blade.php ENDPATH**/ ?>