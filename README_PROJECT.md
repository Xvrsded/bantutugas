# 🎓 Platform Layanan Akademik & Teknologi (Academic & Tech Support Service)

Platform profesional berbasis **Laravel 12** untuk layanan pendampingan akademik dan konsultasi teknologi. Website ini dirancang untuk memudahkan klien dalam pemesanan jasa serta memberikan admin dashboard yang komprehensif untuk mengelola pesanan.

## 🌟 Fitur Utama

### 📱 Untuk Klien (Public Pages)
- **Homepage** - Landing page dengan hero section dan featured services
- **Halaman Layanan** - Daftar 11 layanan yang tersedia (7 akademik + 4 teknologi)
- **Halaman Harga** - Paket pricing transparan dengan range harga untuk setiap layanan
- **Portfolio** - Showcase proyek-proyek yang telah selesai dengan kategori
- **Cara Pemesanan** - Panduan lengkap 6 langkah untuk memesan layanan
- **Halaman Kontak** - Form kontak + integrasi WhatsApp + business hours
- **Disclaimer** - Penjelasan legal tentang layanan pendampingan akademik
- **Form Pemesanan** - Form detail untuk submit order dengan upload file

### 🔐 Admin Dashboard
- **Dashboard Statistics** - KPI overview dengan 7 stat cards
- **Manajemen Orders** - CRUD lengkap untuk pesanan klien
- **Status Tracking** - Update status order (pending, accepted, in_progress, completed, rejected)
- **Order Details** - Lihat detail order lengkap dengan attachment
- **Export Ready** - Data siap untuk dianalisis

## 🛠️ Stack Teknologi

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 12 |
| **Frontend** | Blade Templates + Bootstrap 5.3 |
| **Database** | SQLite (development) / MySQL (production) |
| **Authentication** | Laravel Built-in Auth |
| **CSS Framework** | Bootstrap 5.3 + Bootstrap Icons |
| **Server** | PHP 8.2+ |

## 📦 Instalasi & Setup

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL/SQLite

### Step-by-Step Installation

1. **Clone atau Extract Project**
```bash
cd bantutugas
```

2. **Install Dependencies**
```bash
composer install
```

3. **Generate Application Key**
```bash
php artisan key:generate
```

4. **Setup Database**
```bash
php artisan migrate --seed
```

5. **Jalankan Development Server**
```bash
php artisan serve
```

6. **Akses Website**
- Public: `http://localhost:8000`
- Admin: `http://localhost:8000/login`

## 👤 Akun Demo

**Admin Account:**
- Email: `admin@academictechsupport.com`
- Password: `password123`

> ⚠️ **PENTING**: Ubah password di production!

## 📚 Struktur Database

### Services Table
| Field | Type | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| name | VARCHAR | Nama layanan |
| category | ENUM | Kategori (academic-sma, tech-pcb, dll) |
| description | TEXT | Deskripsi layanan |
| price_start | INT | Harga mulai |
| price_end | INT | Harga maksimal |
| features | JSON | List fitur |
| is_active | BOOLEAN | Status aktif |

### Orders Table
| Field | Type | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| client_name | VARCHAR | Nama klien |
| client_email | VARCHAR | Email klien |
| client_phone | VARCHAR | Nomor telepon |
| service_id | INT FK | Referensi ke Services |
| project_title | VARCHAR | Judul proyek |
| description | TEXT | Deskripsi detail |
| deadline | DATE | Deadline pengerjaan |
| budget | INT | Budget klien |
| attachment | VARCHAR | File upload |
| status | ENUM | pending, accepted, in_progress, completed, rejected |
| notes | TEXT | Internal notes admin |
| is_notified | BOOLEAN | WhatsApp notified |

### Portfolios Table
| Field | Type | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| title | VARCHAR | Judul proyek |
| category | VARCHAR | Kategori proyek |
| description | TEXT | Deskripsi detail |
| technologies | JSON | Tech stack yang digunakan |
| client_name | VARCHAR | Nama klien |
| is_featured | BOOLEAN | Tampil di homepage |

## 🎨 Layanan yang Tersedia

