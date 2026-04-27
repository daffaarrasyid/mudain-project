<?php

namespace App\Services;

use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Hutang;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Models\Penjualan;
use App\Models\Piutang;
use App\Models\Produk;
use App\Models\Stok;
use App\Support\MudainCodeGenerator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaksiService
{
    public function __construct(
        protected KeuanganService $keuanganService,
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllPenjualan(array $filters = []): LengthAwarePaginator
    {
        return Penjualan::query()
            ->with(['pembeli', 'pengguna', 'detailPenjualan.produk', 'piutang'])
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where('id_penjualan', 'like', '%' . $search . '%')
                    ->orWhereHas('pembeli', fn (Builder $pembeli) => $pembeli->where('nama_pembeli', 'like', '%' . $search . '%'));
            })
            ->when($filters['dari'] ?? null, fn (Builder $query, string $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $query, string $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createPenjualan(array $data, Pengguna $pengguna): Penjualan
    {
        return DB::transaction(function () use ($data, $pengguna) {
            $items = $this->normalisasiItem($data['items'] ?? []);

            foreach ($items as $item) {
                $produk = Produk::findOrFail($item['id_produk']);

                if ($produk->stok_aktif < $item['jumlah']) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.',
                    ]);
                }
            }

            $idPenjualan = MudainCodeGenerator::forPenjualan();
            $total = collect($items)->sum(fn (array $item) => $item['jumlah'] * $item['harga']);

            $penjualan = Penjualan::create([
                'id_penjualan' => $idPenjualan,
                'id_pengguna' => $pengguna->id_pengguna,
                'id_pembeli' => $data['id_pembeli'] ?: null,
                'tanggal' => $data['tanggal'] ?? now(),
                'total' => $total,
                'status_pembayaran' => $data['status_pembayaran'] ?? 'tunai',
                'catatan' => $data['catatan'] ?? null,
            ]);

            foreach ($items as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['jumlah'] * $item['harga'],
                ]);

                Stok::create([
                    'id_produk' => $item['id_produk'],
                    'jumlah_masuk' => 0,
                    'jumlah_keluar' => $item['jumlah'],
                    'tanggal' => $penjualan->tanggal,
                    'keterangan' => 'Penjualan ' . $penjualan->id_penjualan,
                    'id_pengguna' => $pengguna->id_pengguna,
                ]);
            }

            if (($data['status_pembayaran'] ?? 'tunai') === 'piutang') {
                Piutang::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'jumlah_piutang' => $total,
                    'tanggal' => $penjualan->tanggal,
                    'status' => 'belum_lunas',
                    'jatuh_tempo' => $data['jatuh_tempo'] ?? null,
                ]);
            } else {
                $this->keuanganService->catatArusKas(
                    $penjualan->tanggal,
                    'penjualan',
                    'masuk',
                    $total,
                    $penjualan->id_penjualan,
                    'Penjualan ' . $penjualan->id_penjualan
                );
            }

            $penjualan->produksi()->create([
                'tanggal_produksi' => null,
                'jumlah_produksi' => collect($items)->sum('jumlah'),
                'status' => 'menunggu',
                'catatan' => 'Produksi otomatis dari penjualan',
            ]);

            $penjualan->desain()->create([
                'nama_desain' => $data['nama_desain'] ?? null,
                'deskripsi_desain' => $data['deskripsi_desain'] ?? null,
                'status_desain' => $data['nama_desain'] || $data['deskripsi_desain'] ? 'siap' : 'belum_diisi',
            ]);

            $this->keuanganService->syncLabaRugiByDate($penjualan->tanggal);

            $this->aktivitasService->catatAktivitas(
                'Membuat penjualan',
                'penjualan',
                $penjualan->id_penjualan,
                $pengguna->id_pengguna,
                json_encode($penjualan->load('detailPenjualan')->toArray())
            );

            return $penjualan->load(['pembeli', 'detailPenjualan.produk', 'piutang', 'produksi', 'desain']);
        });
    }

    public function getAllPembelian(array $filters = []): LengthAwarePaginator
    {
        return Pembelian::query()
            ->with(['pemasok', 'pengguna', 'detailPembelian.produk', 'hutang'])
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where('id_pembelian', 'like', '%' . $search . '%')
                    ->orWhereHas('pemasok', fn (Builder $pemasok) => $pemasok->where('nama_pemasok', 'like', '%' . $search . '%'));
            })
            ->when($filters['dari'] ?? null, fn (Builder $query, string $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $query, string $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createPembelian(array $data, Pengguna $pengguna): Pembelian
    {
        return DB::transaction(function () use ($data, $pengguna) {
            $items = $this->normalisasiItem($data['items'] ?? []);
            $idPembelian = MudainCodeGenerator::forPembelian();
            $total = collect($items)->sum(fn (array $item) => $item['jumlah'] * $item['harga']);

            $pembelian = Pembelian::create([
                'id_pembelian' => $idPembelian,
                'id_pemasok' => $data['id_pemasok'],
                'id_pengguna' => $pengguna->id_pengguna,
                'tanggal' => $data['tanggal'] ?? now(),
                'total' => $total,
                'status_pembayaran' => $data['status_pembayaran'] ?? 'tunai',
                'catatan' => $data['catatan'] ?? null,
            ]);

            foreach ($items as $item) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['jumlah'] * $item['harga'],
                ]);

                Stok::create([
                    'id_produk' => $item['id_produk'],
                    'jumlah_masuk' => $item['jumlah'],
                    'jumlah_keluar' => 0,
                    'tanggal' => $pembelian->tanggal,
                    'keterangan' => 'Pembelian ' . $pembelian->id_pembelian,
                    'id_pengguna' => $pengguna->id_pengguna,
                ]);
            }

            if (($data['status_pembayaran'] ?? 'tunai') === 'hutang') {
                Hutang::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'jumlah_hutang' => $total,
                    'tanggal' => $pembelian->tanggal,
                    'status' => 'belum_lunas',
                    'jatuh_tempo' => $data['jatuh_tempo'] ?? null,
                ]);
            } else {
                $this->keuanganService->catatArusKas(
                    $pembelian->tanggal,
                    'pembelian',
                    'keluar',
                    $total,
                    $pembelian->id_pembelian,
                    'Pembelian ' . $pembelian->id_pembelian
                );
            }

            $this->keuanganService->syncLabaRugiByDate($pembelian->tanggal);

            $this->aktivitasService->catatAktivitas(
                'Membuat pembelian',
                'pembelian',
                $pembelian->id_pembelian,
                $pengguna->id_pengguna,
                json_encode($pembelian->load('detailPembelian')->toArray())
            );

            return $pembelian->load(['pemasok', 'detailPembelian.produk', 'hutang']);
        });
    }

    protected function normalisasiItem(array $items): array
    {
        $normalized = collect($items)
            ->map(function (array $item) {
                return [
                    'id_produk' => $item['id_produk'] ?? null,
                    'jumlah' => (int) ($item['jumlah'] ?? 0),
                    'harga' => (float) ($item['harga'] ?? 0),
                ];
            })
            ->filter(fn (array $item) => $item['id_produk'] && $item['jumlah'] > 0 && $item['harga'] >= 0)
            ->values()
            ->all();

        if ($normalized === []) {
            throw ValidationException::withMessages([
                'items' => 'Minimal satu item transaksi harus diisi.',
            ]);
        }

        return $normalized;
    }
}
