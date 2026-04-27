<?php

namespace App\Services;

use App\Models\ArusKas;
use App\Models\Hutang;
use App\Models\LabaRugi;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Piutang;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanService
{
    public function generateLaporanBarang(array $filters = [])
    {
        return Produk::query()
            ->with(['kategori', 'satuan', 'pemasok', 'stok'])
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('nama_produk', 'like', '%' . $search . '%'))
            ->orderBy('nama_produk')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanPenjualan(array $filters = [])
    {
        return Penjualan::query()
            ->with(['pembeli', 'detailPenjualan.produk'])
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanPembelian(array $filters = [])
    {
        return Pembelian::query()
            ->with(['pemasok', 'detailPembelian.produk'])
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanLabaRugi(array $filters = [])
    {
        return LabaRugi::query()
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanArusKas(array $filters = [])
    {
        return ArusKas::query()
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanStokInOut(array $filters = [])
    {
        return Stok::query()
            ->with('produk')
            ->when($filters['dari'] ?? null, fn ($query, $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn ($query, $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanPiutang(array $filters = [])
    {
        return Piutang::query()
            ->with('penjualan.pembeli')
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateLaporanHutang(array $filters = [])
    {
        return Hutang::query()
            ->with('pembelian.pemasok')
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function generateBarcode(string $idProduk): array
    {
        $produk = Produk::findOrFail($idProduk);
        $source = strtoupper($produk->id_produk);
        $bars = collect(str_split($source))
            ->map(function (string $char) {
                $binary = str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);

                return collect(str_split($binary))
                    ->map(fn (string $bit) => $bit === '1' ? '||' : '|')
                    ->implode('');
            })
            ->implode(' ');

        return [
            'produk' => $produk,
            'bars' => $bars,
        ];
    }

    public function backupDatabase(): array
    {
        $tables = [
            'role', 'pengguna', 'kategori', 'satuan', 'pemasok', 'pembeli', 'produk',
            'stok', 'penjualan', 'detail_penjualan', 'pembelian', 'detail_pembelian',
            'hutang', 'piutang', 'pembayaran_hutang', 'pembayaran_piutang',
            'pengeluaran_lain', 'arus_kas', 'laba_rugi', 'produksi', 'desain',
            'aktivitas', 'portofolio', 'mitra', 'produk_profil',
        ];

        $payload = [
            'dibuat_pada' => now()->toDateTimeString(),
            'aplikasi' => config('app.name', 'Mudain'),
            'tabel' => collect($tables)->mapWithKeys(fn (string $table) => [$table => DB::table($table)->get()])->all(),
        ];

        $filename = 'backups/mudain-backup-' . now()->format('Ymd-His') . '.json';
        Storage::disk('local')->put($filename, json_encode($payload, JSON_PRETTY_PRINT));

        return [
            'filename' => $filename,
            'url' => route('admin.tools.backup-data.download', ['path' => $filename]),
        ];
    }
}
