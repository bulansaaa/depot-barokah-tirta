# Project Overview: Depot Barokah Tirta

## Deskripsi Proyek
**Depot Barokah Tirta** adalah sistem manajemen operasional untuk depot air minum isi ulang. Aplikasi ini dirancang untuk mencatat transaksi penjualan (langsung maupun antar), mengelola data pelanggan, memantau jadwal pengiriman rutin, dan menghasilkan laporan keuangan secara otomatis.

## Tech Stack

### Backend
- **Language:** PHP 8.3+
- **Framework:** Laravel 13.8
- **ORM:** Eloquent (built-in Laravel)
- **Package Manager:** Composer

### Frontend
- **Template Engine:** Laravel Blade
- **CSS Framework:** Tailwind CSS 3.1
- **JavaScript Library:** Alpine.js 3.4.2 (Lightweight DOM interaction)
- **Module Bundler:** Vite 8.0
- **CSS Processing:** PostCSS 8.4 + Autoprefixer 10.4
- **HTTP Client:** Axios 1.16.1

### Database
- **Primary DB:** MySQL / MariaDB
- **Version:** Compatible dengan Laravel 13

### Reporting & PDF
- **PDF Generation:** DomPDF 3.1
- **Format Output:** HTML to PDF

### Development Tools
- **Code Formatting:** Laravel Pint 1.27
- **Testing:** PHPUnit 12.5.12
- **Task Runner:** Concurrently 9.0.1
- **Testing Library:** Mockery 1.6
- **Faker:** FakerPHP 1.23 (dummy data generation)

## Modul & Fitur Utama

### 1. Dashboard (Pusat Kendali)
- **Controller:** `app/Http/Controllers/DashboardController.php`
- **Models:** 
  - `app/Models/Transaksi.php`
  - `app/Models/Pelanggan.php`
  - `app/Models/JadwalRutin.php`
- **Views:** `resources/views/dashboard.blade.php`
- **Statistik Cepat:** Menampilkan total transaksi hari ini, pendapatan harian & bulanan, serta jumlah pelanggan.
- **Monitoring Status:** Widget untuk melihat jumlah transaksi yang sedang `pending` atau `diproses`.
- **Jadwal Hari Ini:** List pelanggan yang memiliki jadwal pengiriman rutin pada hari tersebut dengan akses cepat untuk membuat transaksi.
- **Transaksi Terbaru:** Tabel ringkasan transaksi terakhir yang masuk.

### 2. Manajemen Pelanggan (Pelanggan)
- **Controller:** `app/Http/Controllers/PelangganController.php`
- **Models:** 
  - `app/Models/Pelanggan.php`
  - `app/Models/Transaksi.php`
- **Views:** 
  - `resources/views/pelanggan/index.blade.php` (Daftar pelanggan)
  - `resources/views/pelanggan/create.blade.php` (Tambah)
  - `resources/views/pelanggan/edit.blade.php` (Edit)
  - `resources/views/pelanggan/show.blade.php` (Riwayat & Detail)
- **Database Pelanggan:** Nama, No. HP, Alamat Lengkap, dan Catatan.
- **Riwayat:** Melihat histori transaksi dari masing-masing pelanggan.

### 3. Manajemen Produk (Produk)
- **Controller:** `app/Http/Controllers/ProdukController.php`
- **Models:** `app/Models/Produk.php`
- **Views:** 
  - `resources/views/produk/index.blade.php`
  - `resources/views/produk/create.blade.php`
  - `resources/views/produk/edit.blade.php`
- **Katalog Produk:** Nama produk (misal: Air Galon, Tutup Galon, Tisu), Harga, dan Satuan.
- **Status:** Kontrol untuk mengaktifkan/menonaktifkan produk.

### 4. Sistem Transaksi (Transaksi)
- **Controller:** `app/Http/Controllers/TransaksiController.php`
- **Models:** 
  - `app/Models/Transaksi.php`
  - `app/Models/TransaksiDetail.php`
  - `app/Models/Pelanggan.php`
  - `app/Models/Produk.php`
- **Views:** 
  - `resources/views/transaksi/index.blade.php`
  - `resources/views/transaksi/create.blade.php`
  - `resources/views/transaksi/show.blade.php`
  - `resources/views/transaksi/nota.blade.php` (Nota HTML)
- **Pencatatan Penjualan:** 
  - **Tipe Transaksi:** Langsung (beli di tempat) dan Antar (dikirim ke alamat).
  - **Metode Pemesanan:** WA, Telepon, atau Datang Langsung.
