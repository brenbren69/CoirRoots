# Coir Roots

Coir Roots is a customer-facing and seller-facing e-commerce website for coconut coir products. The current workspace contains a Laravel installation, but the active storefront and seller dashboard run through the custom PHP entry point at `index.php`.

## Runtime

- Frontend/storefront runtime: custom PHP app served from the project root
- Supporting framework files: Laravel 12 + Breeze/Inertia scaffold
- Database used by the live app: MySQL

## Project structure

- `index.php`: main router for the storefront and seller dashboard
- `views/`: buyer and seller PHP views
- `models/`: database-backed domain models used by the custom app
- `app-config/`: app and database configuration
- `database/schema.sql`: MySQL schema
- `database/seed.sql`: starter data for products and storefront sections
- `setup.php`: database bootstrapper and seller account initializer

## Local setup

1. Make sure Apache and MySQL are running in XAMPP.
2. Confirm the project is inside `htdocs` as `Coir-Roots`.
3. Review `.env` if you need different MySQL credentials.
4. Run the setup script once:

```bash
php setup.php
```

You can also open `http://localhost/Coir-Roots/setup.php` in the browser.

## Default access

- Buyer home: `http://localhost/Coir-Roots/index.php?page=home`
- Seller login: `http://localhost/Coir-Roots/index.php?page=seller-login`
- Seller account:
  - Email: `admin@coirroots.ph`
  - Password: `Admin@123`

## Notes

- The setup script is idempotent for the seeded catalog. If products already exist, it skips re-importing seed data.
- The custom app now reads database and app values from `.env`, so `app-config/` and environment settings stay aligned.
- The Laravel `public/` app is still present, but it is not yet the runtime serving the storefront pages in `views/`.
