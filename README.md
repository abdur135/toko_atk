<div align="center">

# ✏️ Toko Alat Tulis — Sistem Manajemen Stok

**Aplikasi web manajemen stok & penjualan alat tulis**, dibangun dengan Laravel.
Mengelola data kategori, produk, mutasi stok (barang masuk/keluar), pengguna, dan laporan — lengkap dengan hak akses berbasis role (**admin** & **staff**).

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![Vite](https://img.shields.io/badge/Vite-8-646CFF?style=flat&logo=vite&logoColor=white)](https://vitejs.dev/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)

</div>

---

## 🎥 Demo Video

<div align="center">

[![Watch Demo on YouTube](https://img.shields.io/badge/▶️_Watch_Demo-YouTube-FF0000?style=for-the-badge&logo=youtube&logoColor=white)](https://youtu.be/https://youtu.be/B4s9VTaU1Zo)

</div>

---

## ✨ Fitur

| Fitur | Deskripsi |
|---|---|
| 🔐 **Autentikasi** | Login dengan hak akses berbasis role (`admin` / `staff`) |
| 📊 **Dashboard** | Ringkasan data stok & aktivitas toko |
| 🗂️ **Master Data** | Halaman terpusat untuk mengelola data induk |
| 🏷️ **Kategori** | CRUD lengkap untuk kategori barang |
| 📦 **Produk** | CRUD lengkap — kode barang, harga, stok, deskripsi |
| 🔁 **Mutasi Stok** | Pencatatan barang masuk & keluar per produk |
| 👥 **Manajemen Pengguna** | CRUD pengguna (khusus admin) |
| 📈 **Laporan** | Laporan mutasi barang |

---

## 🛠️ Teknologi

- **[Laravel 13](https://laravel.com/)** (PHP ^8.3) — backend framework
- **[Tailwind CSS 4](https://tailwindcss.com/)** — styling
- **[Vite](https://vitejs.dev/)** — asset bundler
- **MySQL** — database
- **Blade** — templating engine

---

## 📁 Struktur Utama

```
toko-alat-tulis/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── MasterController.php
│   │   ├── CategoryController.php
│   │   ├── ProductController.php
│   │   ├── StockController.php
│   │   ├── UserController.php
│   │   └── ReportController.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       └── StockMutation.php
├── database/
│   ├── migrations/          # users, categories, products, stock_mutations
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── auth/
│   ├── categories/
│   ├── products/
│   ├── stocks/
│   ├── users/
│   ├── reports/
│   ├── master/
│   └── layouts/
└── routes/
    └── web.php
```

---

## 🗄️ Skema Database

- **users** — `name`, `email`, `password`, `role` (`admin` / `staff`)
- **categories** — `name`, `slug`
- **products** — `category_id`, `code`, `name`, `price`, `stock`, `description`
- **stock_mutations** — `product_id`, `user_id`, `type` (`in` / `out`), `quantity`, `date`, `notes`

---

## 🚀 Instalasi & Menjalankan

### 1. Clone & masuk ke folder project
```bash
git clone <url-repo-ini>
cd toko-alat-tulis
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_alat_tulis
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & seed database
```bash
php artisan migrate --seed
```

> Seeder akan membuat akun admin default:
> - **Email:** `admin@toko.test`
> - **Password:** `password`
>
> ⚠️ Segera ganti password ini setelah login pertama kali.

### 5. Jalankan aplikasi
```bash
composer run dev
```
Perintah di atas menjalankan server Laravel, queue listener, log viewer, dan Vite secara bersamaan.

Atau jalankan manual di dua terminal terpisah:
```bash
php artisan serve
npm run dev
```

Buka **http://localhost:8000** di browser.

---

## 🔑 Hak Akses

| Role | Akses |
|---|---|
| **admin** | Semua fitur, termasuk manajemen pengguna |
| **staff** | Operasional harian (produk, kategori, stok, laporan) |

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan pembelajaran/edukasi. Dibangun di atas [Laravel Framework](https://laravel.com/), lisensi [MIT](https://opensource.org/licenses/MIT).

