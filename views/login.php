<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="auth-card card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="auth-logo mb-3">🌿</div>
                        <h3 class="fw-bold">Welcome Back</h3>
                        <p class="text-muted small">Sign in to your Coir Roots account</p>
                        <a href="<?php echo APP_URL; ?>/index.php?page=seller-login"
                           class="btn btn-sm btn-outline-secondary mt-1">
                            <i class="bi bi-shield-lock me-1"></i>Seller / Admin Portal
                        </a>
                    </div>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php foreach ($errors as $err): ?>
                                <div><?php echo e($err); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=login" novalidate>
                        <input type="hidden" name="action" value="login">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="you@example.com" required
                                       value="<?php echo e($_POST['email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-coir">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-coir w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </button>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        Don't have an account?
                        <a href="<?php echo APP_URL; ?>/index.php?page=register" class="fw-semibold text-decoration-none link-coir">
                            Create one here
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
</script>
