# Installation Guide - Academic & Tech Support

## Panduan Instalasi Lengkap untuk Windows (XAMPP)

### Step 1: Persiapan Awal
1. Pastikan XAMPP sudah terinstall dengan MySQL running
2. Buka PowerShell atau Command Prompt
3. Navigate ke folder project:
   ```
   cd c:\Users\62813\Downloads\bantutugas
   ```

### Step 2: Tunggu Composer Selesai
Composer masih sedang menginstall dependencies. Tunggu hingga selesai (bisa memakan waktu 10-30 menit tergantung internet).

### Step 3: Setelah Composer Selesai
1. Generate APP_KEY:
   ```bash
   php artisan key:generate
   ```

2. Setup Database MySQL:
   ```bash
   # Buka MySQL command line atau gunakan phpMyAdmin
   CREATE DATABASE bantutugas;
   ```

3. Update file `.env` (sudah ada, tapi pastikan):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bantutugas
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Run Migrations:
   ```bash
   php artisan migrate
   ```

5. Seed Database (optional, untuk sample data):
   ```bash
   php artisan db:seed
   ```

6. Setup Storage Link:
   ```bash
   php artisan storage:link
   ```

### Step 4: Jalankan Development Server
```bash
php artisan serve
```

Aplikasi akan tersedia di: `http://localhost:8000`

### Step 5: Login Admin
- URL: `http://localhost:8000/login`
- Email: `admin@academictechsupport.com`
- Password: `password123`

### Step 6: Update Password Admin
Setelah login pertama kali, segera ubah password di `/admin/profile` atau via database.

## Troubleshooting

### "vendor not found"
- Tunggu composer finish running
- Atau manual run: `composer install`

### "Database connection error"
- Pastikan MySQL running
- Check DB credentials di `.env`
- Run: `php artisan migrate:install`

### "Port 8000 already in use"
- Run di port lain: `php artisan serve --port=8001`

### "Storage permission error"
- Run di PowerShell as Administrator
- Atau: `php artisan storage:link --force`

### "Migration table not found"
```bash
php artisan migrate:install
php artisan migrate
```

## File-file Penting yang Sudah Dibuat

✅ Models:
- `app/Models/Service.php`
- `app/Models/Order.php`
- `app/Models/Portfolio.php`

✅ Controllers:
- `app/Http/Controllers/PageController.php`
- `app/Http/Controllers/OrderController.php`
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/AdminOrderController.php`

✅ Migrations:
- `database/migrations/2025_02_18_000001_create_services_table.php`
- `database/migrations/2025_02_18_000002_create_orders_table.php`
- `database/migrations/2025_02_18_000003_create_portfolios_table.php`

✅ Views (Blade Templates):
- Layout: `resources/views/layouts/app.blade.php`, `admin.blade.php`
- Pages: home, services, pricing, portfolio, how-to-order, contact, disclaimer
- Order: create, success
- Admin: dashboard, orders/index, orders/show

✅ Routes:
- `routes/web.php` - Semua routes sudah dikonfigurasi

✅ Database:
- `database/seeders/DatabaseSeeder.php` - Sample data

✅ Documentation:
- `README_ACADEMY.md` - Full documentation

## Struktur Folder Project

```
bantutugas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PageController.php
│   │   │   ├── OrderController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       └── AdminOrderController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Service.php
│   │   ├── Order.php
│   │   └── Portfolio.php
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── ...create_services_table.php
│   │   ├── ...create_orders_table.php
│   │   └── ...create_portfolios_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── admin.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── services.blade.php
│   │   │   ├── pricing.blade.php
│   │   │   ├── portfolio.blade.php
│   │   │   ├── how-to-order.blade.php
│   │   │   ├── contact.blade.php
│   │   │   └── disclaimer.blade.php
│   │   ├── order/
│   │   │   ├── create.blade.php
│   │   │   └── success.blade.php
│   │   └── admin/
│   │       ├── dashboard.blade.php
│   │       └── orders/
│   │           ├── index.blade.php
│   │           └── show.blade.php
├── routes/
│   ├── web.php
│   └── auth.php (default Laravel)
├── .env
├── .env.example
└── README_ACADEMY.md
```

## Fitur yang Sudah Siap

✅ Homepage dengan CTA
✅ Daftar Layanan (11 layanan akademik & teknis)
✅ Halaman Harga dengan tabel
✅ Halaman Portofolio dengan filter
✅ Halaman Cara Pemesanan dengan step-by-step guide
✅ Halaman Kontak dengan form
✅ Disclaimer page
✅ Admin Dashboard dengan statistik
✅ Order Management System
✅ Responsive Design (Bootstrap 5)
✅ Professional UI/UX
✅ Database schema lengkap
✅ Authentication system
✅ File upload system

## Fitur Pengembangan Lanjut (Next Phase)

⏳ Payment Gateway Integration (Stripe/Midtrans)
⏳ WhatsApp API Integration
⏳ Email Notifications
⏳ Client Login System
⏳ Order Tracking
⏳ Invoice Generation
⏳ Analytics Dashboard
⏳ Review & Rating System
⏳ Multi-language Support

## Next Steps

1. Selesaikan composer install
2. Setup database
3. Run migrations & seeding
4. Test website di browser
5. Customize data dan konten
6. Deploy ke production

Untuk pertanyaan atau bantuan lebih lanjut, hubungi tim development!
