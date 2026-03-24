<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="auth-card card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="auth-logo mb-3">🌿</div>
                        <h3 class="fw-bold">Create an Account</h3>
                        <p class="text-muted small">Join the Coir Roots community today</p>
                    </div>

                    <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=register" novalidate
                          id="registerForm">
                        <input type="hidden" name="action" value="register">

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>"
                                       id="name" name="name" required
                                       value="<?php echo e($formData['name'] ?? ''); ?>">
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback"><?php echo e($errors['name']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                       id="email" name="email" required
                                       value="<?php echo e($formData['email'] ?? ''); ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?php echo e($errors['email']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">+63</span>
                                <input type="tel" class="form-control" id="mobile" name="mobile"
                                       value="<?php echo e($formData['mobile'] ?? ''); ?>">
                            </div>
                            <div class="form-text">Optional — for delivery coordination.</div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Delivery Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                </span>
                                <textarea class="form-control" id="address" name="address" rows="2"><?php echo e($formData['address'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-coir">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                                           id="password" name="password" placeholder="Min. 6 characters" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (isset($errors['password'])): ?>
                                        <div class="invalid-feedback"><?php echo e($errors['password']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-coir">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control <?php echo isset($errors['confirm']) ? 'is-invalid' : ''; ?>"
                                           id="confirm_password" name="confirm_password"
                                           placeholder="Repeat password" required>
                                    <?php if (isset($errors['confirm'])): ?>
                                        <div class="invalid-feedback"><?php echo e($errors['confirm']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div id="passwordStrength" class="mb-3 d-none">
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">Password strength:</small>
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div id="strengthBar" class="progress-bar" style="width:0%"></div>
                                </div>
                                <small id="strengthText" class="fw-semibold"></small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    I agree to the <a href="#" class="link-coir">Terms of Service</a>
                                    and <a href="#" class="link-coir">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-coir w-100 py-2 fw-semibold" id="submitBtn">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </button>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        Already have an account?
                        <a href="<?php echo APP_URL; ?>/index.php?page=login" class="fw-semibold text-decoration-none link-coir">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const wrap = document.getElementById('passwordStrength');
    const bar = document.getElementById('strengthBar');
    const txt = document.getElementById('strengthText');

    if (val.length === 0) { wrap.classList.add('d-none'); return; }
    wrap.classList.remove('d-none');

    let score = 0;
    if (val.length >= 6) score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = ['', 'Very Weak', 'Weak', 'Fair', 'Strong', 'Very Strong'];
    const colors = ['', 'bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-success'];
    bar.className = 'progress-bar ' + colors[score];
    bar.style.width = (score * 20) + '%';
    txt.textContent = levels[score];
    txt.className = 'fw-semibold text-' + ['','danger','warning','info','success','success'][score];
});
</script>
