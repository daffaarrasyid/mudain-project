<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    // Fungsi untuk menampilkan halaman Kas
    public function kas()
    {
        return view('admin.keuangan.kas');
    }

    // Fungsi untuk menampilkan halaman Laba Rugi
    public function labaRugi()
    {
        return view('admin.keuangan.laba-rugi');
    }

    // Fungsi untuk menampilkan halaman form Pengeluaran Lainnya
    public function pengeluaranLainnya()
    {
        return view('admin.keuangan.pengeluaran-lainnya');
    }
}