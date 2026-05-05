<?php

use Illuminate\Support\Facades\Route;
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

use App\Http\Controllers\Customer\LandingPageController;
use App\Http\Controllers\Customer\TentangController;
use App\Http\Controllers\Customer\ProdukController;
use App\Http\Controllers\Customer\KontakController;

// CUSTOMER ROUTES
// Route untuk halaman landing page
Route::get('/', [LandingPageController::class, 'index'])->name('beranda');
// Route untuk halaman tentang
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
// Route untuk halaman Produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
// Route untuk halaman Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');

// ADMIN ROUTES

// Route untuk halaman dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');
require __DIR__.'/auth.php';

// Route untuk halaman master data produk
Route::post('/admin/master-data/data-produk/import-excel', [ProductController::class, 'importExcel'])->name('admin.data-produk.import-excel');
Route::resource('/admin/master-data/data-produk', ProductController::class)
    ->names('admin.data-produk')
    ->except(['create', 'show', 'edit']);

// Route untuk halaman Kategori Produk
Route::resource('admin/master-data/kategori-produk', KategoriController::class)
    ->names('admin.kategori')
    ->except(['create', 'show', 'edit']);

// Route untuk halaman Data Satuan Produk
Route::resource('admin/master-data/satuan-produk', SatuanController::class)
    ->names('admin.satuan')
    ->except(['create', 'show', 'edit']);

// Route untuk halaman Data Supplier
Route::get('/admin/master-data/supplier/export-pdf', [SupplierController::class, 'exportPdf'])->name('admin.supplier.export-pdf');
Route::post('/admin/master-data/supplier/import-excel', [SupplierController::class, 'importExcel'])->name('admin.supplier.import-excel');
Route::resource('/admin/master-data/supplier', SupplierController::class)
    ->names('admin.supplier')
    ->except(['create', 'show', 'edit']);

// Route untuk halaman Data Customer
Route::get('admin/master-data/customer/export-pdf', [CustomerController::class, 'exportPdf'])->name('admin.customer.export-pdf');
Route::post('admin/master-data/customer/import-excel', [CustomerController::class, 'importExcel'])->name('admin.customer.import-excel');

Route::resource('admin/master-data/customer', CustomerController::class)
    ->names('admin.customer')
    ->except(['create', 'show', 'edit']);

// Route untuk halaman Stok In/Out
Route::resource('admin/master-data/stok', StokController::class)
    ->names('admin.stok')
    ->except(['create', 'show', 'edit', 'update']);

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

