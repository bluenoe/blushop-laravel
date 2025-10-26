# BluShop (Laravel 11) — Mini E-commerce in 5 Days

**Repo:** `blushop-laravel`  
**Description:** A 5-day Laravel mini e-commerce for students: products, cart (session), auth (Breeze), checkout (fake success), contact messages DB.  
**License:** MIT

## Features Checklist
- [x] Home: product list with image + price (Day 2)
- [x] Product detail page `/product/{id}` (Day 3)
- [x] Cart (Session) — add / update / remove / clear (Day 3)
- [x] Auth via Laravel Breeze (Blade) — register/login/logout (Day 4)
- [x] Checkout (auth-only): summary + Place Order → success page + clear cart (Day 4)
- [x] Contact: form saves to `contact_messages` (no SMTP) + success flash (Day 5)
- [x] Basic navbar (Home | Cart | Contact | Login/Logout | Register) (Day 1 → Day 4)
- [x] Bootstrap 5 (CDN), clean MVC, validated requests, CSRF on POST

## Tech Stack
- Laravel 11, PHP 8.2+
- MySQL/MariaDB
- Node 20+ (Vite for Breeze assets)
- Bootstrap 5 (CDN)

## Setup & Run
```bash
composer install
cp .env.example .env
# chỉnh DB_* trong .env cho MySQL của bạn
php artisan key:generate

# tạo DB thủ công: blushop_db
php artisan migrate

# (tuỳ chọn) seed sản phẩm demo:
php artisan db:seed --class=Database\\Seeders\\ProductSeeder

# Breeze (nếu chưa cài):
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev

php artisan serve
.env (DB)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blushop_db
DB_USERNAME=root
DB_PASSWORD=your_password_here

Database Schema

products

id (PK)

name (string)

description (text, nullable)

price (decimal 8,2)

image (string)

created_at, updated_at

contact_messages

id (PK)

name (string)

email (string)

message (text)

created_at (timestamp)

users (from Breeze)

id, name, email, password, remember_token, timestamps, … (mặc định của Laravel)

Screenshots (suggested)

screenshots/day2-home-grid.png — Homepage product grid

screenshots/day3-cart.png — Cart page

screenshots/day4-login.png — Breeze login

screenshots/day4-checkout-summary.png — Checkout summary

screenshots/day4-checkout-success.png — Order success

screenshots/day5-contact.png — Contact form (success flash)

Routes Table
Method	Path	Controller@Action	Middleware
GET	/	ProductController@index	web
GET	/product/{id}	ProductController@show	web
GET	/cart	CartController@index	web
POST	/cart/add/{id}	CartController@add	web
POST	/cart/update/{id}	CartController@update	web
POST	/cart/remove/{id}	CartController@remove	web
POST	/cart/clear	CartController@clear	web
GET	/checkout	CheckoutController@index	auth
POST	/checkout/place	CheckoutController@place	auth
GET	/contact	ContactController@index	web
POST	/contact	ContactController@send	web
GET	/login	(Breeze)	guest
GET	/register	(Breeze)	guest
POST	/logout	(Breeze)	auth
Notes & Quality

Validate tất cả input (qty tối thiểu 1, contact min length, …).

Không trust dữ liệu client: luôn tính tổng server-side.

findOrFail cho product detail.

CSRF sẵn trong mọi form Blade với @csrf.

UX: flash messages, badge giỏ hàng, disable nút khi giỏ trống (checkout link đã xử lý).

Ảnh demo: đặt vào public/images/sample1.jpg, sample2.jpg, sample3.jpg.

Next Steps

Admin CRUD for products (Filament/Nova hoặc manual).

Search + pagination cho product list.

Order persistence (bảng orders, order_items).

Discount codes, shipping fee, tax.

Livewire/Alpine interactivity (update qty inline).

Upload ảnh sản phẩm & storage disks.