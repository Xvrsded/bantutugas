# Vercel Deploy Checklist (Laravel)

Checklist ini untuk deploy project Laravel Anda dari GitHub ke Vercel.

## 1) Pastikan repo sudah berisi konfigurasi Vercel

- `vercel.json` sudah diarahkan ke `public/index.php` dengan runtime PHP
- Script build frontend: `npm run build`

## 2) Generate nilai rahasia (lokal)

```bash
php artisan key:generate --show
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Gunakan output pertama untuk `APP_KEY`, output kedua untuk `PAYMENT_WEBHOOK_SECRET`.

## 3) Tambahkan Environment Variables di Vercel

Project Settings → Environment Variables, isi minimal:

### Core
- `APP_NAME`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY`
- `APP_URL` (domain vercel Anda)

### Database (WAJIB: jangan localhost)
- `DB_CONNECTION=mysql`
- `DB_HOST` (host database external, contoh Railway/Aiven/PlanetScale)
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

### Payment
- `PAYMENT_WEBHOOK_SECRET`
- `MIDTRANS_SERVER_KEY`
- `MIDTRANS_CLIENT_KEY`
- `MIDTRANS_IS_PRODUCTION=true`

### App tambahan
- `WHATSAPP_NUMBER`
- `WHATSAPP_DISPLAY`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`

## 4) Deploy dari GitHub

- Import repository ke Vercel
- Framework Preset: **Other**
- Build Command: `npm run build`
- Output Directory: kosongkan
- Klik Deploy

## 5) Jalankan migrasi database (sekali)

Karena Vercel tidak cocok untuk migrate interaktif berulang, jalankan dari lokal/CI ke database production:

```bash
php artisan migrate --force
```

## 6) Set Midtrans webhook URL

Di Midtrans Dashboard:

- Payment Notification URL:
  - `https://your-vercel-domain.vercel.app/payment/webhook`

## 7) Smoke test setelah deploy

Cek endpoint:
- `/`
- `/services`
- `/portfolio`
- `/checkout`
- `/login`
- `/payment/webhook` (harus 401 jika tanpa signature)

## 8) Catatan penting Vercel

- Storage lokal bersifat ephemeral; upload file production sebaiknya pakai object storage (S3/Cloudinary).
- Hindari menyimpan file penting permanen di `storage/app` pada Vercel.
