<?php // Expects $prod variable to be set ?>
<div class="product-card h-100">
    <div class="product-img-wrap">
        <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($prod['slug']); ?>">
            <?php
                $imgSrc = $prod['image'] ?: 'https://placehold.co/600x400/5C3D1E/F5ECD7?text=Product';
                if ($imgSrc && !str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/')) {
                    $imgSrc = APP_URL . '/' . $imgSrc;
                }
            ?>
            <img src="<?php echo e($imgSrc); ?>"
                 alt="<?php echo e($prod['name']); ?>"
                 class="product-img" loading="lazy">
        </a>
        <div class="product-badges">
            <?php if ($prod['is_new_arrival']): ?>
                <span class="badge bg-success">New</span>
            <?php endif; ?>
            <?php if ($prod['is_trending']): ?>
                <span class="badge bg-warning text-dark">Trending</span>
            <?php endif; ?>
            <?php if ($prod['is_best_seller']): ?>
                <span class="badge bg-danger">Best Seller</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="product-body p-3">
        <?php if (!empty($prod['category_name'])): ?>
            <span class="product-category"><?php echo e($prod['category_name']); ?></span>
        <?php endif; ?>
        <h6 class="product-name mt-1">
            <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($prod['slug']); ?>">
                <?php echo e($prod['name']); ?>
            </a>
        </h6>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <span class="product-price"><?php echo formatPrice($prod['price']); ?></span>
            <?php if ($prod['stock'] > 10): ?>
                <span class="badge bg-success-subtle text-success small">In Stock</span>
            <?php elseif ($prod['stock'] > 0): ?>
                <span class="badge bg-warning-subtle text-warning small">Low Stock</span>
            <?php else: ?>
                <span class="badge bg-danger-subtle text-danger small">Out of Stock</span>
            <?php endif; ?>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($prod['slug']); ?>"
               class="btn btn-outline-coir btn-sm flex-grow-1">View</a>
            <?php if ($prod['stock'] > 0): ?>
            <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=cart-add" class="flex-grow-1">
                <input type="hidden" name="action" value="cart-add">
                <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-coir btn-sm w-100">
                    <i class="bi bi-cart-plus"></i>
                    <span class="d-none d-sm-inline ms-1">Add</span>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
