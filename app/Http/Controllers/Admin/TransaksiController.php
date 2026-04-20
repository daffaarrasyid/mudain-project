<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Fungsi untuk menampilkan halaman Entry Penjualan
    public function entryPenjualan()
    {
        return view('admin.transaksi.entry-penjualan');
    }

    // Fungsi untuk menampilkan halaman Daftar Penjualan
    public function daftarPenjualan()
    {
        return view('admin.transaksi.daftar-penjualan');
    }

    // Fungsi untuk menampilkan halaman Entry Pembelian
    public function entryPembelian()
    {
        return view('admin.transaksi.entry-pembelian');
    }

    // Fungsi untuk menampilkan halaman Daftar Pembelian
    public function daftarPembelian()
    {
        return view('admin.transaksi.daftar-pembelian');
    }
}