<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) : 'Seller Dashboard - Coir Roots'; ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>*</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="seller-body">

<nav class="navbar navbar-dark seller-topbar d-lg-none sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sellerSidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand fw-bold" href="<?php echo APP_URL; ?>/index.php?page=seller-dashboard">
            <i class="bi bi-flower1 text-warning me-1"></i>Coir Roots <small class="text-warning-emphasis">Seller</small>
        </a>
        <a href="<?php echo APP_URL; ?>/index.php?page=seller-logout" class="btn btn-sm btn-outline-light">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>
</nav>

<div class="offcanvas offcanvas-start seller-sidebar" tabindex="-1" id="sellerSidebar" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <span class="fw-bold fs-5 text-white"><i class="bi bi-flower1 text-warning me-1"></i>Coir Roots Seller</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <?php include __DIR__ . '/seller_nav.php'; ?>
    </div>
</div>

<div class="d-flex">
    <div class="seller-sidebar d-none d-lg-flex flex-column" style="width: 280px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;">
        <div class="p-4 border-bottom border-secondary seller-brand-block">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-dashboard" class="text-decoration-none">
                <h5 class="fw-bold text-white mb-1"><i class="bi bi-flower1 text-warning me-1"></i>Coir Roots</h5>
                <small class="text-warning">Seller Dashboard</small>
            </a>
        </div>
        <?php include __DIR__ . '/seller_nav.php'; ?>
        <div class="mt-auto p-4 border-top border-secondary seller-account-card">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                    <i class="bi bi-person-fill text-dark"></i>
                </div>
                <div>
                    <div class="text-white small fw-semibold"><?php echo e($_SESSION['seller_name'] ?? 'Admin'); ?></div>
                    <div class="text-muted" style="font-size:0.75rem;">Seller / Admin</div>
                </div>
            </div>
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-logout" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>

    <div class="seller-main-content flex-grow-1" style="margin-left: 280px;">
        <div class="seller-topbar d-none d-lg-flex align-items-center justify-content-between px-4 py-3">
            <div>
                <span class="text-muted small d-block">Seller workspace</span>
                <span class="fw-semibold text-white"><?php echo e($_SESSION['seller_name'] ?? 'Admin'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo APP_URL; ?>/index.php" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-shop me-1"></i>View Store
                </a>
                <a href="<?php echo APP_URL; ?>/index.php?page=seller-logout" class="btn btn-sm btn-danger">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </div>

        <?php
        $successMsg = getFlash('success');
        $errorMsg   = getFlash('error');
        if ($successMsg || $errorMsg):
        ?>
        <div class="px-4 pt-3">
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

        <div class="p-4 seller-content-wrap">
