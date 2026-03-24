<!-- Breadcrumb -->
<div class="bg-light-coir py-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php?page=products">Products</a></li>
                <?php if (!empty($product['category_name'])): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo APP_URL; ?>/index.php?page=products&category_id=<?php echo $product['category_id']; ?>">
                        <?php echo e($product['category_name']); ?>
                    </a>
                </li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?php echo e($product['name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="product-detail-img-wrap rounded-4 overflow-hidden shadow-sm">
                <?php
                    $detailImgSrc = $product['image'] ?: 'https://placehold.co/600x400/5C3D1E/F5ECD7?text=Product';
                    if ($detailImgSrc && !str_starts_with($detailImgSrc, 'http') && !str_starts_with($detailImgSrc, '/')) {
                        $detailImgSrc = APP_URL . '/' . $detailImgSrc;
                    }
                ?>
                <img src="<?php echo e($detailImgSrc); ?>"
                     alt="<?php echo e($product['name']); ?>"
                     class="img-fluid w-100"
                     style="object-fit: cover; max-height: 480px;"
                     id="mainProductImage">
            </div>
            <div class="mt-3 d-flex gap-2">
                <div class="eco-badge-detail">
                    <i class="bi bi-leaf text-success me-1"></i>
                    <span class="small text-success fw-semibold">100% Natural</span>
                </div>
                <div class="eco-badge-detail">
                    <i class="bi bi-recycle text-success me-1"></i>
                    <span class="small text-success fw-semibold">Biodegradable</span>
                </div>
                <div class="eco-badge-detail">
                    <i class="bi bi-flag text-warning me-1"></i>
                    <span class="small text-warning fw-semibold">Philippine Made</span>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <?php if (!empty($product['category_name'])): ?>
            <span class="product-category mb-2"><?php echo e($product['category_name']); ?></span>
            <?php endif; ?>

            <h1 class="h2 fw-bold mt-2 mb-3"><?php echo e($product['name']); ?></h1>

            <!-- Badges -->
            <div class="mb-3 d-flex flex-wrap gap-2">
                <?php if ($product['is_new_arrival']): ?>
                    <span class="badge bg-success px-3 py-2">New Arrival</span>
                <?php endif; ?>
                <?php if ($product['is_trending']): ?>
                    <span class="badge bg-warning text-dark px-3 py-2">Trending</span>
                <?php endif; ?>
                <?php if ($product['is_best_seller']): ?>
                    <span class="badge bg-danger px-3 py-2">Best Seller</span>
                <?php endif; ?>
            </div>

            <!-- Price -->
            <div class="product-detail-price mb-3">
                <?php echo formatPrice($product['price']); ?>
            </div>

            <!-- Stock Status -->
            <div class="mb-4">
                <?php if ($product['stock'] > 10): ?>
                    <span class="stock-badge in-stock">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        In Stock (<?php echo $product['stock']; ?> available)
                    </span>
                <?php elseif ($product['stock'] > 0): ?>
                    <span class="stock-badge low-stock">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Low Stock — Only <?php echo $product['stock']; ?> left!
                    </span>
                <?php else: ?>
                    <span class="stock-badge out-of-stock">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        Out of Stock
                    </span>
                <?php endif; ?>
            </div>

            <!-- Short Description -->
            <?php if (!empty($product['short_description'])): ?>
            <p class="text-muted mb-4"><?php echo e($product['short_description']); ?></p>
            <?php endif; ?>

            <!-- Add to Cart -->
            <?php if ($product['stock'] > 0): ?>
            <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=cart-add" class="mb-4">
                <input type="hidden" name="action" value="cart-add">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="d-flex gap-3 align-items-end flex-wrap">
                    <div>
                        <label class="form-label fw-semibold small">Quantity</label>
                        <div class="qty-control d-flex align-items-center">
                            <button type="button" class="btn btn-outline-secondary qty-btn" id="qtyMinus">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" class="form-control qty-input text-center" id="qtyInput"
                                   name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>"
                                   style="width: 60px;">
                            <button type="button" class="btn btn-outline-secondary qty-btn" id="qtyPlus"
                                    data-max="<?php echo $product['stock']; ?>">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-coir btn-lg px-4 flex-grow-1">
                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                    </button>
                </div>
            </form>
            <?php else: ?>
            <div class="alert alert-secondary">
                <i class="bi bi-bell me-2"></i>
                This product is currently unavailable. Check back soon!
            </div>
            <?php endif; ?>

            <!-- Buy now / continue shopping -->
            <div class="d-flex gap-3 flex-wrap">
                <a href="<?php echo APP_URL; ?>/index.php?page=cart" class="btn btn-outline-coir">
                    <i class="bi bi-cart3 me-2"></i>View Cart
                </a>
                <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-link text-muted">
                    <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                </a>
            </div>

            <!-- Details -->
            <div class="mt-4 p-3 rounded-3 bg-light-coir">
                <div class="row g-2 small">
                    <div class="col-6">
                        <span class="text-muted">Category:</span>
                        <span class="fw-semibold ms-1"><?php echo e($product['category_name'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">SKU:</span>
                        <span class="fw-semibold ms-1">CR-<?php echo str_pad($product['id'], 4, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Description -->
    <?php if (!empty($product['description'])): ?>
    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#descTab">
                    Product Description
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shippingTab">
                    Shipping &amp; Delivery
                </button>
            </li>
        </ul>
        <div class="tab-content border border-top-0 rounded-bottom p-4">
            <div class="tab-pane fade show active" id="descTab">
                <div class="text-muted" style="line-height: 1.8;">
                    <?php echo nl2br(e($product['description'])); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="shippingTab">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="bi bi-truck fs-2 text-success mb-2 d-block"></i>
                            <h6 class="fw-bold">Nationwide Delivery</h6>
                            <p class="text-muted small">We ship to all provinces in the Philippines via LBC, J&T, or Ninja Van.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="bi bi-clock fs-2 text-warning mb-2 d-block"></i>
                            <h6 class="fw-bold">Processing Time</h6>
                            <p class="text-muted small">Orders are processed within 1-2 business days after payment confirmation.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="bi bi-currency-dollar fs-2 text-primary mb-2 d-block"></i>
                            <h6 class="fw-bold">Free Shipping</h6>
                            <p class="text-muted small">Enjoy free shipping on orders over <?php echo formatPrice(FREE_SHIPPING_THRESHOLD); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-5">
        <div class="section-header mb-4">
            <span class="section-tag">More from this Category</span>
            <h3 class="section-title">Related Products</h3>
        </div>
        <div class="row g-4">
            <?php foreach ($relatedProducts as $prod): ?>
            <div class="col-md-6 col-lg-3">
                <?php include __DIR__ . '/partials/product_card.php'; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
const qtyInput = document.getElementById('qtyInput');
const qtyMinus = document.getElementById('qtyMinus');
const qtyPlus  = document.getElementById('qtyPlus');
const maxStock = parseInt(qtyPlus?.dataset.max || '99');

qtyMinus?.addEventListener('click', function() {
    const val = parseInt(qtyInput.value) || 1;
    if (val > 1) qtyInput.value = val - 1;
});
qtyPlus?.addEventListener('click', function() {
    const val = parseInt(qtyInput.value) || 1;
    if (val < maxStock) qtyInput.value = val + 1;
});
</script>
