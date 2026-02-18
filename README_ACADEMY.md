# 📚 Academic & Tech Support - Website Jasa Bantuan Akademik dan Teknologi

Sebuah website Laravel fullstack profesional untuk menyediakan layanan bantuan akademik dan teknologi dengan sistem admin dashboard yang komprehensif.

## 🎯 Fitur Utama

### 📖 Layanan yang Ditawarkan
- **Layanan Akademik:**
  - Tugas SMA (Matematika, IPA, IPS)
  - Tugas Kuliah (Semua Jurusan)
  - Penulisan Makalah & Paper
  - Penulisan Skripsi
  - Penulisan Tesis & Disertasi
  - Revisi & Editing Dosen
  - Olah Data & Analisis Statistik

- **Layanan Teknis:**
  - Desain & Fabrikasi PCB
  - Proyek IoT (Arduino & ESP32)
  - Web Monitoring & Dashboard
  - Jasa Pemrograman & Development

### 🌐 Halaman Website
- **Beranda** - Landing page dengan tagline dan CTA
- **Layanan** - Daftar lengkap layanan akademik dan teknis
- **Harga** - Paket harga transparan dengan tabel detail
- **Portofolio** - Showcase proyek terbaik dengan filter kategori
- **Cara Pemesanan** - Step-by-step guide dan FAQ
- **Kontak** - Form kontak + integrasi WhatsApp
- **Disclaimer** - Syarat & ketentuan layanan pendampingan akademik

### 🔐 Admin Dashboard
- **Dashboard** - Overview statistik dan recent orders
- **Kelola Pesanan** - CRUD operations untuk orders
  - View detail pesanan
  - Update status (Pending, Accepted, In Progress, Completed, Rejected)
  - Tambah catatan internal
  - Quick links ke WhatsApp & Email klien
  - Delete pesanan

### 📋 Sistem Pesanan
- Form pemesanan terstruktur
- Upload attachment file (Max 5MB)
- Kalkulasi deadline otomatis
- Validasi data lengkap
- WhatsApp notification (siap untuk integrasi)
- Email confirmation (siap untuk integrasi)

### 🔒 Keamanan & Fitur
- Authentication system (Login/Logout)
- Admin middleware protection
- Form validation
- CSRF protection
- Database encryption ready
- File storage terorganisir

## 🏗️ Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade Templates
- **CSS Framework:** Bootstrap 5
- **Database:** MySQL
- **Authentication:** Laravel Auth
- **Icons:** Bootstrap Icons
- **Storage:** Laravel Storage System

## 📁 Struktur Project

```
bantutugas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PageController.php          (Halaman publik)
│   │   │   ├── OrderController.php         (Pesanan publik)
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php (Dashboard admin)
│   │   │       └── AdminOrderController.php (Kelola pesanan)
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Service.php                     (Model layanan)
│   │   ├── Order.php                       (Model pesanan)
│   │   └── Portfolio.php                   (Model portofolio)
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── 2025_02_18_000001_create_services_table.php
│   │   ├── 2025_02_18_000002_create_orders_table.php
│   │   └── 2025_02_18_000003_create_portfolios_table.php
│   └── seeders/
│       └── DatabaseSeeder.php              (Sample data)
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php               (Layout publik)
│   │   │   └── admin.blade.php             (Layout admin)
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── services.blade.php
│   │   │   ├── pricing.blade.php
│   │   │   ├── portfolio.blade.php
│   │   │   ├── how-to-order.blade.php
│   │   │   ├── contact.blade.php
│   │   │   └── disclaimer.blade.php
│   │   ├── order/
│   │   │   ├── create.blade.php            (Form pemesanan)
│   │   │   └── success.blade.php           (Konfirmasi sukses)
│   │   └── admin/
│   │       ├── dashboard.blade.php
│   │       └── orders/
│   │           ├── index.blade.php         (Daftar pesanan)
│   │           └── show.blade.php          (Detail pesanan)
├── routes/
│   └── web.php                             (Routing)
├── .env                                    (Environment variables)
└── README.md
```

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js (untuk aset build jika diperlukan)

### Langkah Instalasi

1. **Clone atau Extract Project**
   ```bash
   cd bantutugas
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

4. **Setup Database**
   - Edit file `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=bantutugas
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   
   - Create database:
     ```bash
     mysql -u root -p
     CREATE DATABASE bantutugas;
     ```

