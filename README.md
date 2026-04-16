# KyKos

Aplikasi web manajemen kos untuk admin. Proyek ini berisi dashboard, manajemen kamar, laporan keuangan, dan manajemen pengguna.

## Fitur Utama

- Login admin
- Dashboard statistik penghasilan, kamar tersedia, dan kamar terisi
- Manajemen kamar: tambah, edit, hapus, dan lihat data kamar
- Laporan keuangan
- Status pembayaran
- Manajemen pengguna/admin

## Teknologi

- PHP
- MySQL / MariaDB
- Bootstrap 5
- jQuery
- ApexCharts
- Sass

## Persyaratan

- Web server lokal (Laragon, XAMPP, WAMP, atau setara)
- PHP 7.x / 8.x
- MySQL / MariaDB

## Cara Pasang

1. Salin folder proyek ke direktori web server lokal Anda, misalnya `C:\laragon\www\KyKos`.
2. Buat database baru di phpMyAdmin atau MySQL.
3. Impor file `kykos.sql` ke database tersebut.
4. Buka `config.php` dan sesuaikan koneksi database:
   - `DB_HOST`
   - `DB_USER`
   - `DB_PASS`
   - `DB_NAME`
5. Buka browser dan akses `http://localhost/KyKos` atau path yang sesuai.

## Menjalankan dan Mengembangkan

- Jika ingin mengubah tampilan SCSS, jalankan:

```bash
npm install
npm run compile-sass
```

- File hasil kompilasi SCSS:
  - `assets/css/styles.min.css`

## Struktur Proyek

- `index.php` - halaman dashboard utama
- `login.php` - halaman login admin
- `config.php` - konfigurasi koneksi database
- `kykos.sql` - file basis data
- `model/` - model PHP untuk admin, kamar, laporan, dan user
- `navbar/navbar.php` - komponen navigasi
- `assets/css/` - CSS hasil kompilasi
- `assets/scss/` - sumber SCSS
- `assets/js/` - JavaScript frontend

## Catatan

- Pastikan session PHP aktif dan cookie browser dapat digunakan.
- Jika menggunakan Laragon, akses proyek biasanya melalui `http://localhost/KyKos`.
- Sesuaikan nama folder jika Anda menempatkan proyek di lokasi berbeda.

## Lisensi

Gunakan README ini sebagai dokumentasi awal. Tambahkan lisensi jika diperlukan.
