<?php

namespace App\Services;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function login(array $credentials): bool
    {
        $success = Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $credentials['remember'] ?? false);

        if ($success) {
            /** @var Pengguna $pengguna */
            $pengguna = Auth::user();

            $this->aktivitasService->catatAktivitas(
                'Login ke sistem',
                'pengguna',
                $pengguna->id_pengguna,
                $pengguna->id_pengguna,
                'Login berhasil'
            );
        }

        return $success;
    }

    public function logout(): void
    {
        $pengguna = Auth::user();

        if ($pengguna instanceof Pengguna) {
            $this->aktivitasService->catatAktivitas(
                'Logout dari sistem',
                'pengguna',
                $pengguna->id_pengguna,
                $pengguna->id_pengguna,
                'Logout berhasil'
            );
        }

        Auth::logout();
    }

    public function verifikasiKredensial(array $credentials): bool
    {
        return Auth::validate([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ]);
    }
}
