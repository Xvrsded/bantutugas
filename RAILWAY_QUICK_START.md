# 🚀 Railway Deployment - Quick Start

## ✅ Setup Sudah Selesai

File-file berikut sudah dibuat:
- ✅ `Procfile` - Cara menjalankan app di Railway
- ✅ `.env.production` - Production environment config
- ✅ `.railwayignore` - Files to ignore di Railway
- ✅ `RAILWAY_SETUP.md` - Detailed setup guide
- ✅ Git repository sudah siap

---

## 🔥 4 Langkah Terakhir untuk Go Live

### 1️⃣ **Create GitHub Repository** (2 menit)

```
1. Go to https://github.com/new
2. Repository name: bantutugas
3. Description: "Academic services booking platform"
4. Private or Public (pilih salah satu)
5. Klik "Create repository"
```

### 2️⃣ **Push ke GitHub** (1 menit)

Copy-paste perintah ini di PowerShell:

```powershell
cd c:\Users\62813\Downloads\bantutugas

# Ganti USERNAME dengan GitHub username kamu
git remote add origin https://github.com/USERNAME/bantutugas.git
git branch -M main
git push -u origin main
```

✅ **Selesai! Project sudah di GitHub**

---

### 3️⃣ **Deploy ke Railway** (2 menit)

```
1. Go to https://railway.app
2. Sign up with GitHub atau email
3. Klik "Create New Project"
4. Pilih "Deploy from GitHub"
5. Authorize Railway to access GitHub
6. Select repository: bantutugas
7. Railway akan auto-detect Laravel
8. Tunggu build process...
```

### 4️⃣ **Setup Database & Variables** (3 menit)

**Di Railway Dashboard:**

```
1. Klik "Create" → "MySQL"
   (Railway akan auto-generate DB variables)

2. Pergi ke "Variables" tab

3. Tambahkan:
   APP_KEY=base64:EC6MwBEixLVgQeJje4mEBkcp7GHIaHTitmYpIEGtQ4I=
   APP_ENV=production
   APP_DEBUG=false
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   LOG_CHANNEL=stack

4. MySQL variables sudah auto-ada:
   - MYSQL_HOST
   - MYSQL_PORT
   - MYSQL_USER
   - MYSQL_PASSWORD
   - MYSQL_DB
   
5. Tambahkan DB connection:
   DB_CONNECTION=mysql
   DB_HOST=${MYSQL_HOST}
   DB_PORT=${MYSQL_PORT}
   DB_DATABASE=${MYSQL_DB}
   DB_USERNAME=${MYSQL_USER}
   DB_PASSWORD=${MYSQL_PASSWORD}
```

---

## ✨ Setelah Deploy Sukses

```
✅ Dapatkan public URL (xxx.railway.app)
✅ Cek logs di Railway Dashboard
✅ Test akses website
✅ Jalankan migrations jika perlu
✅ Setup custom domain (optional)
```

---

## 📊 Checklist

- [ ] GitHub repo dibuat
- [ ] Code sudah di push ke GitHub
- [ ] Railway project dibuat
- [ ] MySQL database added
- [ ] Environment variables set
- [ ] Build successful
- [ ] Migrations running
- [ ] Website accessible
- [ ] All pages working

---

## 🎯 Hasil Akhir

**Sebelum:**
- App hanya accessible di localhost:8000
- Hanya bisa diakses dari PC kamu

**Sesudah Railway Deploy:**
- ✅ Public URL seperti: `https://bantutugas-xyz123.railway.app`
- ✅ Accessible dari mana saja di dunia
- ✅ Database terhost di Railway
- ✅ Auto-updates saat push ke GitHub
- ✅ Production-ready

---

## 💰 Cost

- **Free tier:** $5/bulan credits
- Cukup untuk:
  - 1 PHP app (≈0.5 vCPU)
  - 1 MySQL database (10GB storage)
  - 1 year usage (dengan free credits)

Setelah habis, bisa upgrade atau bayar sesuai usage.

---

## 🆘 Troubleshooting

**Build Failed?**
- Cek Railway Logs
- Pastikan Procfile ada
- Pastikan composer.json valid

**Database error?**
- Pastikan MySQL added di Railway
- Update DB_* variables
- Run migrations

**Pages not loading?**
- Cek error di Railway Logs
- Pastikan APP_KEY set
- Pastikan database connected

---

## 📚 Resources

- Railway Docs: https://docs.railway.app
- Laravel Deployment: https://laravel.com/docs/deployment
- Detailed Setup: Baca `RAILWAY_SETUP.md`

---

## 🚀 Siap?

Ikuti 4 langkah di atas dan dalam **5 menit** website kamu sudah live di internet! 🎉

