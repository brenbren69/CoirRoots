<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Inventory Report</h1>
        <p class="text-muted mb-0">Track stock levels, low-stock items, and estimated stock value.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4"><div class="seller-stat-card"><span class="seller-stat-label">Total Products</span><strong><?php echo (int)$totalProducts; ?></strong></div></div>
    <div class="col-md-4"><div class="seller-stat-card"><span class="seller-stat-label">Low Stock</span><strong><?php echo count($lowStock); ?></strong></div></div>
    <div class="col-md-4"><div class="seller-stat-card"><span class="seller-stat-label">Estimated Stock Value</span><strong><?php echo formatPrice($totalValue); ?></strong></div></div>
</div>

<div class="seller-panel">
    <div class="seller-panel-head"><h2 class="h5 mb-0">Inventory Summary</h2></div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th class="text-end">Stock Value</th></tr></thead>
            <tbody>
                <?php foreach ($inventory as $item): ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td><?php echo e($item['category_name'] ?? 'Uncategorized'); ?></td>
                        <td><?php echo formatPrice($item['price']); ?></td>
                        <td><span class="badge <?php echo $item['stock'] <= 0 ? 'text-bg-danger' : ($item['stock'] < 10 ? 'text-bg-warning' : 'text-bg-success'); ?>"><?php echo (int)$item['stock']; ?></span></td>
                        <td class="text-end"><?php echo formatPrice($item['stock_value']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
