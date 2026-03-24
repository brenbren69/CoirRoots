<?php $labels = ['new_arrivals' => 'New Arrivals', 'trending' => 'Trending Products', 'best_sellers' => 'Best Sellers']; ?>
<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Storefront Management</h1>
        <p class="text-muted mb-0">Choose which products appear in each curated storefront section.</p>
    </div>
</div>

<div class="row g-4">
    <?php foreach ($labels as $key => $label): ?>
        <?php $selected = !empty($sectionMap[$key]['product_ids']) ? (json_decode($sectionMap[$key]['product_ids'], true) ?: []) : []; ?>
        <div class="col-xl-4">
            <div class="seller-panel h-100">
                <div class="seller-panel-head"><h2 class="h5 mb-0"><?php echo e($label); ?></h2></div>
                <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-storefront" class="d-grid gap-3">
                    <input type="hidden" name="section" value="<?php echo e($key); ?>">
                    <div>
                        <label class="form-label fw-semibold">Banner Text</label>
                        <textarea name="banner_text" rows="3" class="form-control"><?php echo e($sectionMap[$key]['banner_text'] ?? ''); ?></textarea>
                    </div>
                    <div class="seller-checklist">
                        <?php foreach ($allProducts as $product): ?>
                            <label class="seller-check-item">
                                <input type="checkbox" name="product_ids[]" value="<?php echo $product['id']; ?>" <?php echo in_array((int)$product['id'], array_map('intval', $selected), true) ? 'checked' : ''; ?>>
                                <span><strong><?php echo e($product['name']); ?></strong><small><?php echo formatPrice($product['price']); ?></small></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-coir">Save Section</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
