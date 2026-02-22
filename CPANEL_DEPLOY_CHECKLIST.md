# cPanel Deploy Checklist (Laravel)

Checklist ini dibuat untuk upload via **File Manager cPanel** agar aman dan minim error.

## 1) Persiapan Lokal (sebelum zip/upload)

Jalankan di lokal:

```bash
php artisan optimize:clear
composer install --no-dev --optimize-autoloader
```

Lalu zip project **tanpa** folder berikut:
- `.git`
- `node_modules`
- `tests` (opsional)

## 2) Upload ke cPanel

- Upload dan extract project ke folder di atas `public_html` (disarankan), contoh:
  - `/home/USERNAME/bantutugas`
- Isi `public_html` dengan isi folder `public` dari project.

## 3) Atur Document Root / index.php

Jika domain mengarah langsung ke `public_html`, ubah file `public_html/index.php` supaya menunjuk ke project asli:

```php
require __DIR__.'/../bantutugas/vendor/autoload.php';
$app = require_once __DIR__.'/../bantutugas/bootstrap/app.php';
```

> Sesuaikan `../bantutugas` dengan nama folder project Anda.

## 4) Buat .env Production

- Copy isi dari `.env.cpanel.example` menjadi `.env` di server.
- Wajib isi benar:
  - `APP_URL`
  - `DB_*`
  - `MIDTRANS_*`
  - `PAYMENT_WEBHOOK_SECRET`

## 5) Generate key + migrate

Di Terminal cPanel (atau SSH):

```bash
cd ~/bantutugas
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
```

Jika pertama kali dan butuh data awal:

```bash
php artisan db:seed --force
```

## 6) Cache untuk Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7) Permission yang aman

```bash
chmod -R 755 storage bootstrap/cache
```

> Hindari `777` jika tidak benar-benar diperlukan.

## 8) Verifikasi setelah deploy

Cek endpoint berikut:
- `/`
- `/services`
- `/portfolio`
- `/how-to-order`
- `/contact`
- `/checkout`
- `/login`

Ekspektasi:
- Halaman publik: `200`
- `/admin/dashboard`: redirect ke login jika belum login (normal)
- `/payment/webhook`: `401` tanpa signature (normal)

## 9) Midtrans Webhook (wajib untuk auto-paid)

Set di Midtrans Dashboard:
- **Payment Notification URL**: `https://yourdomain.com/payment/webhook`

Pastikan server key di `.env` sesuai mode production.

## 10) Jika ada error setelah upload

Jalankan:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Lalu cek log:

```bash
tail -n 100 storage/logs/laravel.log
```