### 📖 Layanan Akademik (7 Services)
1. **Tugas SMA** - Rp50k - Rp200k
2. **Tugas Kuliah** - Rp75k - Rp500k
3. **Penulisan Makalah** - Rp150k - Rp1jt
4. **Penulisan Skripsi** - Rp500k - Rp5jt
5. **Penulisan Tesis** - Rp2jt - Rp10jt
6. **Revisi & Editing** - Rp100k - Rp800k
7. **Olah Data Statistik** - Rp200k - Rp2jt

### 💻 Layanan Teknologi (4 Services)
1. **Desain PCB** - Rp300k - Rp3jt
2. **Proyek IoT** - Rp500k - Rp5jt
3. **Web Monitoring** - Rp1jt - Rp10jt
4. **Jasa Pemrograman** - Rp1.5jt - Rp20jt

## 🗂️ Struktur Folder

```
bantutugas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PageController.php
│   │   │   ├── OrderController.php
│   │   │   ├── Auth/
│   │   │   └── Admin/
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Service.php
│   │   ├── Order.php
│   │   ├── Portfolio.php
│   │   └── User.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── pages/
│   │   ├── admin/
│   │   ├── order/
│   │   └── auth/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── auth.php
└── public/
```

## 📍 Routes & Endpoints

### Public Routes
```
GET  /                          → Homepage
GET  /services                  → Halaman Layanan
GET  /pricing                   → Halaman Harga
GET  /portfolio                 → Halaman Portfolio
GET  /how-to-order              → Cara Pemesanan
GET  /contact                   → Kontak
GET  /disclaimer                → Disclaimer
POST /contact                   → Submit Contact Form
```

### Order Routes
```
GET  /order/create/{service}    → Form Order
POST /order                     → Store Order
GET  /order/success/{order}     → Konfirmasi Sukses
```

### Admin Routes (Protected by Auth)
```
GET  /login                     → Login Page
POST /login                     → Process Login
GET  /admin/dashboard           → Admin Dashboard
GET  /admin/orders              → Daftar Orders
GET  /admin/orders/{order}      → Detail Order
PUT  /admin/orders/{order}/status → Update Status
DELETE /admin/orders/{order}    → Delete Order
POST /logout                    → Logout
```

## 🚀 Deployment ke Production

### Server Requirements
- PHP 8.2+
- MySQL 5.7+
- Composer

### Steps Deployment
1. Clone repository ke server
2. Run `composer install --optimize-autoloader`
3. Setup `.env` dengan production config
4. Run `php artisan key:generate`
5. Run `php artisan migrate --force`
6. Configure web server (Apache/Nginx)
7. Setup SSL certificate
8. Enable storage symlink: `php artisan storage:link`

## 📱 Future Enhancements

- [ ] Integrasi Payment Gateway (Midtrans/Stripe)
- [ ] WhatsApp API Integration
- [ ] Email Notification System
- [ ] Client Login & Tracking
- [ ] Rating & Review System
- [ ] Multi-language Support
- [ ] SMS Notifications
- [ ] Advanced Analytics
- [ ] Invoice Generator
- [ ] Recurring Services

## 🔒 Security Notes

- Semua admin routes protected dengan middleware auth
- Form validation lengkap untuk semua input
- CSRF protection enabled
- File upload size limited (5MB max)
- Password hashing dengan bcrypt

## ⚙️ Configuration

### Important .env Variables
```
APP_NAME="Academic & Tech Support"
APP_URL=http://localhost:8000
APP_LOCALE=id

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465

WHATSAPP_PHONE=+62-812-3456-7890
```

## 📖 Dokumentasi Lengkap

- Lihat [INSTALLATION.md](INSTALLATION.md) untuk panduan instalasi detail
- Lihat [README_ACADEMY.md](README_ACADEMY.md) untuk dokumentasi teknis lengkap
- Lihat [PROJECT_CHECKLIST.md](PROJECT_CHECKLIST.md) untuk feature checklist

## 🤝 Support & Contact

- Email: support@academictechsupport.com
- WhatsApp: +62-812-3456-7890
- Business Hours: Senin-Jumat 09:00-17:00 WIB

## 📄 License

Project ini adalah property akademik/profesional. Semua hak cipta terlindungi.

---

**Dibuat dengan ❤️ menggunakan Laravel**  
Siap untuk dikembangkan lebih lanjut dengan fitur payment, multi-language, dan sistem client login!
