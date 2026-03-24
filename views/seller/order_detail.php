<div class="seller-page-head mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></h1>
        <p class="text-muted mb-0">Review order items, buyer details, and update the status.</p>
    </div>
    <a href="<?php echo APP_URL; ?>/index.php?page=seller-dashboard" class="btn btn-outline-coir">Back to dashboard</a>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Items</h2></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Qty</th><th>Price</th><th class="text-end">Line Total</th></tr></thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td><?php echo e($item['product_name']); ?></td>
                                <td><?php echo (int)$item['quantity']; ?></td>
                                <td><?php echo formatPrice($item['price']); ?></td>
                                <td class="text-end"><?php echo formatPrice($item['quantity'] * $item['price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="seller-panel mb-4">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Order Summary</h2></div>
            <div class="d-grid gap-2 small">
                <div><strong>Buyer:</strong> <?php echo e($order['buyer_name']); ?></div>
                <div><strong>Email:</strong> <?php echo e($order['buyer_email']); ?></div>
                <div><strong>Total:</strong> <?php echo formatPrice($order['total_amount']); ?></div>
                <div><strong>Payment:</strong> <?php echo e($order['payment_method']); ?></div>
                <div><strong>Fulfillment:</strong> <?php echo e($order['fulfillment_method']); ?></div>
                <div><strong>Address:</strong> <?php echo e($order['delivery_address'] ?: 'N/A'); ?></div>
                <div><strong>Status:</strong> <?php echo ucfirst(e($order['status'])); ?></div>
            </div>
        </div>

        <div class="seller-panel mb-4">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Update Status</h2></div>
            <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-order-detail&id=<?php echo $order['id']; ?>" class="d-grid gap-3">
                <input type="hidden" name="action" value="update-status">
                <select name="status" class="form-select">
                    <?php foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $status): ?>
                        <option value="<?php echo $status; ?>" <?php echo $order['status'] === $status ? 'selected' : ''; ?>><?php echo ucfirst($status); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-coir">Save Status</button>
            </form>
        </div>

        <div class="seller-panel">
            <div class="seller-panel-head"><h2 class="h5 mb-0">Transactions</h2></div>
            <div class="d-grid gap-2">
                <?php if (!empty($transactions)): foreach ($transactions as $transaction): ?>
                    <div class="seller-mini-card"><strong><?php echo formatPrice($transaction['amount']); ?></strong><span><?php echo e($transaction['payment_method']); ?> / <?php echo ucfirst(e($transaction['status'])); ?></span></div>
                <?php endforeach; else: ?>
                    <div class="text-muted small">No transactions found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
