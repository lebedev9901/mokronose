<?php if($products->lastPage() > 1): ?>
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
<?php endif; ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/partials/pagination.blade.php ENDPATH**/ ?>