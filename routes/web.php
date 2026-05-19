<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\ServisController;
use App\Http\Controllers\Admin\StafController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\HutangController;
use App\Http\Controllers\Admin\PiutangController;
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
require __DIR__ . '/auth.php';

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

// Route untuk halaman Data Servis
Route::resource('/admin/master-data/servis', ServisController::class)->names('admin.servis')->except(['create', 'show', 'edit']);
// Route untuk halaman Data Staf
Route::resource('/admin/master-data/staf', StafController::class)->names('admin.staf')->except(['create', 'show', 'edit']);

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
Route::prefix('admin/transaksi')->name('admin.penjualan.')->group(function () {
    Route::get('/entry-penjualan', [PenjualanController::class, 'entry'])->name('entry');
    Route::post('/entry-penjualan', [PenjualanController::class, 'store'])->name('store');
    Route::get('/daftar-penjualan', [PenjualanController::class, 'daftar'])->name('daftar');
});

Route::prefix('admin/penjualan')->name('admin.penjualan.')->group(function () {
    Route::put('/{id}/update-pembayaran', [PenjualanController::class, 'updatePembayaran'])->name('update-pembayaran');
    Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/cetak', [PenjualanController::class, 'cetakInvoice'])->name('cetak');
});

// Route untuk halaman Pembelian
Route::prefix('admin/transaksi')->name('admin.pembelian.')->group(function () {
    Route::get('/entry-pembelian', [PembelianController::class, 'entry'])->name('entry');
    Route::post('/entry-pembelian', [PembelianController::class, 'store'])->name('store');
    Route::get('/daftar-pembelian', [PembelianController::class, 'daftar'])->name('daftar');
    Route::put('/{id}/update-pembayaran', [PembelianController::class, 'updatePembayaran'])->name('update-pembayaran');
    Route::delete('/{id}', [PembelianController::class, 'destroy'])->name('destroy');
});
// Route untuk halaman Hutang
Route::get('/admin/transaksi/hutang', [HutangController::class, 'index'])->name('admin.transaksi.hutang');
Route::put('/admin/transaksi/hutang/{id}/bayar', [HutangController::class, 'bayarCicilan']);

// Route untuk halaman Piutang
Route::get('/admin/transaksi/piutang', [PiutangController::class, 'index'])->name('admin.transaksi.piutang');
// Rute untuk Proses Bayar & Update Piutang
Route::put('/admin/transaksi/piutang/{id}/bayar', [PiutangController::class, 'bayarCicilan']);
Route::put('/admin/transaksi/piutang/{id}/update', [PiutangController::class, 'updateMaster']);

Route::get('/admin/produksi/update-produksi', [ProduksiController::class, 'updateProduksi'])->name('admin.produksi.update-produksi');
Route::put('/admin/produksi/{id}/update-progress', [ProduksiController::class, 'simpanUpdate'])->name('admin.produksi.update-produksi');
Route::delete('/admin/produksi/{id}/reset-progress', [ProduksiController::class, 'resetUpdate'])->name('admin.produksi.update-produksi');

Route::get('/admin/produksi/update-desain', [ProduksiController::class, 'updateDesain'])->name('admin.produksi.update-desain');
Route::put('/admin/produksi/{id}/simpan-desain', [ProduksiController::class, 'simpanDesain'])->name('admin.produksi.update-desain');
Route::delete('/admin/produksi/{id}/hapus-desain', [ProduksiController::class, 'hapusDesain'])->name('admin.produksi.update-desain');

// Route untuk halaman Keuangan (Kas & Laba Rugi)
Route::prefix('admin/keuangan')->name('admin.keuangan.')->group(function () {
    Route::get('/kas', [KeuanganController::class, 'kas'])->name('kas');
    Route::post('/kas', [KeuanganController::class, 'storeKas'])->name('kas.store'); // <-- Tambahan
    Route::get('/laba-rugi', [KeuanganController::class, 'labaRugi'])->name('laba-rugi');
    Route::get('/pengeluaran-lainnya', [KeuanganController::class, 'pengeluaranLainnya'])->name('pengeluaran-lainnya');
    Route::post('/pengeluaran-lainnya', [\App\Http\Controllers\Admin\KeuanganController::class, 'storePengeluaranLainnya'])->name('pengeluaran-lainnya.store');
});

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
Route::get('/admin/laporan/barang/export', [LaporanController::class, 'exportBarang'])->name('admin.laporan.barang.export');
// Route untuk halaman Laporan Penjualan
Route::get('/admin/laporan/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
Route::post('/admin/laporan/penjualan/export', [LaporanController::class, 'exportPenjualan'])->name('admin.laporan.penjualan.export');
// Route untuk halaman Laporan Pembelian
Route::get('/admin/laporan/pembelian', [LaporanController::class, 'laporanPembelian'])->name('admin.laporan.pembelian');
Route::post('/admin/laporan/pembelian/export', [LaporanController::class, 'exportPembelian'])->name('admin.laporan.pembelian.export');
// Route untuk halaman Laporan Keuangan (Kas dan Laba Rugi)
Route::get('/admin/laporan/laba-rugi', [LaporanController::class, 'laporanKeuangan'])->name('admin.laporan.keuangan');
Route::post('/admin/laporan/kas/export', [LaporanController::class, 'exportKas'])->name('admin.laporan.kas.export');
Route::post('/admin/laporan/laba-kotor/export', [LaporanController::class, 'exportLabaKotor'])->name('admin.laporan.laba-kotor.export');
Route::post('/admin/laporan/laba-bersih/export', [LaporanController::class, 'exportLabaBersih'])->name('admin.laporan.laba-bersih.export');
// Route untuk halaman Laporan Stok In/Out
Route::get('/admin/laporan/stok', [LaporanController::class, 'laporanStok'])->name('admin.laporan.stok');
Route::post('/admin/laporan/stok/export', [LaporanController::class, 'exportStok'])->name('admin.laporan.stok.export');
// Route untuk halaman Laporan Hutang
Route::get('/admin/laporan/hutang', [LaporanController::class, 'laporanHutang'])->name('admin.laporan.hutang');
Route::post('/admin/laporan/hutang/export', [LaporanController::class, 'exportHutang'])->name('admin.laporan.hutang.export');
// Route untuk halaman Laporan Piutang
Route::get('/admin/laporan/piutang', [LaporanController::class, 'laporanPiutang'])->name('admin.laporan.piutang');
Route::post('/admin/laporan/piutang/export', [LaporanController::class, 'exportPiutang'])->name('admin.laporan.piutang.export');

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
