# ⚡ Quick Start Guide

Panduan singkat untuk mulai menggunakan aplikasi dalam 5 menit.

## 1️⃣ Pre-Setup (Persiapan)

Pastikan sudah install:
- ✅ PHP 8.2+
- ✅ Composer
- ✅ MySQL atau SQLite

## 2️⃣ Installation (Instalasi)

```bash
# Navigate ke folder project
cd bantutugas

# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Create database dan seed data
php artisan migrate --seed
```

## 3️⃣ Run Server (Jalankan Server)

```bash
# Start development server
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 4️⃣ Access Website (Akses Website)

### Public Website
- **Homepage:** http://localhost:8000
- **Layanan:** http://localhost:8000/services
- **Harga:** http://localhost:8000/pricing
- **Portfolio:** http://localhost:8000/portfolio

### Admin Panel
- **URL:** http://localhost:8000/login
- **Email:** admin@academictechsupport.com
- **Password:** password123

## 5️⃣ Testing Features (Test Fitur)

### 📝 Test Order
1. Klik "Pemesanan" di homepage
2. Pilih salah satu layanan
3. Isi form order
4. Submit

### 📊 Admin Dashboard
1. Login ke `/login`
2. View dashboard statistics
3. Lihat daftar orders di `/admin/orders`
4. Update status order

---

## ❓ Troubleshooting

### Error: "require(routes/auth.php): Failed to open stream"
**Solution:** File `routes/auth.php` sudah di-include, tidak perlu diubah.

### Error: "SQLSTATE[HY000]: General error"
**Solution:** 
```bash
php artisan migrate:refresh --seed
```

### Port 8000 sudah terpakai?
**Solution:** Gunakan port lain
```bash
php artisan serve --port=8001
```

### Database error saat migrate?
**Solution:** Pastikan MySQL running dan credentials benar di `.env`

---

## 📚 Dokumentasi Lanjutan

- [INSTALLATION.md](INSTALLATION.md) - Instalasi detail
- [README_ACADEMY.md](README_ACADEMY.md) - Dokumentasi teknis
- [README_PROJECT.md](README_PROJECT.md) - Overview project

## 🚀 Next Steps

Setelah setup selesai, Anda bisa:

1. **Customize Content**
   - Edit homepage di `resources/views/pages/home.blade.php`
   - Update layanan di `database/seeders/DatabaseSeeder.php`
   - Ganti kontak & WhatsApp number

2. **Deploy ke Production**
   - Setup MySQL database production
   - Configure `.env` untuk production
   - Setup SSL certificate
   - Deploy ke hosting/server

3. **Add Integrations**
   - WhatsApp API
   - Payment Gateway (Midtrans/Stripe)
   - Email notifications

---

**Happy coding! 🎉**
