# BluShop (Laravel 11)

**Repo name:** `blushop-laravel`  
**Description:** A 5-day Laravel mini e-commerce for students: products, cart (session), auth (Breeze), checkout, contact DB.  
**License:** MIT

## Tech Stack

- Laravel 11, PHP 8.2+
- MySQL (hoặc MariaDB)
- Node 20+ (Vite sẽ dùng khi cài Breeze ở Day 4)
- Bootstrap 5 (CDN)

## Project Scope (Tổng quan)

- Trang chủ hiển thị danh sách sản phẩm (Day 2).
- Trang chi tiết sản phẩm `/product/{id}` (Day 3).
- Cart dùng Session: add/update/remove/clear (Day 3).
- Checkout (chỉ cho user đã login) + fake success (Day 4).
- Auth bằng Laravel Breeze (Day 4).
- Contact page lưu message vào DB (Day 5).

## Requirements

- PHP 8.2+, Composer
- MySQL/MariaDB đang chạy
- Node 20+ (sẽ dùng Day 4)

## Setup (Day 1)

```bash
composer create-project laravel/laravel blushop-laravel
cd blushop-laravel
cp .env.example .env
# Tạo DB trước: blushop_db
php artisan key:generate
php artisan serve
```

.env Notes (MySQL)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blushop_db
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Day 1 Status

- Base layout + navbar + footer (Bootstrap CDN).
- Routes skeleton (home, product, cart, checkout, contact) với placeholder 501.
- Dev server hoạt động.

### Next Days

- Day 2: Migrations, seeders, Product list grid.
- Day 3: Product detail + Cart (Session).
- Day 4: Breeze Auth + Checkout flow.
- Day 5: Contact messages DB + polish UI + final docs.

## Day 3 — Product Detail + Session Cart

### Cart data shape (session)
```php
// session('cart')
[
  $productId => [
    'name' => string,
    'price' => float,   // lưu số để tính toán
    'quantity' => int,  // >= 1
    'image' => string,  // tên file ảnh trong public/images
  ],
  // ...
]
Routes (Cart)
Method	Path	Controller@action	Purpose
GET	/cart	CartController@index	Xem giỏ hàng
POST	/cart/add/{id}	CartController@add	Thêm sản phẩm (qty default 1)
POST	/cart/update/{id}	CartController@update	Cập nhật quantity
POST	/cart/remove/{id}	CartController@remove	Xoá 1 item
POST	/cart/clear	CartController@clear	Xoá toàn bộ giỏ

Product detail
Method	Path	Controller@action
GET	/product/{id}	ProductController@show

Ghi chú:

Tất cả POST form đều kèm @csrf.

Validate số lượng min:1.

Dùng findOrFail($id) cho truy vấn sản phẩm.