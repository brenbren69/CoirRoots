<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-bag-check me-2"></i>My Orders
        </h2>
        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-outline-coir btn-sm">
            <i class="bi bi-bag-plus me-1"></i>Continue Shopping
        </a>
    </div>

    <?php if (!empty($orders)): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="d-none d-md-block table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Order #</th>
                            <th>Date</th>
                            <th class="text-center">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Payment</th>
                            <th class="text-center">Delivery</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="ps-4 fw-semibold">#<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></td>
                            <td class="text-muted small">
                                <?php echo date('M d, Y', strtotime($order['created_at'])); ?><br>
                                <span style="font-size:0.7rem;"><?php echo date('h:i A', strtotime($order['created_at'])); ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary"><?php echo $order['item_count']; ?> item<?php echo $order['item_count'] != 1 ? 's' : ''; ?></span>
                            </td>
                            <td class="text-end fw-semibold"><?php echo formatPrice($order['total_amount']); ?></td>
                            <td class="text-center">
                                <?php
                                $pmLabels = ['cod' => 'COD', 'gcash' => 'GCash', 'bank_transfer' => 'Bank'];
                                $pmBadge  = ['cod' => 'bg-warning text-dark', 'gcash' => 'bg-primary', 'bank_transfer' => 'bg-info text-dark'];
                                $pm = $order['payment_method'];
                                ?>
                                <span class="badge <?php echo $pmBadge[$pm] ?? 'bg-secondary'; ?>">
                                    <?php echo $pmLabels[$pm] ?? $pm; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php
                                $fmLabels = ['pickup' => 'Pickup', 'delivery' => 'Delivery'];
                                $fm = $order['fulfillment_method'];
                                ?>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi <?php echo $fm === 'pickup' ? 'bi-shop' : 'bi-truck'; ?> me-1"></i>
                                    <?php echo $fmLabels[$fm] ?? $fm; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php
                                $statusBadge = [
                                    'pending'    => 'bg-warning text-dark',
                                    'confirmed'  => 'bg-info text-dark',
                                    'processing' => 'bg-primary',
                                    'shipped'    => 'bg-info',
                                    'delivered'  => 'bg-success',
                                    'cancelled'  => 'bg-danger',
                                ];
                                $st = $order['status'];
                                ?>
                                <span class="badge <?php echo $statusBadge[$st] ?? 'bg-secondary'; ?> px-2 py-1">
                                    <?php echo ucfirst($st); ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?php echo APP_URL; ?>/index.php?page=order-detail&id=<?php echo $order['id']; ?>"
                                   class="btn btn-sm btn-outline-coir">
                                    View <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                <?php foreach ($orders as $order):
                    $st = $order['status'];
                    $statusBadge = [
                        'pending'    => 'bg-warning text-dark',
                        'confirmed'  => 'bg-info text-dark',
                        'processing' => 'bg-primary',
                        'shipped'    => 'bg-info',
                        'delivered'  => 'bg-success',
                        'cancelled'  => 'bg-danger',
                    ];
                ?>
                <div class="border-bottom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-bold">#<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></span>
                        <span class="badge <?php echo $statusBadge[$st] ?? 'bg-secondary'; ?>">
                            <?php echo ucfirst($st); ?>
                        </span>
                    </div>
                    <div class="text-muted small mb-1">
                        <?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-semibold"><?php echo formatPrice($order['total_amount']); ?></span>
                        <a href="<?php echo APP_URL; ?>/index.php?page=order-detail&id=<?php echo $order['id']; ?>"
                           class="btn btn-sm btn-outline-coir">View Details</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-bag display-1 text-muted mb-3 d-block"></i>
        <h3>No orders yet</h3>
        <p class="text-muted mb-4">You haven't placed any orders. Start shopping for our natural coir products!</p>
        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-coir btn-lg px-5">
            <i class="bi bi-bag-plus me-2"></i>Start Shopping
        </a>
    </div>
    <?php endif; ?>
</div>
