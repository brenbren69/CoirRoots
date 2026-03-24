<?php
$heroProduct = $featuredProducts[0] ?? null;
$featuredCount = count($featuredProducts);
$categoryCount = count($categories);
$bestUseCases = [
    ['title' => 'Grow Better', 'copy' => 'Coir pots, peat blocks, and grow bags that support healthier root systems and stronger seedlings.', 'icon' => 'bi-flower1'],
    ['title' => 'Build Naturally', 'copy' => 'Geotextiles, nets, and insulation materials made for projects that need performance and sustainability.', 'icon' => 'bi-building-check'],
    ['title' => 'Style Greener', 'copy' => 'Doormats, planters, and woven decor that bring handcrafted texture into homes and garden spaces.', 'icon' => 'bi-house-heart'],
];
$journeySteps = [
    ['step' => 'Collect', 'copy' => 'We source coconut husks from Philippine farming communities instead of letting them go to waste.'],
    ['step' => 'Craft', 'copy' => 'Fibers are cleaned, processed, and formed into practical products for homes, farms, and job sites.'],
    ['step' => 'Deliver', 'copy' => 'Orders are packed for pickup or delivery so customers can use natural materials with less environmental cost.'],
];
$testimonials = [
    ['name' => 'Maria Reyes', 'role' => 'Urban Farmer, Quezon City', 'initials' => 'MR', 'rating' => '5.0', 'quote' => 'The coir grow bags made my tomato setup easier to manage and the roots stayed healthy even in hot weather.'],
    ['name' => 'Jose Dela Cruz', 'role' => 'Civil Engineer, Baguio City', 'initials' => 'JD', 'rating' => '5.0', 'quote' => 'We used the coir geotextile rolls for slope protection and the product quality was reliable from delivery to installation.'],
    ['name' => 'Ana Santos', 'role' => 'Home Gardener, Cebu City', 'initials' => 'AS', 'rating' => '4.8', 'quote' => 'The doormat and hanging planter felt handcrafted and premium, and they matched the eco-friendly look I wanted at home.'],
];
?>

