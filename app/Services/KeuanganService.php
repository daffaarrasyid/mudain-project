<?php

namespace App\Services;

use App\Models\ArusKas;
use App\Models\Hutang;
use App\Models\LabaRugi;
use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use App\Models\PengeluaranLain;
use App\Models\Pengguna;
use App\Models\Piutang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KeuanganService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllHutang(array $filters = []): LengthAwarePaginator
    {
        return Hutang::query()
            ->with(['pembelian.pemasok', 'pembayaran'])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->whereHas('pembelian.pemasok', fn (Builder $pemasok) => $pemasok->where('nama_pemasok', 'like', '%' . $search . '%'));
            })
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function updateStatusHutang(Hutang $hutang, string $status, Pengguna $pengguna): Hutang
    {
        $hutang->update(['status' => $status]);

        $this->aktivitasService->catatAktivitas(
            'Mengubah status hutang',
            'hutang',
            $hutang->id_hutang,
            $pengguna->id_pengguna,
            $status
        );

        return $hutang->refresh();
    }

    public function bayarHutang(Hutang $hutang, array $data, Pengguna $pengguna): PembayaranHutang
    {
        $jumlahBayar = (float) $data['jumlah_bayar'];

        if ($jumlahBayar <= 0 || $jumlahBayar > $hutang->sisa) {
            throw ValidationException::withMessages([
                'jumlah_bayar' => 'Jumlah bayar hutang tidak valid.',
            ]);
        }

        return DB::transaction(function () use ($hutang, $data, $pengguna, $jumlahBayar) {
            $pembayaran = PembayaranHutang::create([
                'id_hutang' => $hutang->id_hutang,
                'jumlah_bayar' => $jumlahBayar,
                'tanggal' => $data['tanggal'] ?? now(),
                'keterangan' => $data['keterangan'] ?? null,
                'id_pengguna' => $pengguna->id_pengguna,
            ]);

            $terbayar = (float) $hutang->jumlah_terbayar + $jumlahBayar;
            $hutang->update([
                'jumlah_terbayar' => $terbayar,
                'status' => $terbayar >= (float) $hutang->jumlah_hutang ? 'lunas' : 'sebagian',
            ]);

            $this->catatArusKas(
                $pembayaran->tanggal,
                'pembayaran_hutang',
                'keluar',
                $jumlahBayar,
                (string) $hutang->id_hutang,
                'Pembayaran hutang ' . $hutang->id_pembelian
            );

            $this->aktivitasService->catatAktivitas(
                'Membayar hutang',
                'pembayaran_hutang',
                $pembayaran->id_bayar_hutang,
                $pengguna->id_pengguna,
                json_encode($pembayaran->toArray())
            );

            return $pembayaran;
        });
    }

    public function getAllPiutang(array $filters = []): LengthAwarePaginator
    {
        return Piutang::query()
            ->with(['penjualan.pembeli', 'pembayaran'])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->whereHas('penjualan.pembeli', fn (Builder $pembeli) => $pembeli->where('nama_pembeli', 'like', '%' . $search . '%'));
            })
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function updateStatusPiutang(Piutang $piutang, string $status, Pengguna $pengguna): Piutang
    {
        $piutang->update(['status' => $status]);

        $this->aktivitasService->catatAktivitas(
            'Mengubah status piutang',
            'piutang',
            $piutang->id_piutang,
            $pengguna->id_pengguna,
            $status
        );

        return $piutang->refresh();
    }

    public function bayarPiutang(Piutang $piutang, array $data, Pengguna $pengguna): PembayaranPiutang
    {
        $jumlahBayar = (float) $data['jumlah_bayar'];

        if ($jumlahBayar <= 0 || $jumlahBayar > $piutang->sisa) {
            throw ValidationException::withMessages([
                'jumlah_bayar' => 'Jumlah bayar piutang tidak valid.',
            ]);
        }

        return DB::transaction(function () use ($piutang, $data, $pengguna, $jumlahBayar) {
            $pembayaran = PembayaranPiutang::create([
                'id_piutang' => $piutang->id_piutang,
                'jumlah_bayar' => $jumlahBayar,
                'tanggal' => $data['tanggal'] ?? now(),
                'keterangan' => $data['keterangan'] ?? null,
                'id_pengguna' => $pengguna->id_pengguna,
            ]);

            $terbayar = (float) $piutang->jumlah_terbayar + $jumlahBayar;
            $piutang->update([
                'jumlah_terbayar' => $terbayar,
                'status' => $terbayar >= (float) $piutang->jumlah_piutang ? 'lunas' : 'sebagian',
            ]);

            $this->catatArusKas(
                $pembayaran->tanggal,
                'pembayaran_piutang',
                'masuk',
                $jumlahBayar,
                (string) $piutang->id_piutang,
                'Pembayaran piutang ' . $piutang->id_penjualan
            );

            $this->aktivitasService->catatAktivitas(
                'Menerima pembayaran piutang',
                'pembayaran_piutang',
                $pembayaran->id_bayar_piutang,
                $pengguna->id_pengguna,
                json_encode($pembayaran->toArray())
            );

            return $pembayaran;
        });
    }

    public function getArusKas(array $filters = []): LengthAwarePaginator
    {
        return ArusKas::query()
            ->when($filters['jenis'] ?? null, fn (Builder $query, string $jenis) => $query->where('jenis', $jenis))
            ->when($filters['dari'] ?? null, fn (Builder $query, string $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $query, string $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function hitungSaldoKas(array $filters = []): array
    {
        $query = ArusKas::query()
            ->when($filters['dari'] ?? null, fn (Builder $builder, string $dari) => $builder->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $builder, string $sampai) => $builder->whereDate('tanggal', '<=', $sampai));

        $masuk = (float) (clone $query)->where('arah', 'masuk')->sum('jumlah');
        $keluar = (float) (clone $query)->where('arah', 'keluar')->sum('jumlah');

        return [
            'masuk' => $masuk,
            'keluar' => $keluar,
            'saldo' => $masuk - $keluar,
        ];
    }

    public function getLabaRugi(array $filters = []): LengthAwarePaginator
    {
        return LabaRugi::query()
            ->when($filters['dari'] ?? null, fn (Builder $query, string $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $query, string $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 12)
            ->withQueryString();
    }

    public function hitungLabaRugi(array $filters = []): array
    {
        $query = LabaRugi::query()
            ->when($filters['dari'] ?? null, fn (Builder $builder, string $dari) => $builder->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $builder, string $sampai) => $builder->whereDate('tanggal', '<=', $sampai));

        return [
            'total_penjualan' => (float) (clone $query)->sum('total_penjualan'),
            'total_pembelian' => (float) (clone $query)->sum('total_pembelian'),
            'total_pengeluaran' => (float) (clone $query)->sum('total_pengeluaran'),
            'laba_rugi' => (float) (clone $query)->sum('laba_rugi'),
        ];
    }

    public function createPengeluaran(array $data, Pengguna $pengguna): PengeluaranLain
    {
        return DB::transaction(function () use ($data, $pengguna) {
            $pengeluaran = PengeluaranLain::create([
                ...$data,
                'id_pengguna' => $pengguna->id_pengguna,
            ]);

            $this->catatArusKas(
                $pengeluaran->tanggal,
                'pengeluaran_lain',
                'keluar',
                (float) $pengeluaran->jumlah_pengeluaran,
                (string) $pengeluaran->id_pengeluaran,
                $pengeluaran->keterangan
            );

            $this->syncLabaRugiByDate($pengeluaran->tanggal);

            $this->aktivitasService->catatAktivitas(
                'Menambah pengeluaran lain',
                'pengeluaran_lain',
                $pengeluaran->id_pengeluaran,
                $pengguna->id_pengguna,
                json_encode($pengeluaran->toArray())
            );

            return $pengeluaran;
        });
    }

    public function updatePengeluaran(PengeluaranLain $pengeluaran, array $data, Pengguna $pengguna): PengeluaranLain
    {
        return DB::transaction(function () use ($pengeluaran, $data, $pengguna) {
            $tanggalLama = $pengeluaran->tanggal;
            $pengeluaran->update($data);

            ArusKas::query()
                ->where('jenis', 'pengeluaran_lain')
                ->where('referensi_id', (string) $pengeluaran->id_pengeluaran)
                ->update([
                    'tanggal' => $pengeluaran->tanggal,
                    'jumlah' => $pengeluaran->jumlah_pengeluaran,
                    'keterangan' => $pengeluaran->keterangan,
                ]);

            $this->syncLabaRugiByDate($tanggalLama);
            $this->syncLabaRugiByDate($pengeluaran->tanggal);

            $this->aktivitasService->catatAktivitas(
                'Memperbarui pengeluaran lain',
                'pengeluaran_lain',
                $pengeluaran->id_pengeluaran,
                $pengguna->id_pengguna,
                json_encode($pengeluaran->fresh()->toArray())
            );

            return $pengeluaran->refresh();
        });
    }

    public function deletePengeluaran(PengeluaranLain $pengeluaran, Pengguna $pengguna): void
    {
        DB::transaction(function () use ($pengeluaran, $pengguna) {
            $tanggal = $pengeluaran->tanggal;

            ArusKas::query()
                ->where('jenis', 'pengeluaran_lain')
                ->where('referensi_id', (string) $pengeluaran->id_pengeluaran)
                ->delete();

            $this->aktivitasService->catatAktivitas(
                'Menghapus pengeluaran lain',
                'pengeluaran_lain',
                $pengeluaran->id_pengeluaran,
                $pengguna->id_pengguna,
                json_encode($pengeluaran->toArray())
            );

            $pengeluaran->delete();
            $this->syncLabaRugiByDate($tanggal);
        });
    }

    public function getAllPengeluaran(array $filters = []): LengthAwarePaginator
    {
        return PengeluaranLain::query()
            ->with('pengguna')
            ->when($filters['search'] ?? null, fn (Builder $query, string $search) => $query->where('keterangan', 'like', '%' . $search . '%'))
            ->when($filters['dari'] ?? null, fn (Builder $query, string $dari) => $query->whereDate('tanggal', '>=', $dari))
            ->when($filters['sampai'] ?? null, fn (Builder $query, string $sampai) => $query->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function syncLabaRugiByDate(Carbon|string $tanggal): LabaRugi
    {
        $tanggal = Carbon::parse($tanggal)->toDateString();

        $totalPenjualan = (float) DB::table('penjualan')->whereDate('tanggal', $tanggal)->sum('total');
        $totalPembelian = (float) DB::table('pembelian')->whereDate('tanggal', $tanggal)->sum('total');
        $totalPengeluaran = (float) DB::table('pengeluaran_lain')->whereDate('tanggal', $tanggal)->sum('jumlah_pengeluaran');
        $labaRugi = $totalPenjualan - $totalPembelian - $totalPengeluaran;

        return LabaRugi::updateOrCreate(
            ['tanggal' => $tanggal],
            [
                'total_penjualan' => $totalPenjualan,
                'total_pembelian' => $totalPembelian,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_rugi' => $labaRugi,
            ]
        );
    }

    public function catatArusKas(
        Carbon|string $tanggal,
        string $jenis,
        string $arah,
        float $jumlah,
        ?string $referensiId = null,
        ?string $keterangan = null
    ): ArusKas {
        return ArusKas::create([
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'arah' => $arah,
            'jumlah' => $jumlah,
            'referensi_tipe' => $jenis,
            'referensi_id' => $referensiId,
            'keterangan' => $keterangan,
        ]);
    }
}
