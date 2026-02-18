# Environment Configuration Guide

Panduan lengkap konfigurasi file `.env` untuk aplikasi Academic & Tech Support.

## 🔧 Konfigurasi Dasar

Setiap file `.env` harus memiliki konfigurasi berikut:

### Application Settings
```env
APP_NAME="Academic & Tech Support"
APP_ENV=production          # local, production
APP_KEY=base64:xxxxx       # Generate dengan: php artisan key:generate
APP_DEBUG=false            # false di production, true di development
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
```

## 🗄️ Database Configuration

### SQLite (Development - Default)
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### MySQL (Production - Recommended)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bantutugas
DB_USERNAME=root
DB_PASSWORD=your_password
```

## 📧 Email Configuration

### Mailtrap (Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@academictechsupport.com
MAIL_FROM_NAME="Academic & Tech Support"
```

### Gmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Academic & Tech Support"
```

## 🟢 WhatsApp Configuration

```env
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_PHONE=+62-812-3456-7890      # Ganti dengan nomor bisnis Anda
WHATSAPP_TOKEN=your_token_here
WHATSAPP_ENABLED=false                 # Set true jika sudah integrate API
```

## 💳 Payment Gateway (Future)

### Midtrans
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_IS_PRODUCTION=false           # false untuk testing
```

### Stripe
```env
STRIPE_PUBLIC_KEY=pk_test_xxxxx
STRIPE_SECRET_KEY=sk_test_xxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxx
```

## 🔐 Session & Cache

```env
SESSION_DRIVER=cookie          # file, cookie, database
SESSION_LIFETIME=120
CACHE_DRIVER=file             # file, redis, memcached
```

## 📁 File Upload

```env
FILESYSTEM_DISK=public
APP_UPLOAD_LIMIT=5242880      # 5MB in bytes
UPLOAD_EXTENSIONS=pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip
```

## 🚀 Production Checklist

Sebelum deploy ke production, pastikan:

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Gunakan MySQL (bukan SQLite)
- [ ] Setup SSL/HTTPS certificate
- [ ] Configure email settings
- [ ] Set strong APP_KEY
- [ ] Update admin password
- [ ] Enable CSRF protection
- [ ] Setup backup mechanism
- [ ] Configure logging

## 🔍 Security Notes

### ⚠️ JANGAN COMMIT `.env` ke Git!

File `.env` sudah di `.gitignore` untuk keamanan. Untuk production:

1. **Create `.env.example`** dengan template konfigurasi
2. **Copy ke server** dan isi credentials real
3. **Set permissions** 
   ```bash
   chmod 600 .env
   ```
4. **Keep credentials safe** - jangan share dengan siapapun

## 📝 Contoh File .env Lengkap

```env
# Application
APP_NAME="Academic & Tech Support"
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bantutugas_prod
DB_USERNAME=dbuser
DB_PASSWORD=strong_password_here

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=support@yourdomain.com
MAIL_PASSWORD=app_specific_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@yourdomain.com
MAIL_FROM_NAME="Academic & Tech Support"

# WhatsApp
WHATSAPP_ENABLED=false
WHATSAPP_PHONE=+62-812-3456-7890
WHATSAPP_TOKEN=your_token

# Session & Cache
SESSION_DRIVER=cookie
CACHE_DRIVER=file

# File Upload
FILESYSTEM_DISK=public
APP_UPLOAD_LIMIT=5242880
```

## 🆘 Troubleshooting

### Error: "No application encryption key has been specified"
**Solution:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General error"
**Solution:** Periksa DB credentials di `.env`

### Email tidak terkirim
**Solution:** 
- Periksa MAIL_HOST dan MAIL_PORT
- Verify email credentials
- Check firewall settings

---

**Dokumentasi lengkap:** [Laravel .env Documentation](https://laravel.com/docs/configuration)
