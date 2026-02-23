# Website Qualification Evidence

Tanggal verifikasi: 2026-02-23
Domain produksi: https://bantutugas-murex.vercel.app

## 1) Ringkasan Status

- Website publik: **AKTIF**
- Database koneksi: **OK**
- Konten inti homepage: **TERSEDIA**
- Midtrans: **DITUNDA** (belum ada akun, opsi Midtrans disembunyikan otomatis)

## 2) Endpoint Smoke Test

Hasil pengecekan endpoint produksi:

- `/` = 200
- `/services` = 200
- `/portfolio` = 200
- `/how-to-order` = 200
- `/contact` = 200
- `/checkout` = 200
- `/login` = 200
- `/health` = 200
- `/__health` = 200

## 3) Validasi Data Runtime (via `/health`)

- `db.connect` = `OK`
- `services_count` = `11`
- `portfolios_count` = `3`
- `testimonials_count` = `1`

## 4) Perbaikan yang Sudah Aktif

- Homepage layanan/portofolio kembali tampil normal.
- Logo pembayaran tampil normal.
- Perbaikan URL aset HTTPS aktif di production.
- Tampilan mobile CTA hero ("Jelajahi Layanan" / "Cara Pesan") sudah disesuaikan agar tidak kebesaran.
- Checkout tetap berjalan tanpa Midtrans (bank/e-wallet manual tetap tersedia).

## 5) Catatan Kualifikasi

Website sudah memenuhi kebutuhan minimum untuk proses kualifikasi awal:
- dapat diakses publik,
- halaman inti berjalan,
- konten utama tersedia,
- autentikasi/login tersedia,
- tidak tergantung Midtrans untuk fungsi dasar.

## 6) Lampiran Screenshot yang Disarankan

Agar dokumen lebih kuat saat diajukan, sertakan screenshot berikut:
1. Halaman beranda (`/`)
2. Halaman layanan (`/services`)
3. Halaman portofolio (`/portfolio`)
4. Halaman checkout (`/checkout`)
5. Halaman login (`/login`)
6. Health endpoint (`/health`) menampilkan `db.connect=OK` dan count data > 0
