<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">🚀 Mudain Project ERP & POS System</h1>

<p align="center">
  <strong>Sistem Manajemen Penjualan (POS), Inventaris, Produksi, Keuangan & Profil Perusahaan Terintegrasi</strong>
</p>

<p align="center">
  <a href="#-teknologi-yang-digunakan"><img src="https://img.shields.io/badge/Laravel-13.x-red?style=for-the-badge&logo=laravel" alt="Laravel 13"></a>
  <a href="#-teknologi-yang-digunakan"><img src="https://img.shields.io/badge/PHP-8.3%2B-blue?style=for-the-badge&logo=php" alt="PHP 8.3"></a>
  <a href="#-teknologi-yang-digunakan"><img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38bdf8?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS"></a>
  <a href="#-teknologi-yang-digunakan"><img src="https://img.shields.io/badge/Vite-6.x-646cff?style=for-the-badge&logo=vite" alt="Vite"></a>
</p>

---

## 📌 Tentang Mudain Project

**Mudain Project** adalah sebuah sistem enterprise resource planning (ERP) mini dan point of sale (POS) terintegrasi yang dirancang khusus untuk memenuhi kebutuhan bisnis kustomisasi produk (seperti konveksi, percetakan, merchandise, dll.) serta retail umum. 

Aplikasi ini menggabungkan landing page profil perusahaan (Company Profile) yang elegan untuk pelanggan dengan sistem backoffice admin yang sangat powerful dan lengkap. Sistem backoffice mencakup manajemen stok barang, pelacakan proses produksi kustom secara visual (workflow order tracker), manajemen keuangan komprehensif (buku kas & laporan laba rugi otomatis), hingga sistem otorisasi multi-role berbasis hak akses granular.

Sistem ini dikembangkan menggunakan **Laravel 13**, **Vite**, dan **Tailwind CSS** untuk menyajikan performa tinggi, tampilan modern (sleek UI), serta UX yang interaktif.

---

## ✨ Fitur-Fitur Utama

Sistem terbagi menjadi dua bagian utama: **Halaman Customer** (Frontend/Company Profile) dan **Dashboard Admin** (Backend).

### 🌐 1. Halaman Customer (Company Profile)
*   **Beranda**: Tampilan utama interaktif dengan karosel portofolio, katalog produk unggulan, statistik pencapaian, dan testimoni pelanggan.
*   **Tentang Kami**: Informasi detail sejarah, visi misi, serta profil perusahaan.
*   **Katalog Produk**: Daftar lengkap produk/kategori jasa yang ditawarkan beserta visual berkualitas.
*   **Hubungi Kami**: Form kontak, integrasi peta lokasi, dan link sosial media resmi.

### 💼 2. Dashboard Admin & Backoffice (ERP & POS)
*   📊 **Dashboard Analytics & Chart**: Visualisasi ringkasan transaksi, penjualan harian, piutang, hutang, serta chart performa penjualan dinamis menggunakan Chart.js.
*   📦 **Master Data Terstruktur**:
    *   **Data Produk**: Kelola produk fisik lengkap dengan gambar, harga beli, harga jual umum, harga pelanggan (reseller), dan stok terupdate. Mendukung **Import Excel**.
    *   **Kategori & Satuan**: Manajemen klasifikasi barang (Contoh: Konveksi, Percetakan) dan unit (Pcs, Meter, Lusin, Kodi).
    *   **Data Jasa & Servis**: Manajemen tarif jasa eksternal (Fotografer, Videografer) beserta penugasan staf terkait.
    *   **Staf**: Manajemen data karyawan internal yang ditugaskan ke bagian servis/produksi.
    *   **Supplier & Customer**: Basis data mitra bisnis dan pelanggan dengan dukungan **Import Excel** & **Export PDF**.
    *   **Manajemen Stok (In/Out)**: Pencatatan mutasi stok barang masuk atau keluar secara transparan beserta kalkulasi nilainya.
*   🛍️ **Sistem POS & Pembelian**:
    *   **Transaksi Penjualan (POS)**: Entri kasir modern untuk mencatat pesanan produk umum atau kustom, kalkulasi diskon, status pembayaran (Lunas/Kredit), hingga cetak **Invoice PDF**.
    *   **Transaksi Pembelian**: Manajemen pemesanan bahan/barang kepada supplier untuk mengisi stok atau memenuhi pesanan penjualan spesifik.
    *   **Hutang & Piutang (AP/AR)**: Pelacakan otomatis sisa piutang pelanggan atau hutang ke supplier, lengkap dengan **fitur pembayaran cicilan / riwayat angsuran**.
*   🏭 **Workflow Manajemen Produksi & Desain**:
    *   **Update Desain**: Unggah gambar konsep desain, catat nama desainer, deskripsi pengerjaan, dan simpan untuk diakses tim produksi.
    *   **Progress Tracking**: Pemantauan tahapan pengerjaan setiap produk dalam pesanan (Contoh: Potong Bahan, Sablon, Jahit, Finishing) lengkap dengan indikator persentase kemajuan (0% - 100%).
