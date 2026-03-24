<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Inventory</h1>
        <p class="text-muted mb-0">Add, update, and remove products from the catalog.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Add Product</h2></div>
            <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-add-product" class="d-grid gap-3">
                <input type="hidden" name="action" value="add-product">
                <input type="text" name="name" class="form-control" placeholder="Product name" required>
                <input type="text" name="short_description" class="form-control" placeholder="Short description">
                <textarea name="description" class="form-control" rows="4" placeholder="Full description"></textarea>
                <div class="row g-3">
                    <div class="col-md-6"><input type="number" step="0.01" min="0.01" name="price" class="form-control" placeholder="Price" required></div>
                    <div class="col-md-6"><input type="number" min="0" name="stock" class="form-control" placeholder="Stock" required></div>
                </div>
                <select name="category_id" class="form-select">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?><option value="<?php echo $category['id']; ?>"><?php echo e($category['name']); ?></option><?php endforeach; ?>
                </select>
                <input type="url" name="image" class="form-control" placeholder="Image URL">
                <div class="row g-2 small">
                    <div class="col-6"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_featured"> <span class="form-check-label">Featured</span></label></div>
                    <div class="col-6"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_new_arrival"> <span class="form-check-label">New arrival</span></label></div>
                    <div class="col-6"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_trending"> <span class="form-check-label">Trending</span></label></div>
                    <div class="col-6"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_best_seller"> <span class="form-check-label">Best seller</span></label></div>
                </div>
                <button type="submit" class="btn btn-coir">Add Product</button>
            </form>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Product List</h2><span class="text-muted small"><?php echo count($products); ?> item(s)</span></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Flags</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><div class="fw-semibold"><?php echo e($product['name']); ?></div><small class="text-muted"><?php echo e($product['slug']); ?></small></td>
                                <td><?php echo e($product['category_name'] ?? 'Uncategorized'); ?></td>
                                <td><?php echo formatPrice($product['price']); ?></td>
                                <td><?php echo (int)$product['stock']; ?></td>
                                <td><div class="d-flex flex-wrap gap-1"><?php if ($product['is_featured']): ?><span class="badge text-bg-dark">Featured</span><?php endif; ?><?php if ($product['is_new_arrival']): ?><span class="badge text-bg-success">New</span><?php endif; ?><?php if ($product['is_trending']): ?><span class="badge text-bg-warning">Trending</span><?php endif; ?><?php if ($product['is_best_seller']): ?><span class="badge text-bg-danger">Best</span><?php endif; ?></div></td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?php echo APP_URL; ?>/index.php?page=seller-edit-product&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-coir">Edit</a>
                                        <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-delete-product" onsubmit="return confirm('Delete this product?');">
                                            <input type="hidden" name="action" value="delete-product">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
