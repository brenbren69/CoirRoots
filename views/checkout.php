<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-credit-card me-2"></i>Checkout
    </h2>

    <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=place-order"
          id="checkoutForm" novalidate>
        <input type="hidden" name="action" value="place-order">

        <div class="row g-4">
            <!-- Left: Form -->
            <div class="col-lg-7">

                <!-- Payment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light-coir border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-wallet2 me-2 text-coir"></i>Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="pay_cod" value="cod" checked>
                                <label class="btn btn-outline-coir w-100 h-100 p-3 text-start" for="pay_cod">
                                    <i class="bi bi-cash-stack d-block fs-4 mb-2 text-warning"></i>
                                    <span class="fw-semibold d-block">Cash on Delivery</span>
                                    <small class="text-muted">Pay when your order arrives</small>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="pay_gcash" value="gcash">
                                <label class="btn btn-outline-coir w-100 h-100 p-3 text-start" for="pay_gcash">
                                    <i class="bi bi-phone d-block fs-4 mb-2 text-primary"></i>
                                    <span class="fw-semibold d-block">GCash</span>
                                    <small class="text-muted">Pay via GCash mobile wallet</small>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="pay_bank" value="bank_transfer">
                                <label class="btn btn-outline-coir w-100 h-100 p-3 text-start" for="pay_bank">
                                    <i class="bi bi-bank d-block fs-4 mb-2 text-success"></i>
                                    <span class="fw-semibold d-block">Bank Transfer</span>
                                    <small class="text-muted">BDO, BPI, Metrobank</small>
                                </label>
                            </div>
                        </div>

                        <!-- GCash Info -->
                        <div id="gcashInfo" class="mt-3 alert alert-info d-none">
                            <i class="bi bi-info-circle me-2"></i>
                            GCash Number: <strong>0917-XXX-XXXX</strong> (Coir Roots).
                            Send your payment proof via Messenger after placing the order.
                        </div>
                        <!-- Bank Info -->
                        <div id="bankInfo" class="mt-3 alert alert-info d-none">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>BDO Savings:</strong> Account #: 123-456-789 | Name: Coir Roots Trading.
                            Email payment receipt to: payments@coirroots.ph
                        </div>
                    </div>
                </div>

                <!-- Fulfillment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light-coir border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-truck me-2 text-coir"></i>Fulfillment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="fulfillment_method"
                                       id="fulfill_delivery" value="delivery" checked>
                                <label class="btn btn-outline-coir w-100 p-3 text-start" for="fulfill_delivery">
                                    <i class="bi bi-truck d-block fs-4 mb-1 text-primary"></i>
                                    <span class="fw-semibold">Home Delivery</span>
                                    <small class="d-block text-muted">We ship to your address</small>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="fulfillment_method"
                                       id="fulfill_pickup" value="pickup">
                                <label class="btn btn-outline-coir w-100 p-3 text-start" for="fulfill_pickup">
                                    <i class="bi bi-shop d-block fs-4 mb-1 text-success"></i>
                                    <span class="fw-semibold">Pickup</span>
                                    <small class="d-block text-muted">Pick up at our Albay warehouse</small>
                                </label>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div id="deliveryAddressSection">
                            <label for="delivery_address" class="form-label fw-semibold">
                                Delivery Address <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="delivery_address" name="delivery_address"
                                      rows="3" placeholder="House No., Street, Barangay, City, Province, ZIP Code"
                                      required><?php echo e($user['address'] ?? ''); ?></textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pre-filled from your profile. Edit if needed.
                            </div>
                        </div>

                        <!-- Pickup Info -->
                        <div id="pickupInfo" class="alert alert-success d-none mt-3 mb-0">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <strong>Pickup Location:</strong> Coir Roots Warehouse, Brgy. Guinobatan, Albay.
                            We'll contact you when your order is ready (Mon–Sat, 8AM–5PM).
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light-coir border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-chat-text me-2 text-coir"></i>Order Notes
                            <span class="text-muted fw-normal small">(Optional)</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="notes" rows="3"
                                  placeholder="Special instructions, gift message, or anything we should know about your order..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-header bg-light-coir border-0 py-3">
                        <h5 class="fw-bold mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Items List -->
                        <div class="checkout-items mb-3">
                            <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                <img src="<?php echo e($item['image'] ?: 'https://placehold.co/50x50/5C3D1E/F5ECD7?text=P'); ?>"
                                     alt="<?php echo e($item['name']); ?>"
                                     width="45" height="45"
                                     class="rounded-2 object-fit-cover">
                                <div class="flex-grow-1 small">
                                    <div class="fw-semibold"><?php echo e($item['name']); ?></div>
                                    <div class="text-muted">Qty: <?php echo $item['quantity']; ?></div>
                                </div>
                                <div class="fw-semibold small">
                                    <?php echo formatPrice($item['price'] * $item['quantity']); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span><?php echo formatPrice($subtotal); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span id="checkoutShipping" class="<?php echo $shipping == 0 ? 'text-success fw-semibold' : ''; ?>">
                                <?php echo $shipping == 0 ? 'FREE' : formatPrice($shipping); ?>
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5 text-coir"><?php echo formatPrice($total); ?></span>
                        </div>

                        <button type="submit" class="btn btn-coir btn-lg w-100 fw-semibold">
                            <i class="bi bi-bag-check me-2"></i>Place Order
                        </button>
                        <p class="text-center text-muted small mt-3 mb-0">
                            <i class="bi bi-shield-check me-1 text-success"></i>
                            By placing your order, you agree to our Terms of Service.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Toggle delivery address / pickup info
const fulfillDelivery = document.getElementById('fulfill_delivery');
const fulfillPickup   = document.getElementById('fulfill_pickup');
const deliverySection = document.getElementById('deliveryAddressSection');
const pickupInfo      = document.getElementById('pickupInfo');
const addrField       = document.getElementById('delivery_address');

function toggleFulfillment() {
    if (fulfillPickup.checked) {
        deliverySection.classList.add('d-none');
        pickupInfo.classList.remove('d-none');
        addrField.removeAttribute('required');
    } else {
        deliverySection.classList.remove('d-none');
        pickupInfo.classList.add('d-none');
        addrField.setAttribute('required', 'required');
    }
}

fulfillDelivery.addEventListener('change', toggleFulfillment);
fulfillPickup.addEventListener('change', toggleFulfillment);

// Payment method info toggle
document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.getElementById('gcashInfo').classList.add('d-none');
        document.getElementById('bankInfo').classList.add('d-none');
        if (this.value === 'gcash') document.getElementById('gcashInfo').classList.remove('d-none');
        if (this.value === 'bank_transfer') document.getElementById('bankInfo').classList.remove('d-none');
    });
});
</script>
