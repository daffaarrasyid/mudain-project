<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function index()
    {
        // Pastikan file login.blade.php ada di resources/views/auth/
        return view('auth.login');
    }
}