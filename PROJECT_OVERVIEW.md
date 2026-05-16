# Project Overview: Depot Barokah Tirta

## Deskripsi Proyek
**Depot Barokah Tirta** adalah sistem manajemen operasional untuk depot air minum isi ulang. Aplikasi ini dirancang untuk mencatat transaksi penjualan (langsung maupun antar), mengelola data pelanggan, memantau jadwal pengiriman rutin, dan menghasilkan laporan keuangan secara otomatis.

## Tech Stack
- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL/MariaDB
- **Reporting:** DomPDF (untuk cetak nota dan laporan)

## Modul & Fitur Utama

### 1. Dashboard (Pusat Kendali)
- **Statistik Cepat:** Menampilkan total transaksi hari ini, pendapatan harian & bulanan, serta jumlah pelanggan.
- **Monitoring Status:** Widget untuk melihat jumlah transaksi yang sedang `pending` atau `diproses`.
- **Jadwal Hari Ini:** List pelanggan yang memiliki jadwal pengiriman rutin pada hari tersebut dengan akses cepat untuk membuat transaksi.
- **Transaksi Terbaru:** Tabel ringkasan transaksi terakhir yang masuk.

### 2. Manajemen Pelanggan (Pelanggan)
- **Database Pelanggan:** Nama, No. HP, Alamat Lengkap, dan Catatan.
- **Riwayat:** Melihat histori transaksi dari masing-masing pelanggan.

### 3. Manajemen Produk (Produk)
- **Katalog Produk:** Nama produk (misal: Air Galon, Tutup Galon, Tisu), Harga, dan Satuan.
- **Status:** Kontrol untuk mengaktifkan/menonaktifkan produk.

### 4. Sistem Transaksi (Transaksi)
- **Pencatatan Penjualan:** 
  - **Tipe Transaksi:** Langsung (beli di tempat), Antar (dikirim ke alamat), Langganan.
  - **Metode Pemesanan:** WA, Telepon, atau Datang Langsung.
- **Workflow Status:** `Pending` -> `Diproses` -> `Diantar` -> `Selesai` / `Dibatalkan`.
- **Manajemen Alamat:** Khusus tipe 'Antar', bisa menggunakan alamat pelanggan atau alamat pengiriman berbeda.
- **Cetak Nota:** Fitur cetak nota dalam format web maupun PDF.

### 5. Penjadwalan Rutin (Jadwal Rutin)
- **Pengiriman Terjadwal:** Mengatur hari apa saja seorang pelanggan rutin memesan air (misal: setiap Senin dan Kamis).
- **Automasi Dashboard:** Jadwal ini akan otomatis muncul di dashboard sesuai hari berjalan.

### 6. Laporan (Reporting)
- **Laporan Harian:** Rincian transaksi dan total pendapatan per hari.
- **Laporan Bulanan:** Rekapitulasi performa penjualan per bulan.
- **Ekspor PDF:** Semua laporan dapat diunduh dalam format PDF untuk keperluan arsip.

## Struktur Data (Model Utama)
- **User:** Admin sistem.
- **Pelanggan:** Data pembeli.
- **Produk:** Katalog barang/jasa.
- **Transaksi:** Data utama penjualan (Header).
- **TransaksiDetail:** Rincian item yang dibeli dalam satu transaksi.
- **JadwalRutin:** Pengaturan pengiriman berulang untuk pelanggan.

## Arahan UI/UX (Untuk Prompt UI)
- **Tema:** Bersih, profesional, dan modern dengan dominasi warna biru (melambangkan air/kepercayaan) dan hijau (pertumbuhan/keuangan).
- **Layout:** Menggunakan Sidebar atau Navbar yang responsif.
- **Komponen:**
  - Card-based design untuk statistik.
  - Tabel yang bersih dengan badge status berwarna (misal: Hijau untuk Selesai, Kuning untuk Pending).
  - Form input yang intuitif dengan dropdown pencarian untuk pelanggan dan produk.
  - Desain Mobile-Friendly karena operasional sering menggunakan smartphone/tablet.
