<?php
session_start();

// Load config
require_once __DIR__ . '/app-config/database.php';
require_once __DIR__ . '/app-config/app.php';

// Load models
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/Category.php';
require_once __DIR__ . '/models/Cart.php';
require_once __DIR__ . '/models/Order.php';
require_once __DIR__ . '/models/Transaction.php';
require_once __DIR__ . '/models/Storefront.php';

// =====================
// HELPER FUNCTIONS
// =====================

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function flash($key, $msg) {
    $_SESSION['flash'][$key] = $msg;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isSellerLoggedIn() {
    return isset($_SESSION['seller_id']) && !empty($_SESSION['seller_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        flash('error', 'Please log in to continue.');
        redirect(APP_URL . '/index.php?page=login');
    }
}

function requireSellerLogin() {
    if (!isSellerLoggedIn()) {
        flash('error', 'Seller access required.');
        redirect(APP_URL . '/index.php?page=seller-login');
    }
}

function formatPrice($amount) {
    return '&#8369;' . number_format((float)$amount, 2);
}

function getCartCount() {
    if (!isLoggedIn()) return 0;
    $cart = new Cart();
    return $cart->getCount($_SESSION['user_id']);
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function e($str) {
    return htmlspecialchars((string)($str ?? ''), ENT_QUOTES, 'UTF-8');
}

// =====================
// ROUTING
// =====================

$page   = $_GET['page'] ?? 'home';
$action = $_POST['action'] ?? '';

switch ($page) {

    // =====================
    // HOME
    // =====================
    case 'home':
        $productModel    = new Product();
        $categoryModel   = new Category();
        $featuredProducts = $productModel->getFeatured(6);
        $categories      = $categoryModel->getAll();
        $pageTitle       = 'Coir Roots - Natural Philippine Coconut Coir Products';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/home.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // LOGIN
    // =====================
    case 'login':
        if (isLoggedIn()) redirect(APP_URL . '/index.php?page=home');
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $errors[] = 'Email and password are required.';
            } else {
                $userModel = new User();
                $user = $userModel->findByEmail($email);
                if ($user && $userModel->verifyPassword($password, $user['password'])) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    flash('success', 'Welcome back, ' . e($user['name']) . '!');
                    redirect(APP_URL . '/index.php?page=home');
                } else {
                    $errors[] = 'Invalid email or password.';
                }
            }
        }
        $pageTitle = 'Login - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/login.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // REGISTER
    // =====================
    case 'register':
        if (isLoggedIn()) redirect(APP_URL . '/index.php?page=home');
        $errors   = [];
        $formData = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register') {
            $formData = [
                'name'     => trim($_POST['name'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'mobile'   => trim($_POST['mobile'] ?? ''),
                'address'  => trim($_POST['address'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'confirm'  => $_POST['confirm_password'] ?? '',
            ];
            if (empty($formData['name']))   $errors['name']     = 'Name is required.';
            if (empty($formData['email']))  $errors['email']    = 'Email is required.';
            elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format.';
            if (empty($formData['password']))  $errors['password'] = 'Password is required.';
            elseif (strlen($formData['password']) < 6) $errors['password'] = 'Password must be at least 6 characters.';
            if ($formData['password'] !== $formData['confirm']) $errors['confirm'] = 'Passwords do not match.';

            if (empty($errors)) {
                $userModel = new User();
                $existing  = $userModel->findByEmail($formData['email']);
                if ($existing) {
                    $errors['email'] = 'This email is already registered.';
                } else {
                    $userId = $userModel->create([
                        'name'     => $formData['name'],
                        'email'    => $formData['email'],
                        'password' => password_hash($formData['password'], PASSWORD_DEFAULT),
                        'mobile'   => $formData['mobile'],
                        'address'  => $formData['address'],
                        'role'     => 'buyer',
                    ]);
                    $_SESSION['user_id']   = $userId;
                    $_SESSION['user_name'] = $formData['name'];
                    $_SESSION['user_role'] = 'buyer';
                    flash('success', 'Account created! Welcome to Coir Roots, ' . e($formData['name']) . '!');
                    redirect(APP_URL . '/index.php?page=home');
                }
            }
        }
        $pageTitle = 'Register - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/register.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // LOGOUT
    // =====================
    case 'logout':
        $_SESSION = [];
        session_destroy();
        redirect(APP_URL . '/index.php?page=login');
        break;

    // =====================
    // STOREFRONT
    // =====================
    case 'storefront':
        $storefrontModel = new Storefront();
        $newArrivals     = $storefrontModel->getProductsForSection('new_arrivals');
        $trending        = $storefrontModel->getProductsForSection('trending');
        $bestSellers     = $storefrontModel->getProductsForSection('best_sellers');
        $sections        = $storefrontModel->getAllSections();
        $sectionMap      = [];
        foreach ($sections as $s) {
            $sectionMap[$s['section']] = $s;
        }
        $pageTitle = 'Shop - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/storefront.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // PRODUCTS
    // =====================
    case 'products':
        $productModel  = new Product();
        $categoryModel = new Category();
        $filters = [
            'search'      => trim($_GET['search'] ?? ''),
            'category_id' => (int)($_GET['category_id'] ?? 0),
            'sort'        => $_GET['sort'] ?? 'newest',
        ];
        if ($filters['category_id'] === 0) unset($filters['category_id']);
        $products   = $productModel->getAll($filters);
        $categories = $categoryModel->getAll();
        $pageTitle  = 'Products - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/products.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // PRODUCT DETAIL
    // =====================
    case 'product':
        $productModel = new Product();
        $slug         = $_GET['slug'] ?? '';
        $product      = $slug ? $productModel->getBySlug($slug) : null;
        if (!$product) {
            flash('error', 'Product not found.');
            redirect(APP_URL . '/index.php?page=products');
        }
        $allRelated      = $productModel->getAll(['category_id' => $product['category_id']]);
        $relatedProducts = array_values(array_filter($allRelated, function($p) use ($product) {
            return $p['id'] != $product['id'];
        }));
        $relatedProducts = array_slice($relatedProducts, 0, 4);
        $pageTitle       = e($product['name']) . ' - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/product_detail.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // CART ADD
    // =====================
    case 'cart-add':
        requireLogin();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = max(1, (int)($_POST['quantity'] ?? 1));
        if ($productId > 0) {
            $productModel = new Product();
            $prod = $productModel->getById($productId);
            if ($prod && $prod['stock'] > 0) {
                $cartModel = new Cart();
                $cartModel->addItem($_SESSION['user_id'], $productId, $quantity);
                flash('success', e($prod['name']) . ' added to cart!');
            } else {
                flash('error', 'Product unavailable or out of stock.');
            }
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? APP_URL . '/index.php?page=products';
        redirect($referer);
        break;

    // =====================
    // CART VIEW
    // =====================
    case 'cart':
        requireLogin();
        $cartModel = new Cart();
        $cartItems = $cartModel->getByUser($_SESSION['user_id']);
        $subtotal  = $cartModel->getTotal($_SESSION['user_id']);
        $shipping  = ($subtotal >= FREE_SHIPPING_THRESHOLD) ? 0 : SHIPPING_FEE;
        $total     = $subtotal + $shipping;
        $pageTitle = 'My Cart - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/cart.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // CART UPDATE
    // =====================
    case 'cart-update':
        requireLogin();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 0);
        if ($productId > 0) {
            $cartModel = new Cart();
            $cartModel->updateQuantity($_SESSION['user_id'], $productId, $quantity);
        }
        redirect(APP_URL . '/index.php?page=cart');
        break;

    // =====================
    // CART REMOVE
    // =====================
    case 'cart-remove':
        requireLogin();
        $productId = (int)($_POST['product_id'] ?? 0);
        if ($productId > 0) {
            $cartModel = new Cart();
            $cartModel->removeItem($_SESSION['user_id'], $productId);
            flash('success', 'Item removed from cart.');
        }
        redirect(APP_URL . '/index.php?page=cart');
        break;

    // =====================
    // CHECKOUT
    // =====================
    case 'checkout':
        requireLogin();
        $cartModel = new Cart();
        $cartItems = $cartModel->getByUser($_SESSION['user_id']);
        if (empty($cartItems)) {
            flash('error', 'Your cart is empty.');
            redirect(APP_URL . '/index.php?page=products');
        }
        $userModel = new User();
        $user      = $userModel->findById($_SESSION['user_id']);
        $subtotal  = $cartModel->getTotal($_SESSION['user_id']);
        $shipping  = ($subtotal >= FREE_SHIPPING_THRESHOLD) ? 0 : SHIPPING_FEE;
        $total     = $subtotal + $shipping;
        $pageTitle = 'Checkout - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/checkout.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // PLACE ORDER
    // =====================
    case 'place-order':
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(APP_URL . '/index.php?page=checkout');
        }
        $cartModel = new Cart();
        $cartItems = $cartModel->getByUser($_SESSION['user_id']);
        if (empty($cartItems)) {
            flash('error', 'Your cart is empty.');
            redirect(APP_URL . '/index.php?page=cart');
        }

        $paymentMethod     = $_POST['payment_method'] ?? 'cod';
        $fulfillmentMethod = $_POST['fulfillment_method'] ?? 'delivery';
        $deliveryAddress   = trim($_POST['delivery_address'] ?? '');
        $notes             = trim($_POST['notes'] ?? '');

        $allowedPayment = ['cod', 'gcash', 'bank_transfer'];
        $allowedFulfil  = ['pickup', 'delivery'];
        if (!in_array($paymentMethod, $allowedPayment))    $paymentMethod = 'cod';
        if (!in_array($fulfillmentMethod, $allowedFulfil)) $fulfillmentMethod = 'delivery';

        if ($fulfillmentMethod === 'delivery' && empty($deliveryAddress)) {
            flash('error', 'Delivery address is required for delivery orders.');
            redirect(APP_URL . '/index.php?page=checkout');
        }

        $subtotal = $cartModel->getTotal($_SESSION['user_id']);
        $shipping = ($subtotal >= FREE_SHIPPING_THRESHOLD) ? 0 : SHIPPING_FEE;
        $total    = $subtotal + $shipping;

        $items = [];
        foreach ($cartItems as $item) {
            $items[] = [
                'product_id' => $item['product_id'],
                'name'       => $item['name'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ];
        }

        try {
            $orderModel   = new Order();
            $productModel = new Product();
            $orderId = $orderModel->create([
                'user_id'            => $_SESSION['user_id'],
                'total_amount'       => $total,
                'subtotal'           => $subtotal,
                'shipping_fee'       => $shipping,
                'payment_method'     => $paymentMethod,
                'fulfillment_method' => $fulfillmentMethod,
                'delivery_address'   => $deliveryAddress,
                'notes'              => $notes,
                'items'              => $items,
            ]);

            foreach ($cartItems as $item) {
                $productModel->updateStock($item['product_id'], $item['quantity']);
            }

            $cartModel->clearCart($_SESSION['user_id']);
            flash('success', 'Order #' . $orderId . ' placed successfully! Thank you for shopping with Coir Roots.');
            redirect(APP_URL . '/index.php?page=order-detail&id=' . $orderId);
        } catch (Exception $e) {
            flash('error', 'Failed to place order. Please try again.');
            redirect(APP_URL . '/index.php?page=checkout');
        }
        break;

    // =====================
    // ORDERS LIST
    // =====================
    case 'orders':
        requireLogin();
        $orderModel = new Order();
        $orders     = $orderModel->getByUser($_SESSION['user_id']);
        $pageTitle  = 'My Orders - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/orders.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // ORDER DETAIL
    // =====================
    case 'order-detail':
        requireLogin();
        $orderId    = (int)($_GET['id'] ?? 0);
        $orderModel = new Order();
        $order      = $orderModel->getById($orderId);
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            flash('error', 'Order not found.');
            redirect(APP_URL . '/index.php?page=orders');
        }
        $txModel      = new Transaction();
        $transactions = $txModel->getByOrder($orderId);
        $pageTitle    = 'Order #' . $orderId . ' - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/order_detail.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // PROFILE
    // =====================
    case 'profile':
        requireLogin();
        $userModel = new User();
        $user      = $userModel->findById($_SESSION['user_id']);
        $errors    = [];
        $pageTitle = 'My Profile - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        require_once __DIR__ . '/views/profile.php';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    // =====================
    // PROFILE UPDATE
    // =====================
    case 'profile-update':
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(APP_URL . '/index.php?page=profile');
        }
        $userModel = new User();
        $errors    = [];
        $name      = trim($_POST['name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $mobile    = trim($_POST['mobile'] ?? '');
        $address   = trim($_POST['address'] ?? '');
        $newPass   = $_POST['new_password'] ?? '';
        $confirm   = $_POST['confirm_password'] ?? '';

        if (empty($name))  $errors[] = 'Name is required.';
        if (empty($email)) $errors[] = 'Email is required.';
        if (!empty($newPass) && strlen($newPass) < 6) $errors[] = 'Password must be at least 6 characters.';
        if (!empty($newPass) && $newPass !== $confirm) $errors[] = 'Passwords do not match.';

        if (empty($errors)) {
            $updateData = ['name' => $name, 'email' => $email, 'mobile' => $mobile, 'address' => $address];
            if (!empty($newPass)) {
                $updateData['password'] = password_hash($newPass, PASSWORD_DEFAULT);
            }
            $userModel->update($_SESSION['user_id'], $updateData);
            $_SESSION['user_name'] = $name;
            flash('success', 'Profile updated successfully!');
        } else {
            flash('error', implode(' ', $errors));
        }
        redirect(APP_URL . '/index.php?page=profile');
        break;

    // =====================
    // SELLER LOGIN
    // =====================
    case 'seller-login':
        if (isSellerLoggedIn()) redirect(APP_URL . '/index.php?page=seller-dashboard');
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'seller-login') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $errors[] = 'Email and password are required.';
            } else {
                $userModel = new User();
                $user = $userModel->findByEmail($email);
                if ($user && $user['role'] === 'seller' && $userModel->verifyPassword($password, $user['password'])) {
                    $_SESSION['seller_id']   = $user['id'];
                    $_SESSION['seller_name'] = $user['name'];
                    $_SESSION['seller_role'] = $user['role'];
                    flash('success', 'Welcome back, ' . e($user['name']) . '!');
                    redirect(APP_URL . '/index.php?page=seller-dashboard');
                } else {
                    $errors[] = 'Invalid credentials or insufficient permissions.';
                }
            }
        }
        $pageTitle = 'Seller Login - Coir Roots';
        require_once __DIR__ . '/views/seller/login.php';
        break;

    // =====================
    // SELLER LOGOUT
    // =====================
    case 'seller-logout':
        unset($_SESSION['seller_id'], $_SESSION['seller_name'], $_SESSION['seller_role']);
        flash('success', 'Seller session ended.');
        redirect(APP_URL . '/index.php?page=seller-login');
        break;

    // =====================
    // SELLER DASHBOARD
    // =====================
    case 'seller-dashboard':
        requireSellerLogin();
        $orderModel    = new Order();
        $productModel  = new Product();
        $todaySales    = $orderModel->getTodaySales();
        $monthSales    = $orderModel->getMonthSales();
        $recentOrders  = $orderModel->getRecentOrders(10);
        $allProducts   = $productModel->getAll();
        $totalProducts = count($allProducts);
        $allOrders     = $orderModel->getAll();
        $totalOrders   = count($allOrders);
        $lowStock      = array_values(array_filter($allProducts, function($p) { return $p['stock'] < 10 && $p['stock'] > 0; }));
        $outOfStock    = array_values(array_filter($allProducts, function($p) { return $p['stock'] <= 0; }));
        $pageTitle     = 'Seller Dashboard - Coir Roots';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/dashboard.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER INVENTORY
    // =====================
    case 'seller-inventory':
        requireSellerLogin();
        $productModel  = new Product();
        $categoryModel = new Category();
        $products      = $productModel->getAll();
        $categories    = $categoryModel->getAll();
        $pageTitle     = 'Inventory - Coir Roots Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/inventory.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER ADD PRODUCT
    // =====================
    case 'seller-add-product':
        requireSellerLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add-product') {
            $name  = trim($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $errs  = [];
            if (empty($name)) $errs[] = 'Product name is required.';
            if ($price <= 0)  $errs[] = 'Price must be greater than 0.';
            if ($stock < 0)   $errs[] = 'Stock cannot be negative.';
            if (empty($errs)) {
                $productModel = new Product();
                $slug = slugify($name);
                $existing = $productModel->getBySlug($slug);
                if ($existing) $slug .= '-' . time();
                $productModel->create([
                    'name'              => $name,
                    'slug'              => $slug,
                    'description'       => trim($_POST['description'] ?? ''),
                    'short_description' => trim($_POST['short_description'] ?? ''),
                    'price'             => $price,
                    'stock'             => $stock,
                    'category_id'       => (int)($_POST['category_id'] ?? 0) ?: null,
                    'image'             => trim($_POST['image'] ?? ''),
                    'is_featured'       => isset($_POST['is_featured']) ? 1 : 0,
                    'is_new_arrival'    => isset($_POST['is_new_arrival']) ? 1 : 0,
                    'is_trending'       => isset($_POST['is_trending']) ? 1 : 0,
                    'is_best_seller'    => isset($_POST['is_best_seller']) ? 1 : 0,
                ]);
                flash('success', 'Product "' . e($name) . '" added successfully!');
            } else {
                flash('error', implode(' ', $errs));
            }
        }
        redirect(APP_URL . '/index.php?page=seller-inventory');
        break;

    // =====================
    // SELLER EDIT PRODUCT
    // =====================
    case 'seller-edit-product':
        requireSellerLogin();
        $productModel  = new Product();
        $categoryModel = new Category();
        $productId     = (int)($_GET['id'] ?? 0);
        $product       = $productModel->getById($productId);
        if (!$product) {
            flash('error', 'Product not found.');
            redirect(APP_URL . '/index.php?page=seller-inventory');
        }
        $errors     = [];
        $categories = $categoryModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit-product') {
            $name  = trim($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            if (empty($name)) $errors[] = 'Product name is required.';
            if ($price <= 0)  $errors[] = 'Price must be greater than 0.';
            if (empty($errors)) {
                $slug = slugify($name);
                $existing = $productModel->getBySlug($slug);
                if ($existing && $existing['id'] != $productId) $slug .= '-' . $productId;
                $productModel->update($productId, [
                    'name'              => $name,
                    'slug'              => $slug,
                    'description'       => trim($_POST['description'] ?? ''),
                    'short_description' => trim($_POST['short_description'] ?? ''),
                    'price'             => $price,
                    'stock'             => $stock,
                    'category_id'       => (int)($_POST['category_id'] ?? 0) ?: null,
                    'image'             => trim($_POST['image'] ?? ''),
                    'is_featured'       => isset($_POST['is_featured']) ? 1 : 0,
                    'is_new_arrival'    => isset($_POST['is_new_arrival']) ? 1 : 0,
                    'is_trending'       => isset($_POST['is_trending']) ? 1 : 0,
                    'is_best_seller'    => isset($_POST['is_best_seller']) ? 1 : 0,
                ]);
                flash('success', 'Product updated successfully!');
                redirect(APP_URL . '/index.php?page=seller-inventory');
            } else {
                flash('error', implode(' ', $errors));
            }
        }
        $pageTitle = 'Edit Product - Coir Roots Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/edit_product.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER DELETE PRODUCT
    // =====================
    case 'seller-delete-product':
        requireSellerLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete-product') {
            $productId    = (int)($_POST['product_id'] ?? 0);
            $productModel = new Product();
            $product      = $productModel->getById($productId);
            if ($product) {
                $productModel->delete($productId);
                flash('success', 'Product "' . e($product['name']) . '" deleted.');
            } else {
                flash('error', 'Product not found.');
            }
        }
        redirect(APP_URL . '/index.php?page=seller-inventory');
        break;

    // =====================
    // SELLER STOREFRONT
    // =====================
    case 'seller-storefront':
        requireSellerLogin();
        $storefrontModel = new Storefront();
        $productModel    = new Product();
        $allProducts     = $productModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $section    = $_POST['section'] ?? '';
            $productIds = $_POST['product_ids'] ?? [];
            $bannerText = trim($_POST['banner_text'] ?? '');
            $allowed    = ['new_arrivals', 'trending', 'best_sellers'];
            if (in_array($section, $allowed)) {
                $storefrontModel->updateSection($section, $productIds, $bannerText);
                flash('success', 'Storefront section updated!');
            }
            redirect(APP_URL . '/index.php?page=seller-storefront');
        }
        $sections   = $storefrontModel->getAllSections();
        $sectionMap = [];
        foreach ($sections as $s) {
            $sectionMap[$s['section']] = $s;
        }
        $pageTitle = 'Storefront Management - Coir Roots Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/storefront.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER REPORTS
    // =====================
    case 'seller-reports':
        requireSellerLogin();
        $orderModel   = new Order();
        $txModel      = new Transaction();
        $todaySales   = $orderModel->getTodaySales();
        $monthSales   = $orderModel->getMonthSales();
        $monthlySales = $orderModel->getSalesByMonth(date('Y'));
        $transactions = $txModel->getAll();
        $pageTitle    = 'Sales Reports - Coir Roots Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/reports.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER INVENTORY REPORT
    // =====================
    case 'seller-inventory-report':
        requireSellerLogin();
        $productModel  = new Product();
        $inventory     = $productModel->getInventorySummary();
        $totalProducts = count($inventory);
        $totalValue    = array_sum(array_column($inventory, 'stock_value'));
        $lowStock      = array_values(array_filter($inventory, function($p) { return $p['stock'] > 0 && $p['stock'] < 10; }));
        $outOfStock    = array_values(array_filter($inventory, function($p) { return $p['stock'] <= 0; }));
        $pageTitle     = 'Inventory Report - Coir Roots Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/inventory_report.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // SELLER ORDER DETAIL
    // =====================
    case 'seller-order-detail':
        requireSellerLogin();
        $orderId    = (int)($_GET['id'] ?? 0);
        $orderModel = new Order();
        $order      = $orderModel->getById($orderId);
        if (!$order) {
            flash('error', 'Order not found.');
            redirect(APP_URL . '/index.php?page=seller-dashboard');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update-status') {
            $newStatus       = $_POST['status'] ?? '';
            $allowedStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
            if (in_array($newStatus, $allowedStatuses)) {
                $orderModel->updateStatus($orderId, $newStatus);
                flash('success', 'Order status updated to "' . e($newStatus) . '".');
            }
            redirect(APP_URL . '/index.php?page=seller-order-detail&id=' . $orderId);
        }
        $txModel      = new Transaction();
        $transactions = $txModel->getByOrder($orderId);
        $pageTitle    = 'Order #' . $orderId . ' - Seller';
        require_once __DIR__ . '/views/layouts/seller_header.php';
        require_once __DIR__ . '/views/seller/order_detail.php';
        require_once __DIR__ . '/views/layouts/seller_footer.php';
        break;

    // =====================
    // 404
    // =====================
    default:
        $pageTitle = '404 Not Found - Coir Roots';
        require_once __DIR__ . '/views/layouts/header.php';
        echo '<div class="container py-5 text-center">
            <h1 class="display-1 fw-bold text-muted">404</h1>
            <h3>Page Not Found</h3>
            <p class="text-muted">The page you are looking for does not exist.</p>
            <a href="' . APP_URL . '/index.php" class="btn btn-coir mt-3">Go Home</a>
        </div>';
        require_once __DIR__ . '/views/layouts/footer.php';
        break;
}
