<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Sales Reports</h1>
        <p class="text-muted mb-0">Monitor sales performance for today, this month, and recent transactions.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6"><div class="seller-stat-card"><span class="seller-stat-label">Today's Sales</span><strong><?php echo formatPrice($todaySales['total'] ?? 0); ?></strong><small><?php echo (int)($todaySales['cnt'] ?? 0); ?> order(s)</small></div></div>
    <div class="col-md-6"><div class="seller-stat-card"><span class="seller-stat-label">Monthly Sales</span><strong><?php echo formatPrice($monthSales['total'] ?? 0); ?></strong><small><?php echo (int)($monthSales['cnt'] ?? 0); ?> order(s)</small></div></div>
</div>

<div class="row g-4">
    <div class="col-xl-5">
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Monthly Breakdown</h2></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Month</th><th>Orders</th><th class="text-end">Sales</th></tr></thead>
                    <tbody>
                        <?php if (!empty($monthlySales)): foreach ($monthlySales as $month): ?>
                            <tr><td><?php echo e($month['month_name']); ?></td><td><?php echo (int)$month['cnt']; ?></td><td class="text-end"><?php echo formatPrice($month['total']); ?></td></tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No sales data yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Recent Transactions</h2></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Order</th><th>Buyer</th><th>Method</th><th>Status</th><th class="text-end">Amount</th></tr></thead>
                    <tbody>
                        <?php if (!empty($transactions)): foreach ($transactions as $transaction): ?>
                            <tr>
                                <td>#<?php echo str_pad($transaction['order_id'], 5, '0', STR_PAD_LEFT); ?></td>
                                <td><div class="fw-semibold"><?php echo e($transaction['buyer_name']); ?></div><small class="text-muted"><?php echo e($transaction['buyer_email']); ?></small></td>
                                <td><?php echo e($transaction['payment_method']); ?></td>
                                <td><span class="badge text-bg-secondary"><?php echo ucfirst(e($transaction['status'])); ?></span></td>
                                <td class="text-end"><?php echo formatPrice($transaction['amount']); ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No transactions yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
