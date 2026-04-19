<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Fungsi untuk menampilkan halaman utama Kategori Produk
    public function index()
    {
        // Mengarahkan ke file blade di resources/views/admin/master-data/kategori.blade.php
        return view('admin.master-data.kategori');
    }
}