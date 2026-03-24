<?php
$currentPage = $_GET['page'] ?? 'seller-dashboard';
if (!function_exists('navActive')) {
    function navActive($p) {
        global $currentPage;
        return $currentPage === $p ? 'active' : '';
    }
}
?>
<nav class="seller-nav p-2 flex-grow-1">
    <ul class="nav flex-column gap-1">
        <li class="nav-item">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-dashboard"
               class="nav-link seller-nav-link <?php echo navActive('seller-dashboard'); ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-inventory"
               class="nav-link seller-nav-link <?php echo navActive('seller-inventory'); ?>">
                <i class="bi bi-box-seam me-2"></i> Inventory
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-storefront"
               class="nav-link seller-nav-link <?php echo navActive('seller-storefront'); ?>">
                <i class="bi bi-shop-window me-2"></i> Storefront
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-reports"
               class="nav-link seller-nav-link <?php echo navActive('seller-reports'); ?>">
                <i class="bi bi-bar-chart-line me-2"></i> Sales Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo APP_URL; ?>/index.php?page=seller-inventory-report"
               class="nav-link seller-nav-link <?php echo navActive('seller-inventory-report'); ?>">
                <i class="bi bi-clipboard-data me-2"></i> Inventory Report
            </a>
        </li>
    </ul>
</nav>
