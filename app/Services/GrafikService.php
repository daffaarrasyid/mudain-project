<?php

namespace App\Services;

use App\Models\ArusKas;
use App\Models\LabaRugi;
use App\Models\Penjualan;
use Illuminate\Support\Carbon;

class GrafikService
{
    public function dataGrafikArusKas(array $filters = []): array
    {
        $labels = $this->labelsBulanan();
        $rows = ArusKas::query()
            ->when($filters['tahun'] ?? null, fn ($query, $tahun) => $query->whereYear('tanggal', $tahun))
            ->selectRaw('MONTH(tanggal) as bulan, arah, SUM(jumlah) as total')
            ->groupByRaw('MONTH(tanggal), arah')
            ->get()
            ->groupBy('bulan');

        return [
            'labels' => $labels,
            'masuk' => collect(range(1, 12))->map(fn (int $bulan) => (float) ($rows->get($bulan)?->firstWhere('arah', 'masuk')?->total ?? 0))->all(),
            'keluar' => collect(range(1, 12))->map(fn (int $bulan) => (float) ($rows->get($bulan)?->firstWhere('arah', 'keluar')?->total ?? 0))->all(),
        ];
    }

    public function dataGrafikPenjualan(array $filters = []): array
    {
        $labels = $this->labelsBulanan();
        $rows = Penjualan::query()
            ->when($filters['tahun'] ?? null, fn ($query, $tahun) => $query->whereYear('tanggal', $tahun))
            ->selectRaw('MONTH(tanggal) as bulan, SUM(total) as total')
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        return [
            'labels' => $labels,
            'data' => collect(range(1, 12))->map(fn (int $bulan) => (float) ($rows->get($bulan) ?? 0))->all(),
        ];
    }

    public function dataGrafikLabaRugi(array $filters = []): array
    {
        $labels = $this->labelsBulanan();
        $rows = LabaRugi::query()
            ->when($filters['tahun'] ?? null, fn ($query, $tahun) => $query->whereYear('tanggal', $tahun))
            ->selectRaw('MONTH(tanggal) as bulan, SUM(laba_rugi) as total')
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        return [
            'labels' => $labels,
            'data' => collect(range(1, 12))->map(fn (int $bulan) => (float) ($rows->get($bulan) ?? 0))->all(),
        ];
    }

    public function filterByPeriode(?string $dari = null, ?string $sampai = null): array
    {
        return [
            'dari' => $dari ? Carbon::parse($dari)->toDateString() : now()->startOfMonth()->toDateString(),
            'sampai' => $sampai ? Carbon::parse($sampai)->toDateString() : now()->endOfMonth()->toDateString(),
        ];
    }

    protected function labelsBulanan(): array
    {
        return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    }
}
