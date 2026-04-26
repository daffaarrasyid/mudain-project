<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    // Fungsi untuk menampilkan halaman Grafik
    public function index()
    {
        return view('admin.grafik.index');
    }
}