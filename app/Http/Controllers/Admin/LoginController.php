<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function store(Request $request, AuthService $authService)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! $authService->login($credentials)) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau password tidak sesuai.']);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil.');
    }

    public function destroy(Request $request, AuthService $authService)
    {
        $authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda sudah logout.');
    }
}
