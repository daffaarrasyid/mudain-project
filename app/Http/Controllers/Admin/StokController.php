<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Fungsi untuk memanggil tampilan halaman Stok In/Out
    public function index()
    {
        return view('admin.master-data.stok');
    }
}