5. **Run Migrations & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets** (jika menggunakan CSS build)
   ```bash
   npm run dev
   # atau untuk production
   npm run build
   ```

7. **Setup Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```

   Akses aplikasi di: `http://localhost:8000`

## 👤 Kredensial Default

**Admin Account:**
- Email: `admin@academictechsupport.com`
- Password: `password123`

## 📋 Database Schema

### Services Table
```sql
id, name, category, description, icon, image, price_start, price_end, 
features (JSON), is_active, timestamps
```

### Orders Table
```sql
id, client_name, client_email, client_phone, service_id, project_title,
description, deadline, budget, attachment, status, notes, is_notified, timestamps
```

### Portfolios Table
```sql
id, title, category, description, image, client_name, project_url,
technologies (JSON), is_featured, timestamps
```

## 🔧 Konfigurasi Penting

### .env Configuration
```env
APP_NAME="Academic & Tech Support"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_DATABASE=bantutugas
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
```

## 📱 Integrasi WhatsApp

Untuk mengintegrasikan WhatsApp notification, gunakan salah satu service:
- **Twilio WhatsApp API**
- **WhatsApp Business API**
- **Baileys (Node.js)**

Edit `app/Http/Controllers/OrderController.php` method `sendWhatsAppNotification()`:

```php
private function sendWhatsAppNotification(Order $order)
{
    // Implementasi dengan WhatsApp API pilihan Anda
    // Contoh dengan Twilio:
    $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    $twilio->messages->create($order->client_phone, [
        'from' => 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER'),
        'body' => $message
    ]);
}
```

## 📧 Email Integration

Edit `config/mail.php` dan setup SMTP di `.env`:

```php
// app/Http/Controllers/OrderController.php
use Illuminate\Support\Facades\Mail;

private function sendEmailConfirmation(Order $order)
{
    Mail::send('emails.order-confirmation', ['order' => $order], 
        function($mail) use ($order) {
            $mail->to($order->client_email)->subject('Konfirmasi Pesanan');
        }
    );
}
```

## 🎨 Customization

### Mengubah Warna & Style
Edit file `resources/views/layouts/app.blade.php`:
```css
:root {
    --primary-color: #2c3e50;      /* Main color */
    --secondary-color: #e74c3c;    /* Accent color */
    --accent-color: #3498db;       /* Secondary accent */
}
```

### Menambah Layanan Baru
1. Buat entry di `services` table (via admin atau database)
2. Update `DatabaseSeeder.php` untuk sample data
3. Layanan otomatis muncul di website

### Menambah Halaman Baru
1. Create view di `resources/views/pages/nama-page.blade.php`
2. Create method di `PageController.php`
3. Add route di `routes/web.php`

## 🔐 Security Best Practices

- Change admin credentials setelah deploy
- Use HTTPS di production
- Set `APP_DEBUG=false` di production
- Regular database backups
- Update dependencies: `composer update`
- Use environment variables untuk sensitive data

## 📊 Fitur Pengembangan Lanjutan (TODO)

- [ ] Payment gateway integration (Stripe, Midtrans)
- [ ] Client login & tracking pesanan
- [ ] Email notifications otomatis
- [ ] WhatsApp notifications
- [ ] Analytics dashboard
- [ ] Reporting system
- [ ] Invoice generation
- [ ] Service review & rating
- [ ] Multi-language support
- [ ] Mobile app

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Migrations table not found"
```bash
php artisan migrate:install
php artisan migrate
```

### Permission denied storage folder
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### MySQL connection error
- Pastikan MySQL service running
- Cek credentials di `.env`
- Cek database sudah dibuat

## 📞 Support & Contact

Untuk bantuan dalam mengembangkan project ini lebih lanjut:
- WhatsApp: +62 812-3456-7890
- Email: support@academictechsupport.com

## 📄 License

MIT License - Bebas digunakan dan dimodifikasi

## 🙏 Disclaimer

Layanan ini adalah layanan **pendampingan akademik dan konsultasi teknis**, bukan layanan penggantian kerja. Pengguna bertanggung jawab menggunakan hasil sesuai dengan peraturan institusi dan etika akademik.

---

**Dibuat dengan ❤️ menggunakan Laravel**

Version: 1.0.0  
Last Updated: 18 Feb 2026
