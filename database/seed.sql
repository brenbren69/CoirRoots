-- Coir Roots Seed Data
USE coir_roots_db;

-- Insert Categories
INSERT INTO categories (name, description, slug) VALUES
('Grow Media', 'High-quality coconut coir growing media for plants, hydroponics, and horticulture.', 'grow-media'),
('Erosion Control', 'Natural coir solutions for slope stabilization, erosion control, and geotechnical applications.', 'erosion-control'),
('Garden Products', 'Eco-friendly coir garden accessories including mats, planters, and decorative items.', 'garden-products'),
('Craft & Industrial', 'Natural coir rope, twine, and fiber products for crafts and industrial use.', 'craft-industrial'),
('Construction', 'Sustainable coir-based construction and insulation materials.', 'construction');

-- Insert Products (15 products)
INSERT INTO products (name, slug, description, short_description, price, stock, category_id, image, is_featured, is_new_arrival, is_trending, is_best_seller) VALUES

-- Grow Media Products
('Coir Pots Set of 5',
 'coir-pots-set-of-5',
 'A set of 5 biodegradable coir pots made from 100% natural coconut fiber. These eco-friendly pots promote healthy root growth, provide excellent aeration, and decompose naturally in soil — reducing transplant shock. Ideal for seedlings, vegetables, herbs, and indoor plants. Each pot is hand-woven by skilled artisans from the Philippines.',
 'Set of 5 biodegradable 100% natural coconut fiber pots. Perfect for seedlings and herbs.',
 150.00, 85, 1,
 'http://localhost/Coir-Roots/assets/img/products/coir-pots-set-of-5.svg',
 1, 1, 0, 0),

('Premium Coco Peat Block (5kg)',
 'premium-coco-peat-block-5kg',
 'High-quality compressed coco peat block weighing 5kg. When hydrated, it expands to approximately 70-75 liters of growing medium. Excellent water retention (up to 10x its weight), natural pH buffering, and superior aeration properties make it ideal for hydroponics, soil amendment, and potting mixes. Low EC, triple-washed for salinity removal.',
 'Premium 5kg compressed coco peat block. Expands to 70L. Low EC, triple-washed.',
 250.00, 62, 1,
 'http://localhost/Coir-Roots/assets/img/products/premium-coco-peat-block-5kg.svg',
 1, 0, 1, 0),

('Coir Grow Bags (5pcs)',
 'coir-grow-bags-5pcs',
 'Pack of 5 premium coir grow bags pre-filled with a blend of coco peat and coir fiber. These reusable grow bags offer outstanding drainage, root aeration, and moisture retention for professional-grade growing results. Perfect for tomatoes, cucumbers, capsicum, strawberries, and other high-value crops. UV-stabilized outer fabric lasts multiple growing seasons.',
 'Pack of 5 coco peat-filled grow bags. UV-stabilized, reusable, ideal for high-value crops.',
 375.00, 48, 1,
 'http://localhost/Coir-Roots/assets/img/products/coir-grow-bags-5pcs.svg',
 1, 0, 0, 1),

('Coir Fiber Grow Block',
 'coir-fiber-grow-block',
 'A compressed block made from coarse coir fiber, designed as a substrate for orchids, anthurium, and other epiphytic plants. Provides excellent air circulation and moisture management. The block can be broken apart for use in potting mixes or used whole as a growing medium. 100% organic and pH neutral.',
 'Compressed coarse coir fiber block for orchids and epiphytes. 100% organic, pH neutral.',
 199.00, 73, 1,
 'http://localhost/Coir-Roots/assets/img/products/coir-fiber-grow-block.svg',
 0, 0, 0, 0),

-- Erosion Control Products
('Erosion Control Coir Net (1m x 5m)',
 'erosion-control-coir-net-1m-x-5m',
 'Natural coir fiber erosion control net measuring 1 meter x 5 meters. Designed to prevent soil erosion on slopes, riverbanks, and disturbed land areas. The open-weave structure allows vegetation to grow through while the biodegradable coir fibers naturally decompose and enrich the soil. Tensile strength: 2.5 kN/m. Suitable for slopes up to 1:1.',
 'Natural 1m x 5m coir erosion net. Biodegradable, allows vegetation growth, suits 1:1 slopes.',
 550.00, 34, 2,
 'http://localhost/Coir-Roots/assets/img/products/erosion-control-coir-net-1m-x-5m.svg',
 1, 1, 0, 0),

