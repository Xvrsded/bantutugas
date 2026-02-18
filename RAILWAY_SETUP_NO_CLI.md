# 🚀 Railway Setup - SIMPLE STEPS (No CLI Needed!)

## ✅ Status Saat Ini:

✅ Project sudah dibuat di Railway  
✅ Web service sudah "Completed"  
❌ MySQL belum ditambah  
❌ Environment variables belum di-set  

---

## 🎯 4 STEP MUDAH UNTUK GO LIVE

### **STEP 1: Tambah MySQL Database** (3 menit)

**Buka:** https://railway.app/dashboard

**Di Dashboard:**
```
1. Lihat project "tranquil-enjoyment"
2. Di sidebar kiri, ada button "+"
3. Klik "+"
4. Pilih "MySQL" dari list
5. Tunggu ~10 detik
```

Setelah berhasil:
- Database MySQL muncul di Architecture
- Railway auto-generate variables: MYSQL_HOST, MYSQL_PORT, etc

**Checkpoint:** Ada 2 services sekarang?
- ✅ web
- ✅ mysql

---

### **STEP 2: Set Environment Variables** (5 menit)

**Di Railway Dashboard:**

```
1. Klik service "web" (bukan mysql)
2. Cari tab "Variables" atau "Environment"
3. Akan ada button "+ Add Variable" atau "Edit"
```

**Copy-paste 13 variables ini satu-satu:**

| No. | Nama | Value |
|-----|------|-------|
| 1 | APP_KEY | `base64:EC6MwBEixLVgQeJje4mEBkcp7GHIaHTitmYpIEGtQ4I=` |
| 2 | APP_ENV | `production` |
| 3 | APP_DEBUG | `false` |
| 4 | CACHE_DRIVER | `file` |
| 5 | SESSION_DRIVER | `file` |
| 6 | QUEUE_CONNECTION | `sync` |
| 7 | LOG_CHANNEL | `stack` |
| 8 | DB_CONNECTION | `mysql` |
| 9 | DB_HOST | `${MYSQL_HOST}` |
| 10 | DB_PORT | `${MYSQL_PORT}` |
| 11 | DB_DATABASE | `${MYSQL_DB}` |
| 12 | DB_USERNAME | `${MYSQL_USER}` |
| 13 | DB_PASSWORD | `${MYSQL_PASSWORD}` |

**Cara input:**

Untuk setiap variable:
```
1. Klik "+ Add Variable"
2. Input name (contoh: "APP_KEY")
3. Input value (contoh: "base64:EC6MwBEixLVgQeJje4mEBkcp7GHIaHTitmYpIEGtQ4I=")
4. Klik "Add" atau "Save"
5. Ulangi untuk variable berikutnya
```

**Checkpoint:** Semua 13 variables sudah di-input?

---

### **STEP 3: Redeploy** (2 menit)

Setelah semua variables di-input:

```
1. Cari button "Redeploy" atau "Deploy" (biasanya di atas)
2. Klik button tersebut
3. Tunggu ~1-2 menit
4. Status berubah menjadi "Completed" (hijau)
```

**Checkpoint:** Status "Completed"?

---

### **STEP 4: Run Database Migrations** (3 menit)

Railway perlu membuat database tables. Ada 2 cara:

#### **Cara A: Via PowerShell Lokal (Paling Mudah)**

Di PowerShell, jalankan:

```powershell
cd c:\Users\62813\Downloads\bantutugas
npx railway run php artisan migrate:fresh --seed
```

Tunggu sampai selesai. Akan ada output seperti:
```
Migration: ... created
Seeding: ... seeded
Database seeding completed successfully.
```

#### **Cara B: Via Railway Logs (Alternative)**

Jika Cara A tidak bekerja:

```
1. Di Railway, klik service "web"
2. Tab "Logs"
3. Cari input command box
4. Input: php artisan migrate:fresh --seed
5. Enter & tunggu
```

**Checkpoint:** Migrations selesai?

---

### **STEP 5: Get Public URL & Test** (1 menit)

```
1. Di Railway, klik service "web"
2. Lihat "Deployment" atau di bagian atas
3. Cari "Public URL" (format: https://xxxx-xxxx.railway.app)
4. Copy URL tersebut
5. Buka di browser
```

**Test:** Buka halaman-halaman berikut:
- https://xxxx-xxxx.railway.app/ (Home)
- https://xxxx-xxxx.railway.app/services (Services)
- https://xxxx-xxxx.railway.app/portfolio (Portfolio)
- https://xxxx-xxxx.railway.app/contact (Contact)

Semua halaman harus loading! ✅

---

## 📋 Checklist Sebelum Go Live

```
STEP 1: MySQL Database
☐ MySQL service ditambah
☐ MySQL status "Running" atau "Completed"

STEP 2: Environment Variables
☐ APP_KEY di-set
☐ APP_ENV = production
☐ APP_DEBUG = false
☐ Cache/Session drivers di-set
☐ Database variables di-set (DB_HOST, DB_DATABASE, dll)
☐ Semua 13 variables ada

STEP 3: Redeploy
☐ Redeploy di-klik
☐ Web service status "Completed"

STEP 4: Migrations
☐ Migration command di-run
☐ Database tables dibuat
☐ Seeding berhasil

STEP 5: Testing
☐ Public URL bisa di-akses
☐ Home page loading
☐ Services page loading
☐ Portfolio page loading
☐ Contact page loading
☐ Checkout page loading
```

---

## 🆘 Troubleshooting

### ❌ Kalau Error di Migration:

**Error: "SQLSTATE[HY000]: General error"**
```
Solusi:
1. Pastikan MySQL service "Running" di Railway
2. Pastikan DB_* variables correct
3. Coba redeploy ulang
4. Coba migration ulang: npx railway run php artisan migrate:fresh --seed
```

### ❌ Kalau Website Error 500:

**Solusi:**
```
1. Di Railway, klik service "web"
2. Tab "Logs"
3. Lihat error message
4. Copy error, google solution
5. Update code jika perlu, push ke GitHub
6. Railway auto-redeploy
```

### ❌ Kalau Public URL tidak accessible:

**Solusi:**
```
1. Pastikan web service status "Running"
2. Tunggu 30 detik, coba refresh
3. Pastikan deployment sukses (Completed)
4. Cek Logs untuk error
```

---

## 💡 Pro Tips

1. **Railway auto-redeploy** saat kamu push ke GitHub
   - Jadi cukup edit code, push, dan Railway otomatis deploy

2. **Logs adalah teman terbaik**
   - Semua error bisa dilihat di Tab "Logs"
   - Gunakan untuk troubleshoot

3. **Variables bersifat sensitive**
   - Jangan commit `.env` file ke GitHub
   - Railway variables di-manage secara aman

4. **Database auto-backup**
   - Railway include daily database backups
   - Data aman!

---

## ⏱️ Total Waktu

| Step | Time |
|------|------|
| 1. Tambah MySQL | 3 menit |
| 2. Set Variables | 5 menit |
| 3. Redeploy | 2 menit |
| 4. Migrations | 3 menit |
| 5. Test | 1 menit |
| **TOTAL** | **14 menit** |

---

## 🎉 Setelah Selesai

Kamu akan punya:

✅ Website live di internet  
✅ Database running di cloud  
✅ Auto-deploy dari GitHub  
✅ Public URL untuk dibagikan  
✅ HTTPS secure connection  
✅ Professional hosting  

---

## 📞 Need Help?

Kalau stuck di salah satu step:

1. **Screenshot** halaman Railway kamu
2. **Laporkan** step mana yang error
3. Saya akan **guide** dengan specific steps

Good luck! 🚀

