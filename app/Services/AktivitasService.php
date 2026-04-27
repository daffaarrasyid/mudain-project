<?php

namespace App\Services;

use App\Models\Aktivitas;
use App\Models\Riwayat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AktivitasService
{
    public function catatAktivitas(
        string $aksi,
        ?string $tabel = null,
        string|int|null $idReferensi = null,
        ?int $idPengguna = null,
        ?string $detail = null
    ): void {
        Aktivitas::create([
            'id_pengguna' => $idPengguna,
            'aktivitas' => $aksi,
            'tabel_target' => $tabel,
            'id_referensi' => $idReferensi,
            'detail' => $detail,
            'waktu' => now(),
        ]);

        Riwayat::create([
            'id_pengguna' => $idPengguna,
            'tabel_target' => $tabel,
            'id_record' => (string) $idReferensi,
            'jenis_aksi' => $aksi,
            'data_baru' => $detail,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'waktu' => now(),
        ]);
    }

    public function getLogAktivitas(array $filters = []): LengthAwarePaginator
    {
        return Aktivitas::query()
            ->with('pengguna.role')
            ->when($filters['id_pengguna'] ?? null, fn ($query, $idPengguna) => $query->where('id_pengguna', $idPengguna))
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('waktu', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('waktu', '<=', $sampai))
            ->orderByDesc('waktu')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }
}
