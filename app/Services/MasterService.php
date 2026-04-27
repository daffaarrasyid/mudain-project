<?php

namespace App\Services;

use App\Models\Kategori;
use App\Models\Pembeli;
use App\Models\Pemasok;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Stok;
use App\Support\MudainCodeGenerator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MasterService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllProduk(array $filters = []): LengthAwarePaginator
    {
        return Produk::query()
            ->with(['kategori', 'satuan', 'pemasok', 'stok'])
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested->where('id_produk', 'like', '%' . $search . '%')
                        ->orWhere('nama_produk', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['id_kategori'] ?? null, fn (Builder $query, $idKategori) => $query->where('id_kategori', $idKategori))
            ->orderBy('nama_produk')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createProduk(array $data, Pengguna $pengguna): Produk
    {
        $data['id_produk'] = $data['id_produk'] ?? MudainCodeGenerator::forProduk();
        $data['id_pengguna'] = $pengguna->id_pengguna;

        $produk = Produk::create($data);

        $this->aktivitasService->catatAktivitas(
            'Membuat produk',
            'produk',
            $produk->id_produk,
            $pengguna->id_pengguna,
            json_encode($produk->toArray())
        );

        return $produk;
    }

    public function updateProduk(Produk $produk, array $data, Pengguna $pengguna): Produk
    {
        $produk->update($data);

        $this->aktivitasService->catatAktivitas(
            'Memperbarui produk',
            'produk',
            $produk->id_produk,
            $pengguna->id_pengguna,
            json_encode($produk->fresh()->toArray())
        );

        return $produk->refresh();
    }

    public function deleteProduk(Produk $produk, Pengguna $pengguna): void
    {
        $this->aktivitasService->catatAktivitas(
            'Menghapus produk',
            'produk',
            $produk->id_produk,
            $pengguna->id_pengguna,
            json_encode($produk->toArray())
        );

        $produk->delete();
    }

    public function getAllKategori(array $filters = []): LengthAwarePaginator
    {
        return $this->paginatedSimpleResource(Kategori::query()->with('pengguna'), $filters, 'nama_kategori');
    }

    public function createKategori(array $data, Pengguna $pengguna): Kategori
    {
        return $this->createSimpleResource(new Kategori(), $data, $pengguna, 'nama_kategori', 'kategori');
    }

    public function updateKategori(Kategori $kategori, array $data, Pengguna $pengguna): Kategori
    {
        return $this->updateSimpleResource($kategori, $data, $pengguna, 'kategori');
    }

    public function deleteKategori(Kategori $kategori, Pengguna $pengguna): void
    {
        $this->deleteSimpleResource($kategori, $pengguna, 'kategori');
    }

    public function getAllSatuan(array $filters = []): LengthAwarePaginator
    {
        return $this->paginatedSimpleResource(Satuan::query()->with('pengguna'), $filters, 'nama_satuan');
    }

    public function createSatuan(array $data, Pengguna $pengguna): Satuan
    {
        return $this->createSimpleResource(new Satuan(), $data, $pengguna, 'nama_satuan', 'satuan');
    }

    public function updateSatuan(Satuan $satuan, array $data, Pengguna $pengguna): Satuan
    {
        return $this->updateSimpleResource($satuan, $data, $pengguna, 'satuan');
    }

    public function deleteSatuan(Satuan $satuan, Pengguna $pengguna): void
    {
        $this->deleteSimpleResource($satuan, $pengguna, 'satuan');
    }

    public function getAllPemasok(array $filters = []): LengthAwarePaginator
    {
        return $this->paginatedSimpleResource(Pemasok::query()->with('pengguna'), $filters, 'nama_pemasok');
    }

    public function createPemasok(array $data, Pengguna $pengguna): Pemasok
    {
        return $this->createSimpleResource(new Pemasok(), $data, $pengguna, 'nama_pemasok', 'pemasok');
    }

    public function updatePemasok(Pemasok $pemasok, array $data, Pengguna $pengguna): Pemasok
    {
        return $this->updateSimpleResource($pemasok, $data, $pengguna, 'pemasok');
    }

    public function deletePemasok(Pemasok $pemasok, Pengguna $pengguna): void
    {
        $this->deleteSimpleResource($pemasok, $pengguna, 'pemasok');
    }

    public function getAllPembeli(array $filters = []): LengthAwarePaginator
    {
        return $this->paginatedSimpleResource(Pembeli::query()->with('pengguna'), $filters, 'nama_pembeli');
    }

    public function createPembeli(array $data, Pengguna $pengguna): Pembeli
    {
        return $this->createSimpleResource(new Pembeli(), $data, $pengguna, 'nama_pembeli', 'pembeli');
    }

    public function updatePembeli(Pembeli $pembeli, array $data, Pengguna $pengguna): Pembeli
    {
        return $this->updateSimpleResource($pembeli, $data, $pengguna, 'pembeli');
    }

    public function deletePembeli(Pembeli $pembeli, Pengguna $pengguna): void
    {
        $this->deleteSimpleResource($pembeli, $pengguna, 'pembeli');
    }

    public function tambahStokMasuk(array $data, Pengguna $pengguna): Stok
    {
        return $this->buatPergerakanStok($data, $pengguna, 'masuk');
    }

    public function tambahStokKeluar(array $data, Pengguna $pengguna): Stok
    {
        $produk = Produk::findOrFail($data['id_produk']);
        $qty = (int) $data['jumlah_keluar'];

        if ($produk->stok_aktif < $qty) {
            throw ValidationException::withMessages([
                'jumlah_keluar' => 'Stok tidak mencukupi untuk pengeluaran.',
            ]);
        }

        return $this->buatPergerakanStok($data, $pengguna, 'keluar');
    }

    public function getStok(array $filters = []): LengthAwarePaginator
    {
        return Stok::query()
            ->with(['produk.kategori', 'pengguna'])
            ->when($filters['id_produk'] ?? null, fn (Builder $query, $idProduk) => $query->where('id_produk', $idProduk))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->whereHas('produk', fn (Builder $produk) => $produk->where('nama_produk', 'like', '%' . $search . '%'));
            })
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    protected function paginatedSimpleResource(Builder $query, array $filters, string $column): LengthAwarePaginator
    {
        return $query
            ->when($filters['search'] ?? null, fn (Builder $builder, string $search) => $builder->where($column, 'like', '%' . $search . '%'))
            ->orderBy($column)
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    protected function createSimpleResource(object $model, array $data, Pengguna $pengguna, string $labelColumn, string $table)
    {
        $data['id_pengguna'] = $pengguna->id_pengguna;
        $instance = $model::create($data);

        $this->aktivitasService->catatAktivitas(
            'Membuat ' . $table,
            $table,
            $instance->getKey(),
            $pengguna->id_pengguna,
            $instance->{$labelColumn}
        );

        return $instance;
    }

    protected function updateSimpleResource(object $model, array $data, Pengguna $pengguna, string $table)
    {
        $model->update($data);

        $this->aktivitasService->catatAktivitas(
            'Memperbarui ' . $table,
            $table,
            $model->getKey(),
            $pengguna->id_pengguna,
            json_encode($model->fresh()->toArray())
        );

        return $model->refresh();
    }

    protected function deleteSimpleResource(object $model, Pengguna $pengguna, string $table): void
    {
        $this->aktivitasService->catatAktivitas(
            'Menghapus ' . $table,
            $table,
            $model->getKey(),
            $pengguna->id_pengguna,
            json_encode($model->toArray())
        );

        $model->delete();
    }

    protected function buatPergerakanStok(array $data, Pengguna $pengguna, string $arah): Stok
    {
        return DB::transaction(function () use ($data, $pengguna, $arah) {
            $stok = Stok::create([
                'id_produk' => $data['id_produk'],
                'jumlah_masuk' => $arah === 'masuk' ? (int) ($data['jumlah_masuk'] ?? 0) : 0,
                'jumlah_keluar' => $arah === 'keluar' ? (int) ($data['jumlah_keluar'] ?? 0) : 0,
                'tanggal' => $data['tanggal'] ?? now(),
                'keterangan' => $data['keterangan'] ?? 'Penyesuaian manual stok',
                'id_pengguna' => $pengguna->id_pengguna,
            ]);

            $this->aktivitasService->catatAktivitas(
                'Mencatat pergerakan stok ' . $arah,
                'stok',
                $stok->id_stok,
                $pengguna->id_pengguna,
                json_encode($stok->toArray())
            );

            return $stok;
        });
    }
}
