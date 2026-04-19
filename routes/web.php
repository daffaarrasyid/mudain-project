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
