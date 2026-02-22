# Midtrans Production Checklist (Bantu Tugas)

Dokumen ini adalah langkah terakhir agar fitur **auto payment status** berjalan penuh di hosting.

## 1) Isi ENV di Hosting

Masuk ke `.env` hosting, lalu isi nilai berikut:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false

# Opsional fallback webhook custom (boleh tetap diisi)
PAYMENT_WEBHOOK_SECRET=your-random-secret
```

Jika sudah live production Midtrans, ganti:

```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=true
```

## 2) Jalankan Clear Cache Laravel

Jalankan di terminal hosting/server:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 3) Set Webhook di Midtrans Dashboard

Di Midtrans Dashboard:

- Buka **Settings** → **Configuration** → **Payment Notification URL**
- Isi URL berikut:

```text
https://domainkamu.com/payment/webhook
```

Catatan:
- Wajib HTTPS.
- Endpoint ini tidak pakai CSRF dan sudah disiapkan menerima notifikasi Midtrans.

## 4) Cek Route Wajib

Pastikan route ini aktif:

```bash
php artisan route:list | grep payment.webhook
php artisan route:list | grep checkout.process
```

Di Windows PowerShell:

```powershell
php artisan route:list | Select-String -Pattern "payment.webhook|checkout.process"
```

## 5) Uji End-to-End (Sandbox)

1. Buka checkout, pilih kanal **Midtrans Auto Payment**.
2. Submit order sampai diarahkan ke halaman pembayaran Midtrans.
3. Selesaikan pembayaran sandbox (metode test).
4. Tunggu notifikasi webhook Midtrans ke `/payment/webhook`.
5. Cek di admin order:
   - `Payment Status` harus berubah dari `Waiting` → `Paid`
   - `paid_at` terisi otomatis.

## 6) Tempat Cek Jika Belum Berubah ke Paid

- Cek log Laravel:

```bash
tail -f storage/logs/laravel.log
```

Cari log:
- `Midtrans webhook processed`
- `Invalid signature`

## 7) Penyebab Umum Gagal Auto-Paid

- `MIDTRANS_SERVER_KEY` salah/berbeda antara sandbox vs production.
- Notification URL salah domain/path.
- Hosting belum HTTPS.
- Cache config belum di-clear.
- Request webhook diblokir firewall/hosting policy.

## 8) Perilaku Sistem Saat Ini

- **Midtrans Auto Payment**: status akan otomatis jadi `Paid` via webhook.
- **Transfer manual (bank/e-wallet)**: status tetap `Waiting` sampai admin verifikasi di panel admin.

## 9) Rekomendasi Go-Live

- Uji minimal 2 transaksi sandbox sampai status auto update normal.
- Setelah switch ke production Midtrans, ulang 1 transaksi nominal kecil.
- Simpan backup `.env` sebelum dan sesudah switch production.
