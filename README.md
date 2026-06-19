# 🏠 KyKos — Sistem Manajemen Kos

> Aplikasi web berbasis PHP untuk manajemen kos secara lengkap: kamar, penghuni, pembayaran, dan laporan keuangan.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Struktur Database](#-struktur-database)
- [Kredensial Default](#-kredensial-default)
- [Struktur Proyek](#-struktur-proyek)
- [Pengembangan (SCSS)](#-pengembangan-scss)
- [Arsitektur OOP](#-arsitektur-oop)
- [Catatan Penting](#-catatan-penting)

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|---|---|
| 🔐 **Autentikasi Admin** | Login dengan hashing password (`password_hash` / `password_verify`) |
| 📊 **Dashboard** | Statistik total penghasilan, kamar tersedia, dan kamar terisi dengan grafik ApexCharts |
| 🛏️ **Manajemen Kamar** | Tambah, lihat detail, edit, dan hapus data kamar |
| 💳 **Status Pembayaran** | Rekap dan pemantauan status pembayaran penghuni |
| 💰 **Laporan Keuangan** | Laporan pemasukan berdasarkan periode transaksi |
| 👥 **Manajemen Pengguna** | Tambah, edit, dan hapus akun admin (termasuk role super admin) |
| 📦 **Manajemen Transaksi** | Pencatatan transaksi pembayaran kamar |

---

## 🛠️ Teknologi

- **Backend**: PHP 7.x / 8.x (OOP — PDO / MySQLi)
- **Database**: MySQL 8 / MariaDB
- **Frontend**: Bootstrap 5, jQuery 3
- **Chart**: ApexCharts
- **Styling**: Sass (SCSS) → dikompilasi ke CSS
- **Build Tool**: Node.js + npm (Sass compiler)

---

## ⚙️ Persyaratan Sistem

- Web server lokal: **Laragon**, XAMPP, WAMP, atau sejenisnya
- PHP **7.4** atau lebih baru (direkomendasikan PHP 8.x)
- MySQL **8.0** / MariaDB **10.x** atau lebih baru
- Node.js & npm (hanya jika ingin mengubah file SCSS)

---

## 🚀 Instalasi

### 1. Clone / Salin Proyek

```bash
git clone https://github.com/username/KyKos.git
```

Atau salin folder proyek secara manual ke direktori web server Anda, misalnya:

```
C:\laragon\www\KyKos
```

### 2. Buat Database

Buka **phpMyAdmin** atau klien MySQL lainnya, lalu buat database baru:

```sql
CREATE DATABASE KyKos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Import Skema & Data Awal

Import file `kykos.sql` ke database `KyKos`:

- Via phpMyAdmin: pilih database → tab **Import** → pilih `kykos.sql`
- Via CLI:

```bash
mysql -u root -p KyKos < kykos.sql
```

### 4. Konfigurasi Koneksi Database

Buka file `config.php` dan sesuaikan:

```php
private $host = "localhost";   // host database
private $user = "root";        // username database
private $pass = "";            // password database
private $db   = "KyKos";      // nama database
```

### 5. Akses Aplikasi

Buka browser dan akses:

```
http://localhost/KyKos
```

> Jika menggunakan Laragon dengan pretty URL, bisa juga diakses via `http://kykos.test`

---

## 🗄️ Struktur Database

Berikut tabel-tabel yang digunakan dalam aplikasi:

| Tabel | Deskripsi |
|---|---|
| `users` | Akun admin dengan field: `id`, `username`, `password` (bcrypt), `is_super_admin`, `created_at` |
| `admin` | Data profil admin: `id`, `Password`, `nama`, `email`, `nomor_telp`, `is_super_admin` |
| `kamar` | Data kamar kos: `id`, `nama_kamar`, `harga`, `status` (`Tersedia` / `Terisi`) |
| `transaksi` | Transaksi pembayaran: `id`, `id_kamar`, `tanggal_pembayaran`, `jumlah_bayar` |
| `anggotakos` | Data anggota / penghuni kos |
| `pendaftarkos` | Data pendaftar kos baru |

---

## 🔑 Kredensial Default

Setelah import `kykos.sql`, gunakan akun berikut untuk login:

| Username | Password | Role |
|---|---|---|
| `admin` | `admin123` | Super Admin |
| `Rizky Puspojati` | *(sesuai hash di SQL)* | Admin biasa |

> ⚠️ **Segera ganti password default** setelah pertama kali login untuk keamanan.

---

## 📁 Struktur Proyek

```
KyKos/
│
├── index.php               # Dashboard utama (statistik & grafik)
├── login.php               # Halaman login admin
├── admin.php               # Halaman profil admin
├── config.php              # Konfigurasi koneksi database (class Database)
├── setup.php               # Setup awal / inisialisasi
├── kykos.sql               # File SQL (skema + data awal)
│
├── data-kamar.php          # Daftar semua kamar
├── detail-kamar.php        # Detail satu kamar
├── tambah-kamar.php        # Form tambah kamar
├── edit-kamar.php          # Form edit kamar
├── hapus-kamar.php         # Proses hapus kamar
│
├── status-pembayaran.php   # Halaman status pembayaran
├── laporan-keuangan.php    # Halaman laporan keuangan
├── tambah-admin.php        # Form tambah admin
│
├── model/                  # Layer model (OOP)
│   ├── model.php           # Base model / autoload
│   ├── model-admin.php     # Model untuk tabel admin
│   ├── model-kamar.php     # Model untuk tabel kamar (CRUD)
│   ├── model-laporan.php   # Model untuk laporan keuangan
│   ├── model-transaksi.php # Model untuk transaksi pembayaran
│   └── user.php            # Model untuk tabel users (autentikasi)
│
├── manajemen-user/         # Modul manajemen pengguna
│   ├── manajemen-user.php  # Daftar semua user
│   ├── tambah-user.php     # Form tambah user
│   ├── edit-user.php       # Form edit user
│   └── hapus-user.php      # Proses hapus user
│
├── navbar/
│   └── navbar.php          # Komponen navigasi sidebar
│
├── assets/
│   ├── css/                # CSS hasil kompilasi (styles.min.css)
│   ├── scss/               # Sumber SCSS
│   ├── js/                 # JavaScript frontend
│   ├── images/             # Gambar & aset visual
│   └── libs/               # Library pihak ketiga lokal
│
├── package.json            # Konfigurasi npm (Sass compiler)
└── package-lock.json
```

---

## 🎨 Pengembangan (SCSS)

Jika ingin memodifikasi tampilan melalui file SCSS:

### Install dependensi

```bash
npm install
```

### Jalankan Sass watcher

```bash
npm run compile-sass
```

Perintah ini akan **memantau perubahan** pada file SCSS dan mengkompilasinya secara otomatis ke:

```
assets/css/styles.min.css
```

> **Catatan**: Jangan mengedit langsung file `.css` karena akan tertimpa saat SCSS dikompilasi ulang.

---

## 🏗️ Arsitektur OOP

Proyek ini menggunakan pendekatan **Object-Oriented Programming (OOP)** dengan pola sederhana:

```
Halaman PHP (View)
       │
       ▼
    Model (model/*.php)
       │
       ▼
  class Database (config.php)
       │
       ▼
    MySQL / MariaDB
```

- **`config.php`** → class `Database`: mengelola koneksi MySQLi dan eksekusi query.
- **`model/model-kamar.php`** → class `Kamar`: operasi CRUD pada tabel `kamar`.
- **`model/user.php`** → class `User`: autentikasi login, manajemen user.
- **`model/model-admin.php`** → class `Admin`: operasi data profil admin.
- **`model/model-laporan.php`** → class `Laporan`: query laporan keuangan.
- **`model/model-transaksi.php`** → class `Transaksi`: operasi pencatatan transaksi.

---

## 📝 Catatan Penting

- Pastikan **session PHP** aktif; semua halaman admin dilindungi oleh pengecekan session.
- Password user disimpan menggunakan **bcrypt** (`password_hash` PHP) — jangan ubah secara manual di database tanpa hashing ulang.
- File `kykos.sql` hanya berisi **data awal** (bukan skema lengkap). Pastikan tabel sudah dibuat terlebih dahulu, atau gunakan file SQL yang sudah mencakup `CREATE TABLE`.
- Jika folder proyek berbeda dari `KyKos`, sesuaikan path akses di browser.
- File `debug-session.php` adalah helper debugging — **hapus atau batasi aksesnya** sebelum deploy ke server publik.

---

## 🤝 Kontribusi

Proyek ini dibuat sebagai tugas **Pemrograman Berorientasi Objek (PBO)**. Kontribusi dan saran tetap diterima:

1. Fork repositori ini
2. Buat branch fitur baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m "feat: tambah fitur X"`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request
