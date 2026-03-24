<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) : 'Seller Login - Coir Roots'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="seller-login-body">
    <div class="seller-login-shell">
        <div class="seller-login-card">
            <div class="mb-4 text-center">
                <div class="seller-login-mark mb-3"><i class="bi bi-shop-window"></i></div>
                <h1 class="h3 fw-bold mb-2">Seller Portal</h1>
                <p class="text-muted mb-0">Manage inventory, storefront highlights, and business reports.</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($success = getFlash('success')): ?>
                <div class="alert alert-success"><?php echo e($success); ?></div>
            <?php endif; ?>

            <?php if ($error = getFlash('error')): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo APP_URL; ?>/index.php?page=seller-login" class="d-grid gap-3">
                <input type="hidden" name="action" value="seller-login">
                <div>
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div>
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-coir btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <div class="seller-login-meta">
                <div><strong>Default admin:</strong> admin@coirroots.ph</div>
                <div><strong>Password:</strong> Admin@123</div>
                <a href="<?php echo APP_URL; ?>/index.php" class="link-coir text-decoration-none mt-2 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i>Back to storefront
                </a>
            </div>
        </div>
    </div>
</body>
</html>
