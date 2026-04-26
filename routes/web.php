<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\ProduksiController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GrafikController;
use App\Http\Controllers\Admin\ToolsController;

// Route untuk halaman login admin
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');

// Route untuk halaman dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Route untuk halaman master data produk
Route::get('/admin/master-data/data-produk', [ProductController::class, 'index'])->name('admin.data-produk.index');
// Route untuk halaman Kategori Produk
Route::get('/admin/master-data/kategori-produk', [KategoriController::class, 'index'])->name('admin.kategori.index');
// Route untuk halaman Data Satuan Produk
Route::get('/admin/master-data/satuan-produk', [SatuanController::class, 'index'])->name('admin.satuan.index');
// Route untuk halaman Data Supplier
Route::get('/admin/master-data/supplier', [SupplierController::class, 'index'])->name('admin.supplier.index');
// Route untuk halaman Data Customer
Route::get('/admin/master-data/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
// Route untuk halaman Stok In/Out
Route::get('/admin/master-data/stok', [StokController::class, 'index'])->name('admin.stok.index');

// Route untuk halaman Entry Penjualan
Route::get('/admin/transaksi/entry-penjualan', [TransaksiController::class, 'entryPenjualan'])->name('admin.transaksi.entry-penjualan');
// Route untuk halaman Daftar Penjualan
Route::get('/admin/transaksi/daftar-penjualan', [TransaksiController::class, 'daftarPenjualan'])->name('admin.transaksi.daftar-penjualan');
// Route untuk halaman Entry Pembelian
Route::get('/admin/transaksi/entry-pembelian', [TransaksiController::class, 'entryPembelian'])->name('admin.transaksi.entry-pembelian');
// Route untuk halaman Daftar Pembelian
Route::get('/admin/transaksi/daftar-pembelian', [TransaksiController::class, 'daftarPembelian'])->name('admin.transaksi.daftar-pembelian');

// Route untuk Update Produksi
Route::get('/admin/produksi/update-produksi', [ProduksiController::class, 'updateProduksi'])->name('admin.produksi.update-produksi');
// Route untuk Update Desain
Route::get('/admin/produksi/update-desain', [ProduksiController::class, 'updateDesain'])->name('admin.produksi.update-desain');

// Route untuk modul Keuangan
Route::get('/admin/keuangan/kas', [KeuanganController::class, 'kas'])->name('admin.keuangan.kas');
// Route untuk halaman Laba Rugi
Route::get('/admin/keuangan/laba-rugi', [KeuanganController::class, 'labaRugi'])->name('admin.keuangan.laba-rugi');
// Route untuk halaman Pengeluaran Lainnya
Route::get('/admin/keuangan/pengeluaran-lainnya', [KeuanganController::class, 'pengeluaranLainnya'])->name('admin.keuangan.pengeluaran-lainnya');
// Route untuk halaman Hutang
Route::get('/admin/transaksi/hutang', [TransaksiController::class, 'hutang'])->name('admin.transaksi.hutang');
// Route untuk halaman Piutang
Route::get('/admin/transaksi/piutang', [TransaksiController::class, 'piutang'])->name('admin.transaksi.piutang');

// Route untuk halaman Mitra
Route::get('/admin/konten/mitra', [KontenController::class, 'mitra'])->name('admin.konten.mitra');
// Route untuk halaman Produk
Route::get('/admin/konten/produk', [KontenController::class, 'produk'])->name('admin.konten.produk');
// Route untuk halaman Portofolio
Route::get('/admin/konten/portofolio', [KontenController::class, 'portofolio'])->name('admin.konten.portofolio');
// Route untuk halaman Testimoni
Route::get('/admin/konten/testimoni', [KontenController::class, 'testimoni'])->name('admin.konten.testimoni');

// Route untuk halaman Laporan Barang
Route::get('/admin/laporan/barang', [LaporanController::class, 'laporanBarang'])->name('admin.laporan.barang');
// Route untuk halaman Laporan Penjualan
Route::get('/admin/laporan/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
// Route untuk halaman Laporan Pembelian
Route::get('/admin/laporan/pembelian', [LaporanController::class, 'laporanPembelian'])->name('admin.laporan.pembelian');
// Route untuk halaman Laporan Keuangan (Kas dan Laba Rugi)
Route::get('/admin/laporan/laba-rugi', [LaporanController::class, 'laporanKeuangan'])->name('admin.laporan.keuangan');
// Route untuk halaman Laporan Stok In/Out
Route::get('/admin/laporan/stok', [LaporanController::class, 'laporanStok'])->name('admin.laporan.stok');
// Route untuk halaman Laporan Hutang
Route::get('/admin/laporan/hutang', [LaporanController::class, 'laporanHutang'])->name('admin.laporan.hutang');
// Route untuk halaman Laporan Piutang
Route::get('/admin/laporan/piutang', [LaporanController::class, 'laporanPiutang'])->name('admin.laporan.piutang');

// Route untuk halaman Manajemen Role
Route::get('/admin/user/role', [UserController::class, 'role'])->name('admin.user.role');
// Route untuk halaman Histori Pengguna
Route::get('/admin/user/histori', [UserController::class, 'histori'])->name('admin.user.histori');
//Route untuk halaman Manajemen Pengguna
Route::get('/admin/user/pengguna', [UserController::class, 'pengguna'])->name('admin.user.pengguna');

// Route untuk halaman Grafik
Route::get('/admin/grafik', [GrafikController::class, 'index'])->name('admin.grafik.index');

// Route untuk halaman Generate Barcode
Route::get('/admin/tools/generate-barcode', [ToolsController::class, 'generateBarcode'])->name('admin.tools.generate-barcode');
//Route untuk halaman Backup Data
Route::get('/admin/tools/backup-data', [ToolsController::class, 'backupData'])->name('admin.tools.backup-data');
