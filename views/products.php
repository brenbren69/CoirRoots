<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">All Products</h2>
            <p class="text-muted small mb-0">
                <?php echo count($products); ?> product<?php echo count($products) != 1 ? 's' : ''; ?> found
            </p>
        </div>
        <a href="<?php echo APP_URL; ?>/index.php?page=storefront" class="btn btn-outline-coir btn-sm">
            <i class="bi bi-shop me-1"></i>View Storefront
        </a>
    </div>

    <!-- Filters Row -->
    <form method="GET" action="<?php echo APP_URL; ?>/index.php" class="mb-4" id="filterForm">
        <input type="hidden" name="page" value="products">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold small">Search Products</label>
                <div class="input-group">
                    <span class="input-group-text bg-light-coir">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control" name="search" id="searchInput"
                           placeholder="Search by name or description..."
                           value="<?php echo e($filters['search'] ?? ''); ?>">
                    <?php if (!empty($filters['search'])): ?>
                    <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Category</label>
                <select class="form-select" name="category_id" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"
                            <?php echo (($filters['category_id'] ?? 0) == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo e($cat['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Sort By</label>
                <select class="form-select" name="sort" onchange="this.form.submit()">
                    <option value="newest" <?php echo ($filters['sort'] ?? '') === 'newest' ? 'selected' : ''; ?>>Newest</option>
                    <option value="price_asc" <?php echo ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                    <option value="name" <?php echo ($filters['sort'] ?? '') === 'name' ? 'selected' : ''; ?>>Name A-Z</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-coir w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </div>
    </form>

    <!-- Active Filters -->
    <?php if (!empty($filters['search']) || !empty($filters['category_id'])): ?>
    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
        <span class="text-muted small">Active filters:</span>
        <?php if (!empty($filters['search'])): ?>
            <span class="badge bg-light-coir text-dark border">
                Search: "<?php echo e($filters['search']); ?>"
                <a href="<?php echo APP_URL; ?>/index.php?page=products&category_id=<?php echo $filters['category_id'] ?? ''; ?>&sort=<?php echo e($filters['sort']); ?>" class="ms-1 text-dark">×</a>
            </span>
        <?php endif; ?>
        <?php if (!empty($filters['category_id'])): ?>
            <?php $activeCat = array_values(array_filter($categories, fn($c) => $c['id'] == $filters['category_id'])); ?>
            <?php if (!empty($activeCat)): ?>
            <span class="badge bg-light-coir text-dark border">
                Category: <?php echo e($activeCat[0]['name']); ?>
                <a href="<?php echo APP_URL; ?>/index.php?page=products&search=<?php echo e($filters['search']); ?>&sort=<?php echo e($filters['sort']); ?>" class="ms-1 text-dark">×</a>
            </span>
            <?php endif; ?>
        <?php endif; ?>
        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-link btn-sm text-muted p-0">Clear all</a>
    </div>
    <?php endif; ?>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
    <div class="row g-4" id="productsGrid">
        <?php foreach ($products as $prod): ?>
        <div class="col-lg-4 col-md-6 product-grid-item"
             data-name="<?php echo strtolower(e($prod['name'])); ?>">
            <?php include __DIR__ . '/partials/product_card.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state text-center py-5">
        <div class="empty-icon mb-3">
            <i class="bi bi-search display-1 text-muted"></i>
        </div>
        <h4>No Products Found</h4>
        <p class="text-muted">
            <?php if (!empty($filters['search'])): ?>
                No products match "<?php echo e($filters['search']); ?>".
            <?php else: ?>
                No products available in this category.
            <?php endif; ?>
        </p>
        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-coir">
            <i class="bi bi-arrow-left me-2"></i>View All Products
        </a>
    </div>
    <?php endif; ?>
</div>
