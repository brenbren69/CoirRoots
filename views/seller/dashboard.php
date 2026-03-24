<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Dashboard</h1>
        <p class="text-muted mb-0">A quick overview of sales, orders, and stock health.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3"><div class="seller-stat-card"><span class="seller-stat-label">Today's Sales</span><strong><?php echo formatPrice($todaySales['total'] ?? 0); ?></strong><small><?php echo (int)($todaySales['cnt'] ?? 0); ?> order(s) today</small></div></div>
    <div class="col-md-6 col-xl-3"><div class="seller-stat-card"><span class="seller-stat-label">Monthly Sales</span><strong><?php echo formatPrice($monthSales['total'] ?? 0); ?></strong><small><?php echo (int)($monthSales['cnt'] ?? 0); ?> order(s) this month</small></div></div>
    <div class="col-md-6 col-xl-3"><div class="seller-stat-card"><span class="seller-stat-label">Products</span><strong><?php echo (int)$totalProducts; ?></strong><small><?php echo count($outOfStock); ?> out of stock</small></div></div>
    <div class="col-md-6 col-xl-3"><div class="seller-stat-card"><span class="seller-stat-label">Orders</span><strong><?php echo (int)$totalOrders; ?></strong><small><?php echo count($lowStock); ?> low-stock products</small></div></div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="seller-panel">
            <div class="seller-panel-head">
                <h2 class="h5 mb-0">Recent Orders</h2>
                <a href="<?php echo APP_URL; ?>/index.php?page=seller-reports" class="section-link">View reports</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Order</th><th>Buyer</th><th>Items</th><th>Total</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($recentOrders)): foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                <td><div class="fw-semibold"><?php echo e($order['buyer_name']); ?></div><small class="text-muted"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></small></td>
                                <td><?php echo (int)$order['item_count']; ?></td>
                                <td><?php echo formatPrice($order['total_amount']); ?></td>
                                <td><span class="badge text-bg-secondary"><?php echo ucfirst(e($order['status'])); ?></span></td>
                                <td class="text-end"><a href="<?php echo APP_URL; ?>/index.php?page=seller-order-detail&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-coir">View</a></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">No orders yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="seller-panel mb-4">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Inventory Alerts</h2></div>
            <div class="d-grid gap-3">
                <div class="seller-mini-card"><strong><?php echo count($lowStock); ?></strong><span>Low-stock items</span></div>
                <div class="seller-mini-card danger"><strong><?php echo count($outOfStock); ?></strong><span>Out-of-stock items</span></div>
            </div>
        </div>
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Quick Actions</h2></div>
            <div class="d-grid gap-2">
                <a class="btn btn-coir" href="<?php echo APP_URL; ?>/index.php?page=seller-inventory">Manage Inventory</a>
                <a class="btn btn-outline-coir" href="<?php echo APP_URL; ?>/index.php?page=seller-storefront">Modify Storefront</a>
                <a class="btn btn-outline-coir" href="<?php echo APP_URL; ?>/index.php?page=seller-inventory-report">Inventory Report</a>
            </div>
        </div>
    </div>
</div>
