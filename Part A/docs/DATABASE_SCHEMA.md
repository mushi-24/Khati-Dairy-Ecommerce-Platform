# Khati Dairy — Detailed Database Schema Documentation

**Project:** Khati Dairy Online Dairy E-Commerce System  
**ORM:** Laravel Eloquent  
**DBMS:** MySQL 8 / SQLite  

---

## 1. Entity–Relationship overview

```
users ──hasMany──► orders ──hasMany──► order_items ──belongsTo──► products
  │                  │
  │                  └──belongsTo──► shops
  ├──belongsTo──► shops (shop_id)
  ├──hasMany──► shops (owner_id)
  ├──hasOne──► employees
  └──hasMany──► production_records / distributions (recorded_by)

categories ──hasMany──► products ──belongsTo──► shops
shops ──hasMany──► products, orders, distributions, inventory_items
employees ──hasMany──► attendances, salaries
inventory_items ──belongsTo──► products, shops
```

---

## 2. Tables

### 2.1 users
| Column | Type | Notes |
|--------|------|-------|
| id | BIGINT PK | |
| name | VARCHAR | |
| email | VARCHAR UNIQUE | Login |
| password | VARCHAR | bcrypt via Eloquent cast |
| role | VARCHAR(32) default customer | customer, admin, manager, employee, shop_owner |
| phone | VARCHAR(30) nullable | |
| shop_id | FK shops nullable | Member shop |
| is_active | BOOLEAN default true | |
| timestamps | | |

**Eloquent (User):** shop(), ownedShops(), orders(), employeeProfile(), productionRecords(), distributions()

### 2.2 categories
name, slug UNIQUE, description, image, is_active  
**Eloquent:** products(), activeProducts()

### 2.3 shops
name, slug UNIQUE, owner_id → users, phone, email, address, city, description, image, is_verified, status ENUM(pending,active,suspended)  
**Eloquent:** owner(), products(), orders(), distributions(), inventoryItems(), members()

### 2.4 products
category_id → categories CASCADE, shop_id → shops NULL, name, slug UNIQUE, description, price DECIMAL(10,2), unit, stock INT, image, status ENUM(active,inactive,out_of_stock)  
**Eloquent:** category(), shop(), orderItems(), inventoryItems(), isAvailable()

### 2.5 orders
order_number UNIQUE, user_id → users, shop_id → shops, customer_name/phone/email (snapshot), shipping_address, subtotal, delivery_fee, total, payment_method, status ENUM(pending…delivered,cancelled), notes, delivered_at  
**Eloquent:** user(), customer(), shop(), items()

### 2.6 order_items
order_id CASCADE, product_id NULL, product_name (snapshot), price, quantity, line_total  
**Eloquent:** order(), product()

### 2.7 production_records
product_name, quantity DECIMAL(12,2), unit, production_date, batch_reference, notes, recorded_by → users  
**Eloquent:** recorder()

### 2.8 distributions
product_name, shop_id → shops, quantity, unit, distribution_date, remaining_farm_stock, notes, recorded_by → users  
**Eloquent:** shop(), recorder()

### 2.9 inventory_items
location_type ENUM(farm,shop,online), shop_id, product_id, product_name, quantity, unit, low_threshold  
**Eloquent:** shop(), product(), isLowStock()

### 2.10 employees
employee_id UNIQUE, name, phone, email, position, department, joining_date, salary, status ENUM(active,inactive,on_leave), user_id → users, address  
**Eloquent:** user(), attendances(), salaries()

### 2.11 attendances
employee_id CASCADE, date, status ENUM(present,absent,late,leave), check_in, check_out, note  
UNIQUE(employee_id, date)  
**Eloquent:** employee()

### 2.12 salaries
employee_id CASCADE, month (YYYY-MM), basic_salary, days_*, bonus, deduction, net_salary, payment_date, payment_status, note  
**Eloquent:** employee()

### Framework: password_reset_tokens, sessions, cache, jobs

---

## 3. Relationship matrix

| From | To | Type | Method |
|------|-----|------|--------|
| User | Order | 1:N | orders() |
| User | Shop | 1:N owned | ownedShops() |
| User | Shop | N:1 member | shop() |
| User | Employee | 1:1 | employeeProfile() |
| Category | Product | 1:N | products() |
| Shop | Product | 1:N | products() |
| Order | OrderItem | 1:N | items() |
| Product | OrderItem | 1:N | orderItems() |
| Employee | Attendance | 1:N | attendances() |
| Employee | Salary | 1:N | salaries() |
| Shop | Distribution | 1:N | distributions() |

---

## 4. Design notes

1. Money = DECIMAL never float.
2. Order line stores product_name/price snapshot for history.
3. Cart is session-only until checkout.
4. RBAC via users.role + EnsureRole middleware (no separate permissions table).
5. Cascade: category→products, order→items, employee→attendance/salary.

## 5. Sample Eloquent usage

```php
Order::with(["items.product", "shop"])->where("user_id", auth()->id())->latest()->get();
Product::with(["category", "shop"])->where("status", "active")->paginate(12);
$employee->attendances()->whereMonth("date", now()->month)->get();
InventoryItem::with(["shop", "product"])->get()->filter->isLowStock();
```

Migrations: `php artisan migrate`
