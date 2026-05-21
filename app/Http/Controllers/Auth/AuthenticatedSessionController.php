<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use App\Models\Histori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Catat login ke Histori
        Histori::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Login ke sistem',
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Catat logout di Histori sebelum session dihancurkan
        $histori = Histori::where('user_id', Auth::id())
            ->whereNull('waktu_logout')
            ->latest()
            ->first();

        if ($histori) {
            $histori->update(['waktu_logout' => now()]);
        }

        // Catat logout di ActivityLog juga
        ActivityLog::record('logout', 'Logout dari dashboard admin', 'Auth', $request);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

