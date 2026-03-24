<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Edit Product</h1>
        <p class="text-muted mb-0">Update product details, pricing, and storefront flags.</p>
    </div>
    <a href="<?php echo APP_URL; ?>/index.php?page=seller-inventory" class="btn btn-outline-coir">Back to inventory</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?><div><?php echo e($error); ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="seller-panel">
    <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-edit-product&id=<?php echo $product['id']; ?>" class="d-grid gap-3">
        <input type="hidden" name="action" value="edit-product">
        <div class="row g-3">
            <div class="col-lg-6">
                <label class="form-label fw-semibold">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo e($product['name']); ?>" required>
            </div>
            <div class="col-lg-6">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo e($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label class="form-label fw-semibold">Price</label>
                <input type="number" step="0.01" min="0.01" name="price" class="form-control" value="<?php echo e($product['price']); ?>" required>
            </div>
            <div class="col-lg-6">
                <label class="form-label fw-semibold">Stock</label>
                <input type="number" min="0" name="stock" class="form-control" value="<?php echo e($product['stock']); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Short Description</label>
                <input type="text" name="short_description" class="form-control" value="<?php echo e($product['short_description']); ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Image URL</label>
                <input type="url" name="image" class="form-control" value="<?php echo e($product['image']); ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="5" class="form-control"><?php echo e($product['description']); ?></textarea>
            </div>
        </div>

        <div class="row g-2 small">
            <div class="col-md-3"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" <?php echo !empty($product['is_featured']) ? 'checked' : ''; ?>> <span class="form-check-label">Featured</span></label></div>
            <div class="col-md-3"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_new_arrival" <?php echo !empty($product['is_new_arrival']) ? 'checked' : ''; ?>> <span class="form-check-label">New arrival</span></label></div>
            <div class="col-md-3"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_trending" <?php echo !empty($product['is_trending']) ? 'checked' : ''; ?>> <span class="form-check-label">Trending</span></label></div>
            <div class="col-md-3"><label class="form-check"><input class="form-check-input" type="checkbox" name="is_best_seller" <?php echo !empty($product['is_best_seller']) ? 'checked' : ''; ?>> <span class="form-check-label">Best seller</span></label></div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-coir">Save Changes</button>
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-inventory" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