- **Workflow Status:** `Pending` -> `Diproses` -> `Diantar` -> `Selesai` / `Dibatalkan`.
- **Manajemen Alamat:** Khusus tipe 'Antar', bisa menggunakan alamat pelanggan atau alamat pengiriman berbeda.
- **Cetak Nota:** Fitur cetak nota dalam format web maupun PDF.

### 5. Penjadwalan Rutin (Jadwal Rutin)
- **Controller:** `app/Http/Controllers/JadwalRutinController.php`
- **Models:** 
  - `app/Models/JadwalRutin.php`
  - `app/Models/Pelanggan.php`
- **Views:** 
  - `resources/views/jadwal-rutin/index.blade.php`
  - `resources/views/jadwal-rutin/create.blade.php`
  - `resources/views/jadwal-rutin/edit.blade.php`
- **Pengiriman Terjadwal:** Mengatur hari apa saja seorang pelanggan rutin memesan air (misal: setiap Senin dan Kamis).
- **Automasi Dashboard:** Jadwal ini akan otomatis muncul di dashboard sesuai hari berjalan.

### 6. Laporan (Reporting)
- **Controller:** `app/Http/Controllers/LaporanController.php`
- **Models:** `app/Models/Transaksi.php`
- **Views:** 
  - `resources/views/laporan/index.blade.php`
  - `resources/views/laporan/harian.blade.php`
  - `resources/views/laporan/bulanan.blade.php`
  - `resources/views/laporan/pdf-harian.blade.php` (Template PDF)
  - `resources/views/laporan/pdf-bulanan.blade.php` (Template PDF)
  - `resources/views/laporan/nota-pdf.blade.php` (Template PDF Nota)
- **Laporan Harian:** Rincian transaksi dan total pendapatan per hari.
- **Laporan Bulanan:** Rekapitulasi performa penjualan per bulan.
- **Ekspor PDF:** Semua laporan dapat diunduh dalam format PDF untuk keperluan arsip.

### 7. Manajemen Pengeluaran (Pengeluaran)
- **Controller:** `app/Http/Controllers/PengeluaranController.php`
- **Models:** `app/Models/Pengeluaran.php`
- **Views:** 
  - `resources/views/pengeluaran/index.blade.php` (Daftar pengeluaran)
  - `resources/views/pengeluaran/create.blade.php` (Tambah pengeluaran)
  - `resources/views/pengeluaran/edit.blade.php` (Edit pengeluaran)
- **Pencatatan Pengeluaran:** Mencatat semua biaya operasional (bensin, gaji, maintenance, dll).
- **Kategori Pengeluaran:** Operasional, Pemeliharaan, Bahan Baku, Gaji, Lainnya.
- **Input Nominal Currency:** Format otomatis dengan pemisah ribuan (Rp. X.XXX.XXX).
- **Dokumentasi:** Opsi upload foto struk/nota untuk verifikasi.
- **Filtering:** Pencarian berdasarkan nama, kategori, dan tanggal.
- **Analisis Keuangan:** Data pengeluaran terintegrasi untuk perhitungan laba bersih di dashboard.

## Struktur Data (Model Utama)
- **User:** Admin sistem (`app/Models/User.php`)
- **Pelanggan:** Data pembeli (`app/Models/Pelanggan.php`)
- **Produk:** Katalog barang/jasa (`app/Models/Produk.php`)
- **Transaksi:** Data utama penjualan/Header (`app/Models/Transaksi.php`)
- **TransaksiDetail:** Rincian item per transaksi (`app/Models/TransaksiDetail.php`)
- **JadwalRutin:** Pengaturan pengiriman berulang (`app/Models/JadwalRutin.php`)
- **JadwalLog:** Log/tracking pelaksanaan jadwal (`app/Models/JadwalLog.php`)
- **Pengeluaran:** Pencatatan biaya operasional (`app/Models/Pengeluaran.php`)

## Arahan UI/UX (Untuk Prompt UI)
- **Tema:** Bersih, profesional, dan modern dengan dominasi warna biru (melambangkan air/kepercayaan) dan hijau (pertumbuhan/keuangan).
- **Layout:** Menggunakan Sidebar atau Navbar yang responsif.
- **Komponen:**
  - Card-based design untuk statistik.
  - Tabel yang bersih dengan badge status berwarna (misal: Hijau untuk Selesai, Kuning untuk Pending).
  - Form input yang intuitif dengan dropdown pencarian untuk pelanggan dan produk.
  - Desain Mobile-Friendly karena operasional sering menggunakan smartphone/tablet.
