<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Fungsi untuk menampilkan halaman utama Data Customer
    public function index()
    {
        // Mengarahkan ke file blade resources/views/admin/master-data/customer.blade.php
        return view('admin.master-data.customer');
    }
}