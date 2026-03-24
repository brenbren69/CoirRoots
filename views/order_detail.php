<div class="container py-4">
    <!-- Back link -->
    <div class="mb-4">
        <a href="<?php echo APP_URL; ?>/index.php?page=orders" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <!-- Order Header -->
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
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-1">
                        Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?>
                    </h3>
                    <p class="text-muted small mb-0">
                        Placed on <?php echo date('F d, Y \a\t h:i A', strtotime($order['created_at'])); ?>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="badge <?php echo $statusBadge[$st] ?? 'bg-secondary'; ?> fs-6 px-3 py-2">
                        <?php echo ucfirst($st); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Items + Timeline -->
        <div class="col-lg-8">

            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-bag me-2"></i>Order Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($item['image'])): ?>
                                            <img src="<?php echo e($item['image']); ?>"
                                                 alt="<?php echo e($item['product_name']); ?>"
                                                 width="50" height="50"
                                                 class="rounded-2 object-fit-cover">
                                            <?php endif; ?>
                                            <span class="fw-semibold"><?php echo e($item['product_name']); ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted"><?php echo formatPrice($item['price']); ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-end pe-4 fw-semibold">
                                        <?php echo formatPrice($item['price'] * $item['quantity']); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2"></i>Order Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                    $statusIdx = array_search($st, $statuses);
                    $statusIcons = [
                        'pending'    => 'bi-clock',
                        'confirmed'  => 'bi-check-circle',
                        'processing' => 'bi-gear',
                        'shipped'    => 'bi-truck',
                        'delivered'  => 'bi-house-check',
                    ];
                    $statusLabels = [
                        'pending'    => ['Order Placed', 'We received your order'],
                        'confirmed'  => ['Order Confirmed', 'Your order has been confirmed'],
                        'processing' => ['Processing', 'Preparing your items for shipment'],
                        'shipped'    => ['Shipped', 'Your package is on its way'],
                        'delivered'  => ['Delivered', 'Package delivered successfully'],
                    ];
                    ?>
                    <?php if ($st !== 'cancelled'): ?>
                    <div class="order-timeline">
                        <?php foreach ($statuses as $i => $timelineStatus): ?>
                        <?php $isActive = $i <= $statusIdx; ?>
                        <div class="timeline-item d-flex gap-3 mb-3 <?php echo $isActive ? '' : 'opacity-40'; ?>">
                            <div class="timeline-icon flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center
                                     <?php echo $isActive ? 'bg-success' : 'bg-light border'; ?>"
                                     style="width:36px;height:36px;">
                                    <i class="bi <?php echo $statusIcons[$timelineStatus]; ?>
                                       <?php echo $isActive ? 'text-white' : 'text-muted'; ?> small"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 pb-3 <?php echo $i < count($statuses)-1 ? 'border-start ms-1 ps-3' : ''; ?>"
                                 style="<?php echo $i < count($statuses)-1 ? 'margin-left:-19px; padding-left: calc(1rem + 19px)!important;' : ''; ?>">
                                <div class="fw-semibold small"><?php echo $statusLabels[$timelineStatus][0]; ?></div>
                                <div class="text-muted" style="font-size:0.8rem;"><?php echo $statusLabels[$timelineStatus][1]; ?></div>
                                <?php if ($timelineStatus === $st): ?>
                                <div class="text-success" style="font-size:0.75rem;">
                                    <i class="bi bi-check-circle-fill me-1"></i>Current status
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-3">
                        <i class="bi bi-x-circle-fill text-danger fs-1 mb-2 d-block"></i>
                        <h5 class="text-danger">Order Cancelled</h5>
                        <p class="text-muted">This order was cancelled.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div class="col-lg-4">

            <!-- Price Breakdown -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span><?php echo formatPrice($order['subtotal']); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span><?php echo $order['shipping_fee'] == 0 ? 'FREE' : formatPrice($order['shipping_fee']); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-coir fs-5"><?php echo formatPrice($order['total_amount']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Payment Method</div>
                        <?php
                        $pmLabels = ['cod' => 'Cash on Delivery', 'gcash' => 'GCash', 'bank_transfer' => 'Bank Transfer'];
                        $pm = $order['payment_method'];
                        ?>
                        <div class="fw-semibold"><?php echo $pmLabels[$pm] ?? ucfirst($pm); ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Fulfillment</div>
                        <div class="fw-semibold">
                            <?php echo $order['fulfillment_method'] === 'pickup' ? 'Pickup at Warehouse' : 'Home Delivery'; ?>
                        </div>
                    </div>
                    <?php if (!empty($order['delivery_address']) && $order['fulfillment_method'] === 'delivery'): ?>
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Delivery Address</div>
                        <div class="fw-semibold small"><?php echo nl2br(e($order['delivery_address'])); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($order['notes'])): ?>
                    <div>
                        <div class="text-muted small mb-1">Order Notes</div>
                        <div class="small"><?php echo nl2br(e($order['notes'])); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Transaction -->
            <?php if (!empty($transactions)): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light-coir border-0 py-3">
                    <h5 class="fw-bold mb-0">Transaction</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($transactions as $tx): ?>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="text-muted">Transaction ID</span>
                        <span class="fw-semibold">#<?php echo str_pad($tx['id'], 6, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="text-muted">Status</span>
                        <?php
                        $txBadge = ['pending'=>'bg-warning text-dark','completed'=>'bg-success','failed'=>'bg-danger','refunded'=>'bg-info'];
                        ?>
                        <span class="badge <?php echo $txBadge[$tx['status']] ?? 'bg-secondary'; ?>">
                            <?php echo ucfirst($tx['status']); ?>
                        </span>
                    </div>
                    <?php if (!empty($tx['reference_number'])): ?>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Reference</span>
                        <span><?php echo e($tx['reference_number']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
