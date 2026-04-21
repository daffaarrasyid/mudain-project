<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Fungsi untuk menampilkan halaman Laporan Barang
    public function laporanBarang()
    {
        return view('admin.laporan.barang');
    }

    // Fungsi untuk menampilkan halaman Laporan Penjualan
    public function laporanPenjualan()
    {
        return view('admin.laporan.penjualan');
    }

    // Fungsi untuk menampilkan halaman Laporan Pembelian
    public function laporanPembelian()
    {
        return view('admin.laporan.pembelian');
    }

    // Fungsi untuk menampilkan halaman Laporan Laba Rugi
    public function labaRugi()
    {
        return view ('admin.laporan.laba-rugi');
    }

    // Fungsi untuk menampilkan halaman Laporan Kas


    // Fungsi untuk menampilkan halaman Laporan Stok In/Out
    public function laporanStok()
    {
        return view('admin.laporan.stok');
    }

    // Fungsi untuk menampilkan halaman Laporan Hutang
    public function laporanHutang()
    {
        return view('admin.laporan.hutang');
    }

    // Fungsi untuk menampilkan halaman Laporan Piutang
    public function laporanPiutang()
    {
        return view('admin.laporan.piutang');
    }
}