<section class="landing-shell">
    <section class="landing-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <div class="hero-copy">
                        <span class="hero-kicker">Philippine coconut coir, reimagined for modern living</span>
                        <h1 class="hero-display">Earth-first products shaped from every useful fiber.</h1>
                        <p class="hero-lead">
                            Coir Roots turns coconut husks into beautiful, practical goods for gardening,
                            construction, and everyday spaces. Shop sustainable products that support local
                            livelihoods and reduce waste at the source.
                        </p>
                        <div class="hero-actions">
                            <a href="<?php echo APP_URL; ?>/index.php?page=storefront" class="btn btn-coir btn-lg px-4">
                                Shop the Storefront
                            </a>
                            <a href="<?php echo APP_URL; ?>/index.php?page=products" class="btn btn-outline-light btn-lg px-4">
                                View Catalog
                            </a>
                        </div>
                        <div class="hero-metrics">
                            <div class="metric-card">
                                <strong><?php echo $featuredCount; ?>+</strong>
                                <span>Featured products live now</span>
                            </div>
                            <div class="metric-card">
                                <strong><?php echo $categoryCount; ?></strong>
                                <span>Core product categories</span>
                            </div>
                            <div class="metric-card">
                                <strong>100%</strong>
                                <span>Natural fiber-based materials</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-spotlight">
                        <div class="hero-orb hero-orb-one"></div>
                        <div class="hero-orb hero-orb-two"></div>
                        <div class="spotlight-panel">
                            <span class="spotlight-label">Featured pick</span>
                            <?php if ($heroProduct): ?>
                                <div class="spotlight-image-wrap">
                                    <img
                                        src="<?php echo e($heroProduct['image']); ?>"
                                        alt="<?php echo e($heroProduct['name']); ?>"
                                        class="spotlight-image"
                                    >
                                </div>
                                <div class="spotlight-body">
                                    <?php if (!empty($heroProduct['category_name'])): ?>
                                        <div class="spotlight-category"><?php echo e($heroProduct['category_name']); ?></div>
                                    <?php endif; ?>
                                    <h2><?php echo e($heroProduct['name']); ?></h2>
                                    <p><?php echo e($heroProduct['short_description'] ?: $heroProduct['description']); ?></p>
                                    <div class="spotlight-footer">
                                        <span class="spotlight-price"><?php echo formatPrice($heroProduct['price']); ?></span>
                                        <a href="<?php echo APP_URL; ?>/index.php?page=product&slug=<?php echo e($heroProduct['slug']); ?>" class="spotlight-link">
                                            See details <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="spotlight-empty">
                                    <h2>New natural favorites are on the way</h2>
                                    <p>Start with the full catalog while we update the featured collection.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-ribbon">
        <div class="container">
            <div class="ribbon-grid">
                <div class="ribbon-card">
                    <i class="bi bi-recycle"></i>
                    <div>
                        <h3>Waste becomes value</h3>
                        <p>Coconut husks are transformed into durable products instead of discarded by-products.</p>
                    </div>
                </div>
                <div class="ribbon-card">
                    <i class="bi bi-geo-alt"></i>
                    <div>
                        <h3>Grounded in the Philippines</h3>
                        <p>Product stories begin with local sourcing, local craft, and local agricultural expertise.</p>
                    </div>
                </div>
                <div class="ribbon-card">
                    <i class="bi bi-truck"></i>
                    <div>
                        <h3>Ready for retail or bulk orders</h3>
                        <p>Ideal for home gardeners, contractors, landscapers, and sustainability-minded buyers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <div class="section-intro">
                <span class="section-eyebrow">Ways To Shop</span>
                <h2>Designed for real use, not just display.</h2>
                <p>Choose products based on how you plan to use coir in daily life, projects, or commercial work.</p>
            </div>
            <div class="row g-4">
                <?php foreach ($bestUseCases as $useCase): ?>
                    <div class="col-lg-4">
                        <article class="use-card h-100">
                            <div class="use-icon">
                                <i class="bi <?php echo e($useCase['icon']); ?>"></i>
                            </div>
                            <h3><?php echo e($useCase['title']); ?></h3>
                            <p><?php echo e($useCase['copy']); ?></p>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="landing-section landing-section-soft">
        <div class="container">
            <div class="section-intro split-intro">
                <div>
                    <span class="section-eyebrow">Featured Products</span>
                    <h2>Start with customer favorites.</h2>
                </div>
                <a href="<?php echo APP_URL; ?>/index.php?page=products" class="section-link">
                    Browse all products <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <?php if (!empty($featuredProducts)): ?>
                <div class="row g-4">
                    <?php foreach ($featuredProducts as $prod): ?>
                        <div class="col-lg-4 col-md-6">
                            <?php require __DIR__ . '/partials/product_card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-panel">
                    <p class="mb-0">Featured products will appear here once the storefront is updated.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <div class="story-panel">
                <div class="story-copy">
                    <span class="section-eyebrow">From Husk To Useful</span>
                    <h2>The coir journey is simple, honest, and circular.</h2>
                    <p>
                        Coir Roots is built around the idea that sustainable materials should feel practical,
                        beautiful, and ready for everyday work. That means creating products people can trust,
                        while keeping the agricultural origin visible and meaningful.
                    </p>
                </div>
                <div class="story-steps">
                    <?php foreach ($journeySteps as $index => $item): ?>
                        <div class="journey-step">
                            <span class="journey-number">0<?php echo $index + 1; ?></span>
                            <div>
                                <h3><?php echo e($item['step']); ?></h3>
                                <p><?php echo e($item['copy']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-section landing-section-soft">
        <div class="container">
            <div class="section-intro">
                <span class="section-eyebrow">Explore Categories</span>
                <h2>Find the right coir product family.</h2>
                <p>Whether you are planting, protecting soil, or improving interiors, there is a category built around the job.</p>
            </div>
            <div class="row g-4">
                <?php
                $catIcons = ['1' => 'bi-flower2', '2' => 'bi-moisture', '3' => 'bi-house-heart', '4' => 'bi-tools', '5' => 'bi-building'];
                foreach ($categories as $cat):
                    $icon = $catIcons[$cat['id']] ?? 'bi-tag';
                ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo APP_URL; ?>/index.php?page=products&category_id=<?php echo $cat['id']; ?>" class="category-spotlight">
                            <div class="category-spotlight-icon">
                                <i class="bi <?php echo e($icon); ?>"></i>
                            </div>
                            <div>
                                <h3><?php echo e($cat['name']); ?></h3>
                                <p><?php echo e($cat['description'] ?: 'Natural coconut coir solutions for everyday use.'); ?></p>
                            </div>
                            <span class="category-spotlight-arrow"><i class="bi bi-arrow-up-right"></i></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <div class="cta-panel">
                <div>
                    <span class="section-eyebrow text-light">Ready To Order</span>
                    <h2>Support local fiber innovation with every purchase.</h2>
                    <p>Create an account to save your cart, track orders, and explore more coconut coir products across the catalog.</p>
                </div>
                <div class="cta-actions">
                    <a href="<?php echo APP_URL; ?>/index.php?page=register" class="btn btn-warning btn-lg px-4">Create Account</a>
                    <a href="<?php echo APP_URL; ?>/index.php?page=storefront" class="btn btn-outline-light btn-lg px-4">Visit Storefront</a>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-section landing-section-soft">
        <div class="container">
            <div class="section-intro">
                <span class="section-eyebrow">Customer Notes</span>
                <h2>Feedback from people putting coir to work.</h2>
            </div>
            <div class="row g-4">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="col-lg-4">
                        <article class="testimonial-slab h-100">
                            <div class="testimonial-top">
                                <span class="testimonial-score"><?php echo e($testimonial['rating']); ?>/5</span>
                                <span class="testimonial-stars">★★★★★</span>
                            </div>
                            <p><?php echo e($testimonial['quote']); ?></p>
                            <div class="testimonial-person">
                                <div class="testimonial-avatar"><?php echo e($testimonial['initials']); ?></div>
                                <div>
                                    <strong><?php echo e($testimonial['name']); ?></strong>
                                    <span><?php echo e($testimonial['role']); ?></span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</section>
