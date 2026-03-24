<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) : 'Coir Roots'; ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>*</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark coir-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?php echo APP_URL; ?>/index.php">
            <span class="text-warning"><i class="bi bi-flower1"></i></span> Coir Roots
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo (($_GET['page'] ?? 'home') === 'home') ? 'active' : ''; ?>"
                       href="<?php echo APP_URL; ?>/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (($_GET['page'] ?? '') === 'products') ? 'active' : ''; ?>"
                       href="<?php echo APP_URL; ?>/index.php?page=products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (($_GET['page'] ?? '') === 'storefront') ? 'active' : ''; ?>"
                       href="<?php echo APP_URL; ?>/index.php?page=storefront">Shop</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="<?php echo APP_URL; ?>/index.php?page=cart">
                            <i class="bi bi-cart3 fs-5"></i>
                            <?php $cartCount = getCartCount(); if ($cartCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    <?php echo $cartCount; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="ms-1"><?php echo e($_SESSION['user_name']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/index.php?page=profile">
                                <i class="bi bi-person me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/index.php?page=orders">
                                <i class="bi bi-bag-check me-2"></i>My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo APP_URL; ?>/index.php?page=logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/index.php?page=login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm ms-2 fw-semibold"
                           href="<?php echo APP_URL; ?>/index.php?page=register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php
$successMsg = getFlash('success');
$errorMsg   = getFlash('error');
if ($successMsg || $errorMsg):
?>
<div class="container mt-3 flash-wrap">
    <?php if ($successMsg): ?>
        <div class="alert alert-success alert-dismissible fade show flash-msg" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e($successMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger alert-dismissible fade show flash-msg" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e($errorMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<main>
