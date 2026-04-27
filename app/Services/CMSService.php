<?php

namespace App\Services;

use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Portofolio;
use App\Models\ProdukProfil;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CMSService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllMitra(array $filters = []): LengthAwarePaginator
    {
        return Mitra::query()
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('nama_mitra', 'like', '%' . $search . '%'))
            ->orderBy('nama_mitra')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createMitra(array $data, Pengguna $pengguna): Mitra
    {
        $mitra = Mitra::create([...$data, 'id_pengguna' => $pengguna->id_pengguna]);
        $this->log('Membuat mitra', 'mitra', $mitra->id_mitra, $pengguna, $mitra->toArray());

        return $mitra;
    }

    public function updateMitra(Mitra $mitra, array $data, Pengguna $pengguna): Mitra
    {
        $mitra->update($data);
        $this->log('Memperbarui mitra', 'mitra', $mitra->id_mitra, $pengguna, $mitra->fresh()->toArray());

        return $mitra->refresh();
    }

    public function deleteMitra(Mitra $mitra, Pengguna $pengguna): void
    {
        $this->log('Menghapus mitra', 'mitra', $mitra->id_mitra, $pengguna, $mitra->toArray());
        $mitra->delete();
    }

    public function getAllPortofolio(array $filters = []): LengthAwarePaginator
    {
        return Portofolio::query()
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('judul', 'like', '%' . $search . '%'))
            ->orderByDesc('created_at')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createPortofolio(array $data, Pengguna $pengguna): Portofolio
    {
        $portofolio = Portofolio::create([...$data, 'id_pengguna' => $pengguna->id_pengguna]);
        $this->log('Membuat portofolio', 'portofolio', $portofolio->id_portofolio, $pengguna, $portofolio->toArray());

        return $portofolio;
    }

    public function updatePortofolio(Portofolio $portofolio, array $data, Pengguna $pengguna): Portofolio
    {
        $portofolio->update($data);
        $this->log('Memperbarui portofolio', 'portofolio', $portofolio->id_portofolio, $pengguna, $portofolio->fresh()->toArray());

        return $portofolio->refresh();
    }

    public function deletePortofolio(Portofolio $portofolio, Pengguna $pengguna): void
    {
        $this->log('Menghapus portofolio', 'portofolio', $portofolio->id_portofolio, $pengguna, $portofolio->toArray());
        $portofolio->delete();
    }

    public function getAllProdukProfil(array $filters = []): LengthAwarePaginator
    {
        return ProdukProfil::query()
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('nama_produk', 'like', '%' . $search . '%'))
            ->orderBy('nama_produk')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createProdukProfil(array $data, Pengguna $pengguna): ProdukProfil
    {
        $produk = ProdukProfil::create([...$data, 'id_pengguna' => $pengguna->id_pengguna]);
        $this->log('Membuat produk profil', 'produk_profil', $produk->id_produk_profil, $pengguna, $produk->toArray());

        return $produk;
    }

    public function updateProdukProfil(ProdukProfil $produk, array $data, Pengguna $pengguna): ProdukProfil
    {
        $produk->update($data);
        $this->log('Memperbarui produk profil', 'produk_profil', $produk->id_produk_profil, $pengguna, $produk->fresh()->toArray());

        return $produk->refresh();
    }

    public function deleteProdukProfil(ProdukProfil $produk, Pengguna $pengguna): void
    {
        $this->log('Menghapus produk profil', 'produk_profil', $produk->id_produk_profil, $pengguna, $produk->toArray());
        $produk->delete();
    }

    protected function log(string $aksi, string $tabel, int $id, Pengguna $pengguna, array $payload): void
    {
        $this->aktivitasService->catatAktivitas($aksi, $tabel, $id, $pengguna->id_pengguna, json_encode($payload));
    }
}