('Slope Stabilization Coir Mat',
 'slope-stabilization-coir-mat',
 'Heavy-duty coir mat for slope stabilization and revegetation projects. Double-stitched with natural jute yarn for extra strength. This mat provides immediate protection against rainfall impact and runoff while supporting the establishment of permanent vegetation. Density: 400 g/m². Dimensions: 1.2m x 2.5m. Biodegrades within 2-3 years.',
 'Heavy-duty coir mat (400 g/m²) for slope stabilization. 1.2m x 2.5m, biodegrades in 2-3 years.',
 980.00, 22, 2,
 'http://localhost/Coir-Roots/assets/img/products/slope-stabilization-coir-mat.svg',
 1, 0, 1, 0),

('Coir Geotextile Roll (1m x 10m)',
 'coir-geotextile-roll-1m-x-10m',
 'Professional-grade coir geotextile roll for large-scale erosion control and civil engineering projects. Woven from high-tensile coir yarn, this geotextile provides superior ground stabilization, filtration, and drainage. Roll dimensions: 1m width x 10m length. Tensile strength: 4.0 kN/m. Ideal for road construction, retaining walls, and coastal protection.',
 'Professional 1m x 10m coir geotextile roll. 4.0 kN/m tensile strength for civil engineering.',
 1200.00, 18, 2,
 'http://localhost/Coir-Roots/assets/img/products/coir-geotextile-roll-1m-x-10m.svg',
 1, 0, 0, 1),

('Coir Sandbag / Geotextile Bag',
 'coir-sandbag-geotextile-bag',
 'Natural coir fiber sandbag designed for flood control, slope reinforcement, and erosion protection. The woven coir construction allows water to drain while retaining fill material. Sold per piece, can be filled with soil, sand, or gravel. Biodegrades naturally, eliminating costly removal. Dimensions when filled: approximately 40cm x 60cm. UV-resistant for extended outdoor use.',
 'Woven coir sandbag for flood control and erosion protection. Biodegradable, UV-resistant.',
 180.00, 95, 2,
 'http://localhost/Coir-Roots/assets/img/products/coir-sandbag-geotextile-bag.svg',
 0, 0, 0, 0),

-- Garden Products
('Coir Doormat (40x60cm)',
 'coir-doormat-40x60cm',
 'Classic natural coir doormat measuring 40cm x 60cm. Hand-tufted from thick, durable coir fiber on a natural latex backing that prevents slipping. The firm, coarse surface effectively scrapes dirt and mud from footwear. All-natural materials make this mat biodegradable and eco-friendly. Suitable for indoor and covered outdoor use. Natural fiber color with subtle texture.',
 'Classic 40x60cm hand-tufted coir doormat with natural latex backing. Durable, eco-friendly.',
 320.00, 56, 3,
 'http://localhost/Coir-Roots/assets/img/products/coir-doormat-40x60cm.svg',
 1, 0, 1, 0),

('Decorative Coir Wall Mat',
 'decorative-coir-wall-mat',
 'Handcrafted decorative coir wall mat showcasing traditional Filipino weaving patterns. Made from premium natural coir fiber with accent threads in earthy tones. Dimensions: 50cm x 80cm. Each mat is uniquely handmade by local weavers from the Bicol region of the Philippines, supporting sustainable livelihood programs. Includes hanging hooks.',
 'Handcrafted 50x80cm coir wall mat with Filipino weaving patterns. Supports local artisans.',
 450.00, 31, 3,
 'http://localhost/Coir-Roots/assets/img/products/decorative-coir-wall-mat.svg',
 1, 0, 0, 1),

