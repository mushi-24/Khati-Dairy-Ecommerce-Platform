# Khati Dairy Online Dairy E-Commerce System

**BAUST CSE 3200 — Web Engineering Project**  
**Technology stack (as per proposal):** Laravel · PHP · MySQL / SQLite · Laravel Blade · HTML · CSS · JavaScript

Group 06: Shaikh Ismail Zahid · Morsheda Parvin

---

## What this project implements

| Module | Features |
|--------|----------|
| **Customer** | Register, login, logout, browse/search/filter products, cart, COD checkout, order history & status tracking |
| **Admin** | Dashboard, users & roles, products, categories, shops, orders, production, distribution, inventory, employees, attendance, salary, sales/reports |
| **Manager** | Admin routes via RBAC (`admin,manager`) |
| **Employee** | Login + attendance module |
| **Shop owner** | Shop panel (`/shop-panel`) for own products/orders |
| **Auth & security** | Laravel session auth, bcrypt passwords, EnsureRole middleware, CSRF, empty seeder (no fake users) |

**Out of core scope (proposal section 8.5 future):** online payment gateway, GPS live delivery truck, mobile app.

---

## Requirements

- PHP 8.2+ (8.3 or 8.4 recommended)
- Composer 2
- MySQL 8 or SQLite
- PHP extensions: pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo

---

## Fresh install (no default users)

```bash
cd khati-dairy-laravel
composer install
cp .env.example .env
php artisan key:generate
```

### Database option A — SQLite (quickest)

In `.env` set `DB_CONNECTION=sqlite` and comment out MySQL lines, then:

```bash
touch database/database.sqlite
php artisan migrate
```

### Database option B — MySQL

```sql
CREATE DATABASE khati_dairy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Set DB_* in `.env`, then `php artisan migrate`.

### Create first admin (required — nothing is seeded)

```bash
php artisan khati:create-admin admin@khatidairy.com YourSecurePass --name="Admin"
```

### Run

```bash
php artisan serve
```

Open http://127.0.0.1:8000

---

## Accounts

| Role | How |
|------|-----|
| Customer | Sign up at /register |
| Admin | artisan khati:create-admin only |
| Manager / Employee / Shop owner | Admin panel → Users → create with role |

---

## Suggested first-run flow

1. Create admin via artisan
2. Login → Admin dashboard
3. Categories → Shops → Products
4. Optional: Employees, Production, Distribution, Inventory
5. Register as customer → cart → checkout (COD)
6. Admin → Orders → update status

---

## Roles (RBAC)

customer · admin · manager · employee · shop_owner

Middleware: `role:admin,manager` (see bootstrap/app.php and EnsureRole).

---

## Project layout

- app/Http/Controllers — Auth, shop, Admin/*
- app/Http/Middleware/EnsureRole.php — RBAC
- app/Models — User, Product, Order, Shop, Employee, Production, Distribution, Inventory, Attendance, Salary
- database/migrations — full schema
- resources/views — Blade (layouts, shop, admin, auth)
- routes/web.php — all routes

Academic project for BAUST CSE 3200. Empty seeder — no demo users or orders.


---

## Documentation

| Doc | Description |
|-----|-------------|
| [docs/DATABASE_SCHEMA.md](docs/DATABASE_SCHEMA.md) | Full table dictionary, FK, Eloquent relationship matrix, sample queries |
| [docs/LIVEWIRE_INTEGRATION.md](docs/LIVEWIRE_INTEGRATION.md) | Optional Livewire setup, ProductSearch, cart/order patterns |

### Eloquent relationships (summary)

All models under `app/Models/` define typed relations:

- **User** → shop, ownedShops, orders, employeeProfile, productionRecords, distributions
- **Product** → category, shop, orderItems, inventoryItems
- **Shop** → owner, products, orders, distributions, inventoryItems, members
- **Order** → user/customer, shop, items
- **Employee** → user, attendances, salaries
- **InventoryItem** → shop, product (+ `isLowStock()`)

See schema doc for the full matrix.


---

## Responsive shop UI (updated)

- Design system: `public/css/khati.css` (mobile → desktop, 320px–1920px)
- Layout: sticky header, mobile drawer menu, cart badge, footer
- Homepage: hero, categories, featured products, shops, why-us
- Catalog: search, category/shop filters, sort, product cards with images
- Cart & checkout (COD), order history
- Pages: About, Contact, FAQ, Privacy, Terms
- Product images: `public/images/products/*.jpg`

### Demo catalog (optional)

```bash
php artisan db:seed --class=DemoCatalogSeeder
```

Loads sample categories, 5 demo shops, and 8 products with local images. **Demo data only.**

### Requirements

- **PHP 8.3+** (Laravel 13)
- Composer, MySQL or SQLite

```bash
composer install
cp .env.example .env
php artisan key:generate
# configure DB, then:
php artisan migrate
php artisan khati:create-admin admin@khatidairy.com secret123 --name="Admin"
php artisan db:seed --class=DemoCatalogSeeder   # optional
php artisan serve
```

Open http://127.0.0.1:8000


## Product image upload
```bash
php artisan storage:link
```
Admin → Products → Edit → choose image file → Save.

## Employee login
Admin → Employees → fill form → check **Create login** → set login email/password → Save.
Employee logs in at /login → **My Profile** → sees job info, attendance, salary.

## Order payslip
After order → Order details → **Payslip / Print** → Print / Save as PDF.
