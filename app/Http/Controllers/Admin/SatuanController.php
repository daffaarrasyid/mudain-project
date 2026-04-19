<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    // Menampilkan halaman utama Data Satuan Produk
    public function index()
    {
        // Mengarahkan ke file blade satuan
        return view('admin.master-data.satuan');
    }
}