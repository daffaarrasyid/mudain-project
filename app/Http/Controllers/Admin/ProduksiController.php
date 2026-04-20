<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    // Fungsi untuk menampilkan halaman Update Produksi
    public function updateProduksi()
    {
        return view('admin.produksi.update-produksi');
    }

    // Fungsi untuk menampilkan halaman Update Desain
    public function updateDesain()
    {
        return view('admin.produksi.update-desain');
    }
}