<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Fungsi untuk halaman Manajemen Role
    public function role()
    {
        return view('admin.user.role');
    }

    // Fungsi untuk halaman Histori Pengguna
    public function histori()
    {
        return view('admin.user.histori');
    }

    // Fungsi untuk halaman Manajemen Pengguna
    public function pengguna()
    {
        return view('admin.user.pengguna');
    }
}