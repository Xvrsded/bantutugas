# 🚀 Railway Deployment Guide

## Step-by-Step Setup untuk Railway

### 1️⃣ **Push Repository ke GitHub**

```powershell
# Setup git config (jika belum)
git config --global user.name "Your Name"
git config --global user.email "your@email.com"

# Stage semua files
git add .

# Commit
git commit -m "Initial commit: Bantu Tugas Platform"

# Add GitHub remote (ganti USERNAME & REPO)
git remote add origin https://github.com/USERNAME/bantutugas.git

# Push ke GitHub
git branch -M main
git push -u origin main
```

---

### 2️⃣ **Setup di Railway.app**

**Langkah-langkah:**

1. **Buka** https://railway.app
2. **Klik** "Create New Project"
3. **Pilih** "Deploy from GitHub"
4. **Login** dengan GitHub account
5. **Select** repository `bantutugas`
6. Railway akan **auto-detect** Laravel
7. **Tunggu** deployment process

---

### 3️⃣ **Configure Environment Variables**

Setelah project dibuat di Railway, pergi ke **Variables**:

**Tambahkan variables ini:**

```
APP_KEY=base64:EC6MwBEixLVgQeJje4mEBkcp7GHIaHTitmYpIEGtQ4I=
APP_ENV=production
APP_DEBUG=false
APP_URL=${RAILWAY_PUBLIC_DOMAIN}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
```

**Untuk Database (jika mau Railway MySQL):**

1. Di Railway, klik **"+ Create"**
2. Pilih **"MySQL"**
3. Railway auto-generate:
   - `MYSQL_HOST`
   - `MYSQL_PORT`
   - `MYSQL_USER`
   - `MYSQL_PASSWORD`
   - `MYSQL_DB`

4. Copy ke environment:
```
DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DB}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}
```

---

### 4️⃣ **Run Migrations di Railway**

Setelah connected ke database, jalankan migrations:

**Option A: Via Railway CLI**
```powershell
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link ke project
railway link

# Run migrations
railway run php artisan migrate:fresh --seed
```

**Option B: Via Dashboard**
1. Go ke **Deployments** tab
2. Klik deploy terbaru
3. Di **Logs**, lihat proses running

---

### 5️⃣ **Dapatkan Public URL**

Setelah deploy successful:

1. Buka **Settings** di Railway
2. Cari **Public URL** (format: `xxx.railway.app`)
3. Copy URL tersebut
4. Test akses di browser

---

## ✅ Checklist Pre-Deployment

- ✅ `Procfile` ada
- ✅ `.env.production` ada dengan APP_KEY
- ✅ `composer.json` ada dengan Laravel dependencies
- ✅ Repository sudah di GitHub
- ✅ Migrations siap
- ✅ Seeders siap
- ✅ `.gitignore` exclude `.env` & `vendor`

---

## 🔧 File Penting untuk Railway

```
Procfile                 ← Cara jalankan app
composer.json            ← PHP dependencies
.env.production         ← Production settings
database/migrations/    ← Database schema
database/seeders/       ← Initial data
```

---

## 📝 Troubleshooting

**Problem: Build Failed**
- Solusi: Cek Logs di Railway Dashboard
- Pastikan `composer.json` valid
- Pastikan `config/database.php` proper

**Problem: Database Error**
- Solusi: Add MySQL di Railway
- Update `DB_HOST`, `DB_PORT`, dll
- Run migrations

**Problem: 500 Error**
- Solusi: Cek logs via `railway logs`
- Pastikan `APP_DEBUG=true` saat development
- Check database connection

**Problem: File Permissions**
- Railway auto-handle, tapi jika perlu:
```
railway run php artisan storage:link
railway run chmod -R 775 storage bootstrap/cache
```

---

## 🎯 Expected Result

Setelah berhasil:
- ✅ URL public seperti `https://bantutugas-prod.railway.app`
- ✅ Accessible dari mana saja
- ✅ Database connected
- ✅ All pages working
- ✅ Real-time features functional
- ✅ File uploads working

---

## 💰 Pricing

- **Free tier:** $5/bulan credits (cukup untuk dev/staging)
- **Bayar tambahan:** $0.40 per GB disk, $0.050 per vCPU jam
- **MySQL:** $9/bulan (atau included dalam free credits)

---

## 🚀 Next Steps

1. Push ke GitHub
2. Go to railway.app
3. Connect GitHub
4. Setup environment variables
5. Add MySQL database
6. Run migrations
7. Deploy!

Done! Your app is live on the internet! 🎉

---

## 📚 Resources

- Railway Docs: https://docs.railway.app
- Laravel on Railway: https://docs.railway.app/guides/frameworks
- Railway CLI: https://docs.railway.app/cli

