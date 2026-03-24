<?php
$hasSections = !empty($newArrivals) || !empty($trending) || !empty($bestSellers);
$heroFeature = $trending[0] ?? $bestSellers[0] ?? $newArrivals[0] ?? null;
$totalCurated = count($newArrivals) + count($trending) + count($bestSellers);
$storeSignals = [
    ['label' => 'Curated selections', 'value' => $totalCurated > 0 ? $totalCurated . '+' : 'Fresh'],
    ['label' => 'Ready for pickup or delivery', 'value' => '2 ways'],
    ['label' => 'Natural coir solutions', 'value' => 'Eco'],
];
$sections = [
    [
        'slug' => 'new-arrivals',
        'eyebrow' => 'Just In',
        'title' => 'New Arrivals',
        'copy' => !empty($sectionMap['new_arrivals']['banner_text']) ? $sectionMap['new_arrivals']['banner_text'] : 'Fresh additions for growers, builders, and homes looking for sustainable materials.',
        'items' => $newArrivals,
        'tone' => 'arrival',
        'icon' => 'bi-stars',
    ],
    [
        'slug' => 'trending',
        'eyebrow' => 'Popular Now',
        'title' => 'Trending Products',
        'copy' => !empty($sectionMap['trending']['banner_text']) ? $sectionMap['trending']['banner_text'] : 'What customers are reaching for most right now across the Coir Roots catalog.',
        'items' => $trending,
        'tone' => 'trending',
        'icon' => 'bi-graph-up-arrow',
    ],
    [
        'slug' => 'best-sellers',
        'eyebrow' => 'Trusted Picks',
        'title' => 'Best Sellers',
        'copy' => !empty($sectionMap['best_sellers']['banner_text']) ? $sectionMap['best_sellers']['banner_text'] : 'Top-performing coconut coir products chosen again and again for quality and utility.',
        'items' => $bestSellers,
        'tone' => 'bestseller',
        'icon' => 'bi-award',
    ],
];
?>

<section class="shop-shell">
    <section class="shop-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <span class="hero-kicker">Curated Coir Roots storefront</span>
                    <h1 class="shop-hero-title">Shop the collections built to move people from browsing to buying.</h1>
                    <p class="shop-hero-copy">
                        Explore a more focused shopping experience with new releases, trending favorites, and
                        proven best sellers. Every collection is arranged to help customers find the right coir
                        product faster.
                    </p>
                    <div class="hero-actions">
                        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-warning btn-lg px-4">
                            Browse Full Catalog
                        </a>
                        <a href="#shop-curated" class="btn btn-outline-light btn-lg px-4">
                            Explore Sections
                        </a>
                    </div>
                    <div class="shop-signal-row">
                        <?php foreach ($storeSignals as $signal): ?>
                            <div class="shop-signal-card">
                                <strong><?php echo e($signal['value']); ?></strong>
                                <span><?php echo e($signal['label']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="shop-feature-panel">
                        <?php if ($heroFeature): ?>
                            <div class="shop-feature-image-wrap">
                                <img
                                    src="<?php echo e($heroFeature['image']); ?>"
                                    alt="<?php echo e($heroFeature['name']); ?>"
                                    class="shop-feature-image"
                                >
                            </div>
                            <div class="shop-feature-body">
                                <span class="shop-feature-tag">Storefront highlight</span>
                                <?php if (!empty($heroFeature['category_name'])): ?>
                                    <div class="spotlight-category"><?php echo e($heroFeature['category_name']); ?></div>
                                <?php endif; ?>
                                <h2><?php echo e($heroFeature['name']); ?></h2>
                                <p><?php echo e($heroFeature['short_description'] ?: $heroFeature['description']); ?></p>
                                <div class="shop-feature-footer">
                                    <span class="spotlight-price"><?php echo formatPrice($heroFeature['price']); ?></span>
                                    <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($heroFeature['slug']); ?>" class="spotlight-link">
                                        View product <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="shop-empty-feature">
                                <span class="shop-feature-tag">Storefront update</span>
                                <h2>Curated collections are being prepared.</h2>
                                <p>Browse the full products page while featured sections are still being filled in.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($hasSections): ?>
        <section class="shop-anchor-bar" id="shop-curated">
            <div class="container">
                <div class="shop-anchor-wrap">
                    <?php foreach ($sections as $section): ?>
                        <?php if (!empty($section['items'])): ?>
                            <a href="#<?php echo e($section['slug']); ?>" class="shop-anchor-link">
                                <i class="bi <?php echo e($section['icon']); ?>"></i>
                                <span><?php echo e($section['title']); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php foreach ($sections as $section): ?>
            <?php if (empty($section['items'])) continue; ?>
            <section class="shop-section shop-section-<?php echo e($section['tone']); ?>" id="<?php echo e($section['slug']); ?>">
                <div class="container">
                    <div class="shop-section-header">
                        <div>
                            <span class="section-eyebrow"><?php echo e($section['eyebrow']); ?></span>
                            <h2><?php echo e($section['title']); ?></h2>
                            <p><?php echo e($section['copy']); ?></p>
                        </div>
                        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="section-link">
                            See all products <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="row g-4">
                        <?php foreach ($section['items'] as $prod): ?>
                            <div class="col-lg-3 col-md-6">
                                <?php if ($section['tone'] === 'bestseller'): ?>
                                    <div class="shop-badge-wrap">
                                        <span class="storefront-ribbon">Best Seller</span>
                                        <?php require __DIR__ . '/partials/product_card.php'; ?>
                                    </div>
                                <?php else: ?>
                                    <?php require __DIR__ . '/partials/product_card.php'; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>

        <section class="shop-closing">
            <div class="container">
                <div class="cta-panel">
                    <div>
                        <span class="section-eyebrow text-light">Need More Options</span>
                        <h2>Go beyond the curated shelves and view the full catalog.</h2>
                        <p>Search across all available coir products, compare categories, and add what fits your project.</p>
                    </div>
                    <div class="cta-actions">
                        <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-warning btn-lg px-4">View All Products</a>
                        <a href="<?php echo APP_URL; ?>/index.php?page=cart" class="btn btn-outline-light btn-lg px-4">Go to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <section class="shop-empty-state">
            <div class="container">
                <div class="empty-panel text-center">
                    <i class="bi bi-shop display-4 mb-3 d-block text-muted"></i>
                    <h2 class="mb-3">The curated storefront is still being prepared.</h2>
                    <p class="mb-4">Featured collections will appear here once products are assigned to each section.</p>
                    <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-coir btn-lg px-4">Browse All Products</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</section>
