<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GrafikController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProduksiController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing.index');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'store'])->name('admin.login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->group(function () {
        Route::get('/data-produk', [ProductController::class, 'index'])->name('data-produk.index');
        Route::post('/data-produk', [ProductController::class, 'store'])->name('data-produk.store');
        Route::put('/data-produk/{produk}', [ProductController::class, 'update'])->name('data-produk.update');
        Route::delete('/data-produk/{produk}', [ProductController::class, 'destroy'])->name('data-produk.destroy');

        Route::get('/kategori-produk', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori-produk', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori-produk/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori-produk/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        Route::get('/satuan-produk', [SatuanController::class, 'index'])->name('satuan.index');
        Route::post('/satuan-produk', [SatuanController::class, 'store'])->name('satuan.store');
        Route::put('/satuan-produk/{satuan}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/satuan-produk/{satuan}', [SatuanController::class, 'destroy'])->name('satuan.destroy');

        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/supplier/{pemasok}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{pemasok}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
        Route::put('/customer/{pembeli}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customer/{pembeli}', [CustomerController::class, 'destroy'])->name('customer.destroy');

        Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
        Route::post('/stok', [StokController::class, 'store'])->name('stok.store');
    });

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/entry-penjualan', [TransaksiController::class, 'entryPenjualan'])->name('entry-penjualan');
        Route::post('/entry-penjualan', [TransaksiController::class, 'storePenjualan'])->name('store-penjualan');
        Route::get('/daftar-penjualan', [TransaksiController::class, 'daftarPenjualan'])->name('daftar-penjualan');

        Route::get('/entry-pembelian', [TransaksiController::class, 'entryPembelian'])->name('entry-pembelian');
        Route::post('/entry-pembelian', [TransaksiController::class, 'storePembelian'])->name('store-pembelian');
        Route::get('/daftar-pembelian', [TransaksiController::class, 'daftarPembelian'])->name('daftar-pembelian');

        Route::get('/hutang', [TransaksiController::class, 'hutang'])->name('hutang');
        Route::post('/hutang/{hutang}/bayar', [TransaksiController::class, 'bayarHutang'])->name('hutang.bayar');
        Route::put('/hutang/{hutang}/status', [TransaksiController::class, 'updateStatusHutang'])->name('hutang.status');

        Route::get('/piutang', [TransaksiController::class, 'piutang'])->name('piutang');
        Route::post('/piutang/{piutang}/bayar', [TransaksiController::class, 'bayarPiutang'])->name('piutang.bayar');
        Route::put('/piutang/{piutang}/status', [TransaksiController::class, 'updateStatusPiutang'])->name('piutang.status');
    });

    Route::prefix('produksi')->name('produksi.')->group(function () {
        Route::get('/update-produksi', [ProduksiController::class, 'updateProduksi'])->name('update-produksi');
        Route::put('/update-produksi/{produksi}', [ProduksiController::class, 'simpanProduksi'])->name('simpan-produksi');
        Route::get('/update-desain', [ProduksiController::class, 'updateDesain'])->name('update-desain');
        Route::put('/update-desain/{desain}', [ProduksiController::class, 'simpanDesain'])->name('simpan-desain');
    });

    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/kas', [KeuanganController::class, 'kas'])->name('kas');
        Route::get('/laba-rugi', [KeuanganController::class, 'labaRugi'])->name('laba-rugi');
        Route::get('/pengeluaran-lainnya', [KeuanganController::class, 'pengeluaranLainnya'])->name('pengeluaran-lainnya');
        Route::post('/pengeluaran-lainnya', [KeuanganController::class, 'storePengeluaran'])->name('pengeluaran.store');
        Route::put('/pengeluaran-lainnya/{pengeluaran}', [KeuanganController::class, 'updatePengeluaran'])->name('pengeluaran.update');
        Route::delete('/pengeluaran-lainnya/{pengeluaran}', [KeuanganController::class, 'destroyPengeluaran'])->name('pengeluaran.destroy');
    });

    Route::prefix('konten')->name('konten.')->group(function () {
        Route::get('/mitra', [KontenController::class, 'mitra'])->name('mitra');
        Route::post('/mitra', [KontenController::class, 'storeMitra'])->name('mitra.store');
        Route::put('/mitra/{mitra}', [KontenController::class, 'updateMitra'])->name('mitra.update');
        Route::delete('/mitra/{mitra}', [KontenController::class, 'destroyMitra'])->name('mitra.destroy');

        Route::get('/produk', [KontenController::class, 'produk'])->name('produk');
        Route::post('/produk', [KontenController::class, 'storeProduk'])->name('produk.store');
        Route::put('/produk/{produkProfil}', [KontenController::class, 'updateProduk'])->name('produk.update');
        Route::delete('/produk/{produkProfil}', [KontenController::class, 'destroyProduk'])->name('produk.destroy');

        Route::get('/portofolio', [KontenController::class, 'portofolio'])->name('portofolio');
        Route::post('/portofolio', [KontenController::class, 'storePortofolio'])->name('portofolio.store');
        Route::put('/portofolio/{portofolio}', [KontenController::class, 'updatePortofolio'])->name('portofolio.update');
        Route::delete('/portofolio/{portofolio}', [KontenController::class, 'destroyPortofolio'])->name('portofolio.destroy');

        Route::get('/testimoni', [KontenController::class, 'testimoni'])->name('testimoni');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/barang', [LaporanController::class, 'laporanBarang'])->name('barang');
        Route::get('/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('penjualan');
        Route::get('/pembelian', [LaporanController::class, 'laporanPembelian'])->name('pembelian');
        Route::get('/laba-rugi', [LaporanController::class, 'laporanKeuangan'])->name('keuangan');
        Route::get('/arus-kas', [LaporanController::class, 'laporanArusKas'])->name('arus-kas');
        Route::get('/stok', [LaporanController::class, 'laporanStok'])->name('stok');
        Route::get('/hutang', [LaporanController::class, 'laporanHutang'])->name('hutang');
        Route::get('/piutang', [LaporanController::class, 'laporanPiutang'])->name('piutang');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/role', [UserController::class, 'role'])->name('role');
        Route::post('/role', [UserController::class, 'storeRole'])->name('role.store');
        Route::put('/role/{role}', [UserController::class, 'updateRole'])->name('role.update');
        Route::delete('/role/{role}', [UserController::class, 'destroyRole'])->name('role.destroy');

        Route::get('/histori', [UserController::class, 'histori'])->name('histori');

        Route::get('/pengguna', [UserController::class, 'pengguna'])->name('pengguna');
        Route::post('/pengguna', [UserController::class, 'storePengguna'])->name('pengguna.store');
        Route::put('/pengguna/{pengguna}', [UserController::class, 'updatePengguna'])->name('pengguna.update');
        Route::delete('/pengguna/{pengguna}', [UserController::class, 'destroyPengguna'])->name('pengguna.destroy');
    });

    Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik.index');

    Route::prefix('tools')->name('tools.')->group(function () {
        Route::get('/generate-barcode', [ToolsController::class, 'generateBarcode'])->name('generate-barcode');
        Route::get('/backup-data', [ToolsController::class, 'backupData'])->name('backup-data');
        Route::post('/backup-data', [ToolsController::class, 'prosesBackup'])->name('backup-data.process');
        Route::get('/backup-data/download', [ToolsController::class, 'downloadBackup'])->name('backup-data.download');
    });
});