('Coir Hanging Planter Basket',
 'coir-hanging-planter-basket',
 'Natural coir fiber hanging planter basket with a coconut shell decorative base. The thick coir liner retains moisture while allowing excess water to drain, creating the perfect microclimate for trailing plants like pothos, ferns, and petunias. Diameter: 25cm. Includes natural jute hanging rope (up to 60cm adjustable drop). Hand-crafted by Filipino artisans.',
 'Natural coir hanging basket with coconut shell base. 25cm diameter, adjustable jute rope.',
 280.00, 44, 3,
 'http://localhost/Coir-Roots/assets/img/products/coir-hanging-planter-basket.svg',
 1, 1, 0, 0),

('Coir Planter Box (Large)',
 'coir-planter-box-large',
 'Large rectangular coir planter box made from compressed coir fiber panels with galvanized steel frame for structural support. Dimensions: 60cm x 30cm x 25cm. The natural coir construction provides excellent insulation, keeping roots cool in hot weather. Naturally resistant to mold and fungal growth. Pre-lined with coco peat growing medium. Perfect for balcony gardens.',
 'Large 60x30x25cm coir planter box with steel frame. Insulating, mold-resistant, pre-lined.',
 890.00, 15, 3,
 'http://localhost/Coir-Roots/assets/img/products/coir-planter-box-large.svg',
 0, 0, 0, 0),

-- Craft & Industrial
('Natural Coir Rope (5mm x 10m)',
 'natural-coir-rope-5mm-x-10m',
 'Premium quality natural coir rope, 5mm diameter, 10 meters length. Three-strand twisted construction for maximum strength and durability. 100% natural coconut fiber, unbleached and chemical-free. Breaking strength: approximately 60kg. Suitable for garden use, crafts, macramé, decorative tying, and light-duty industrial applications. Naturally rough texture provides excellent grip.',
 'Natural 5mm x 10m coir rope, three-strand twisted. ~60kg break strength. Chemical-free.',
 120.00, 110, 4,
 'http://localhost/Coir-Roots/assets/img/products/natural-coir-rope-5mm-x-10m.svg',
 1, 0, 0, 1),

('Twisted Coir Twine (50m roll)',
 'twisted-coir-twine-50m-roll',
 'Fine twisted coir twine on a convenient 50-meter roll. Diameter: 2mm. Ideal for plant training and staking, bundle tying, wrapping, macramé projects, and traditional craft applications. The natural fiber texture provides a rustic aesthetic perfect for gift wrapping and event decorations. Biodegradable and compostable — safe for vegetable gardens.',
 '2mm twisted coir twine, 50m roll. Biodegradable, perfect for plant training and crafts.',
 185.00, 88, 4,
 'http://localhost/Coir-Roots/assets/img/products/twisted-coir-twine-50m-roll.svg',
 0, 0, 1, 0),

-- Construction
('Coir Fiber Insulation Board',
 'coir-fiber-insulation-board',
 'Innovative coir fiber insulation board for sustainable building construction. Made from densely compressed coir fiber bonded with natural latex. Dimensions: 120cm x 60cm x 2.5cm. Thermal conductivity (λ): 0.045 W/m·K. Sound absorption coefficient: 0.75 at 500Hz. Fire-resistant treatment applied. Suitable for wall, ceiling, and floor insulation. Contributes to green building ratings (BERDE/LEED).',
 'Coir fiber insulation board 120x60x2.5cm. λ=0.045 W/m·K. Fire-resistant, BERDE-compliant.',
 680.00, 27, 5,
 'http://localhost/Coir-Roots/assets/img/products/coir-fiber-insulation-board.svg',
 1, 1, 0, 0);

-- Insert Storefront Settings
INSERT INTO storefront_settings (section, product_ids, banner_text, is_active) VALUES
('new_arrivals', '[1, 5, 11, 15]', 'Fresh from the Farm — New Coir Products Just Arrived!', 1),
('trending', '[2, 6, 9, 14]', 'What Everyone is Buying Right Now', 1),
('best_sellers', '[3, 7, 10, 13]', 'Our Most-Loved Products — Trusted by Thousands of Filipinos', 1);

-- Note: Admin user is created by setup.php with a properly hashed password.
-- Run setup.php after importing this seed file to create the admin account.
-- Default credentials: admin@coirroots.ph / Admin@123