*   💵 **Manajemen Keuangan Terintegrasi**:
    *   **Buku Kas Digital**: Pencatatan arus kas masuk/keluar secara langsung dari transaksi POS, angsuran piutang/hutang, maupun pengeluaran operasional non-transaksi lainnya.
    *   **Kalkulator Laba Rugi**: Menghitung secara otomatis laba kotor, beban operasional tambahan, dan laba bersih secara real-time.
*   📋 **Laporan & Ekspor Data Komprehensif**:
    *   Ekspor PDF dan Excel untuk semua data vital: Laporan Barang, Penjualan, Pembelian, Kas, Laba Rugi (Kotor & Bersih), Stok, Hutang, dan Piutang.
*   🔒 **Keamanan & Otorisasi Pengguna**:
    *   **Role & Permissions**: Penentuan level akses pengguna secara granular (Contoh: Owner/Super Admin, Sales, Desainer, Admin Konten, Finance, Purchasing).
    *   **Activity Log**: Catatan riwayat aktivitas pengguna untuk mengaudit tindakan penambahan, pengubahan, atau penghapusan data.
*   🛠️ **Developer Tools**:
    *   **System Backup**: Backup database sistem secara cepat untuk proteksi data.

---

## 🛠️ Teknologi yang Digunakan

*   **Framework PHP**: Laravel 13.x (Modern MVC Architecture)
*   **Bahasa Pemrograman**: PHP 8.3+ & JavaScript (ES6+)
*   **Desain & Styling**: Tailwind CSS 3.x (Fully Responsive & Clean UI)
*   **Build Tool**: Vite 6.x
*   **Database**: MySQL / PostgreSQL / SQLite
*   **Library Ekspor**: Barryvdh Laravel DomPDF & Maatwebsite Laravel Excel
*   **Chart Rendering**: Chart.js (Interactive Diagrams)
*   **Icon System**: FontAwesome / Heroicons

---

## 🚀 Panduan Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project ini di server lokal (Localhost):

### Prasyarat
Pastikan komputer Anda sudah terinstal:
*   [PHP >= 8.3](https://www.php.net/downloads.php) (beserta ekstensi php-sqlite, php-xml, php-mbstring, php-gd)
*   [Composer >= 2.x](https://getcomposer.org/)
*   [Node.js >= 20.x](https://nodejs.org/) & NPM

### Langkah-Langkah

1.  **Clone atau Unduh Repository Ini**
    ```bash
    git clone https://github.com/username/mudain-project.git
    cd mudain-project
    ```

2.  **Instal Dependensi PHP (Composer)**
    ```bash
    composer install
    ```

3.  **Instal Dependensi Frontend (NPM)**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment File**
    Salin file `.env.example` menjadi `.env`
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` di text editor Anda, lalu sesuaikan koneksi database Anda. Secara default, project ini dikonfigurasi untuk menggunakan SQLite:
    ```env
    DB_CONNECTION=sqlite
    # Jika menggunakan SQLite, pastikan database.sqlite sudah dibuat di folder database
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Database dan Seeders**
    ```bash
    php artisan migrate --seed
    ```
    *Perintah di atas akan membuat semua tabel database beserta data awal (Master Kategori, Satuan, Akun Admin Utama, Role default).*

7.  **Jalankan Development Server**
    Project ini mendukung eksekusi serentak menggunakan paket bawaan `npx concurrently` yang sudah disiapkan di `composer.json`. Cukup jalankan perintah:
    ```bash
    npm run dev
    ```
    Atau Anda bisa menjalankannya secara terpisah di dua terminal berbeda:
    *   **Terminal 1 (PHP Server):**
        ```bash
        php artisan serve
        ```
    *   **Terminal 2 (Vite Asset Watcher):**
        ```bash
        npm run dev
        ```

8.  **Akses Aplikasi**
    Buka browser Anda dan akses alamat berikut:
    *   Halaman Landing Page: `http://127.0.0.1:8000`
    *   Halaman Login Admin: `http://127.0.0.1:8000/login`

---

## 🔑 Kredensial Login Bawaan (Default Account)

Gunakan akun berikut setelah Anda menjalankan seeder untuk masuk ke dashboard admin:

| No | Username | Password | Role | Status Akses |
|----|----------|----------|------|--------------|
| 1  | `taufik` | `password` | **Owner / Super Admin** | Full Akses (`*`) |

---

## 📚 Dokumen Pendukung lainnya

Untuk dokumentasi teknis yang lebih mendalam mengenai database schema, relasi model, alur kerja sistem, manajemen permissions, serta struktur kode, silakan merujuk ke file:
👉 **[DOKUMENTASI TEKNIS DETIL (DOCUMENTATION.md)](file:///c:/Users/Daffa/Documents/Coolyeah/Academic/Semester%204/Pemrograman%20Web/mudain-project/DOCUMENTATION.md)**

---

<p align="center">
  Dibuat dengan ❤️ untuk memenuhi tugas kuliah Pemrograman Web - Semester 4.
</p>
