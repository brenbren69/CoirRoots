<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-cart3 me-2"></i>My Cart
    </h2>

    <?php if (!empty($cartItems)): ?>
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="cartTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-3">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                <tr class="cart-row" data-price="<?php echo $item['price']; ?>">
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($item['slug']); ?>">
                                                <img src="<?php echo e($item['image'] ?: 'https://placehold.co/80x80/5C3D1E/F5ECD7?text=Product'); ?>"
                                                     alt="<?php echo e($item['name']); ?>"
                                                     width="70" height="70"
                                                     class="rounded-3 object-fit-cover">
                                            </a>
                                            <div>
                                                <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($item['slug']); ?>"
                                                   class="fw-semibold text-dark text-decoration-none">
                                                    <?php echo e($item['name']); ?>
                                                </a>
                                                <?php if ($item['stock'] < 10): ?>
                                                <div class="text-warning small">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                    Only <?php echo $item['stock']; ?> in stock
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted small">
                                        <?php echo formatPrice($item['price']); ?>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=cart-update"
                                              class="qty-update-form d-inline-flex align-items-center gap-1">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="button" class="btn btn-sm btn-outline-secondary qty-cart-minus"
                                                    data-min="1">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" class="form-control form-control-sm qty-cart-input text-center"
                                                   name="quantity" value="<?php echo $item['quantity']; ?>"
                                                   min="1" max="<?php echo $item['stock']; ?>"
                                                   style="width:55px;">
                                            <button type="button" class="btn btn-sm btn-outline-secondary qty-cart-plus"
                                                    data-max="<?php echo $item['stock']; ?>">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-outline-coir ms-1">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center fw-semibold cart-subtotal">
                                        <?php echo formatPrice($item['price'] * $item['quantity']); ?>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=cart-remove"
                                              class="cart-remove-form">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Remove item"
                                                    onclick="return confirm('Remove this item from cart?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Continue Shopping -->
            <div class="mt-3">
                <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold" id="summarySubtotal"><?php echo formatPrice($subtotal); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Shipping</span>
                        <span class="<?php echo $shipping == 0 ? 'text-success fw-semibold' : 'fw-semibold'; ?>">
                            <?php echo $shipping == 0 ? 'FREE' : formatPrice($shipping); ?>
                        </span>
                    </div>
                    <?php if ($shipping > 0): ?>
                    <div class="alert alert-info py-2 small">
                        <i class="bi bi-info-circle me-1"></i>
                        Add <?php echo formatPrice(FREE_SHIPPING_THRESHOLD - $subtotal); ?> more for free shipping!
                    </div>
                    <?php else: ?>
                    <div class="alert alert-success py-2 small">
                        <i class="bi bi-check-circle me-1"></i>
                        You qualify for free shipping!
                    </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-coir" id="summaryTotal"><?php echo formatPrice($total); ?></span>
                    </div>
                    <a href="<?php echo APP_URL; ?>/index.php?page=checkout"
                       class="btn btn-coir btn-lg w-100 fw-semibold">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </a>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1 text-success"></i>
                            Secure checkout — your data is protected
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- Empty Cart -->
    <div class="empty-state text-center py-5">
        <div class="mb-4">
            <i class="bi bi-cart-x display-1 text-muted"></i>
        </div>
        <h3>Your cart is empty</h3>
        <p class="text-muted mb-4">
            Looks like you haven't added any products yet.
            Browse our collection of natural coir products!
        </p>
        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-coir btn-lg px-5">
            <i class="bi bi-bag-plus me-2"></i>Start Shopping
        </a>
        <div class="mt-3">
            <a href="<?php echo APP_URL; ?>/index.php?page=storefront" class="text-muted small">
                Or browse our featured shop
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
