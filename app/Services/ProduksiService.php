<?php

namespace App\Services;

use App\Models\Desain;
use App\Models\Pengguna;
use App\Models\Produksi;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProduksiService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllProduksi(array $filters = []): LengthAwarePaginator
    {
        return Produksi::query()
            ->with('penjualan.pembeli')
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->orderByDesc('updated_at')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function updateProduksi(Produksi $produksi, array $data, Pengguna $pengguna): Produksi
    {
        $produksi->update($data);

        $this->aktivitasService->catatAktivitas(
            'Memperbarui produksi',
            'produksi',
            $produksi->id_produksi,
            $pengguna->id_pengguna,
            json_encode($produksi->fresh()->toArray())
        );

        return $produksi->refresh();
    }

    public function getAllDesain(array $filters = []): LengthAwarePaginator
    {
        return Desain::query()
            ->with('penjualan.pembeli')
            ->when($filters['status_desain'] ?? null, fn ($query, $status) => $query->where('status_desain', $status))
            ->orderByDesc('updated_at')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function updateDesain(Desain $desain, array $data, Pengguna $pengguna): Desain
    {
        $desain->update($data);

        $this->aktivitasService->catatAktivitas(
            'Memperbarui desain',
            'desain',
            $desain->id_desain,
            $pengguna->id_pengguna,
            json_encode($desain->fresh()->toArray())
        );

        return $desain->refresh();
    }
}
