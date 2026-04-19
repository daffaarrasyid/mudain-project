<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function index()
    {
        // Pastikan file login.blade.php ada di resources/views/admin/
        return view('admin.login');
    }
}