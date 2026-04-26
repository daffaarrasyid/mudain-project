<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    // Fungsi untuk menampilkan halaman Mitra
    public function mitra()
    {
        return view('admin.konten.mitra');
    }

    // Fungsi untuk menampilkan halaman Produk
    public function produk()
    {
        return view('admin.konten.produk');
    }

    // Fungsi untuk menampilkan halaman Portofolio
    public function portofolio()
    {
        return view('admin.konten.portofolio');
    }

    // Fungsi untuk menampilkan halaman Testimoni
    public function testimoni()
    {
        return view('admin.konten.testimoni');
    }
}
