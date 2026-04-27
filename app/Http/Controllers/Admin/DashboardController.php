<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\ArusKas;
use App\Models\Kategori;
use App\Models\Pembeli;
use App\Models\Pemasok;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Services\GrafikService;
use App\Services\KeuanganService;

class DashboardController extends Controller
{
    public function index(GrafikService $grafikService, KeuanganService $keuanganService)
    {
        $hariIni = now()->toDateString();
        $saldoKas = $keuanganService->hitungSaldoKas();
        $chartArusKas = $grafikService->dataGrafikArusKas(['tahun' => now()->year]);
        $chartPenjualan = $grafikService->dataGrafikPenjualan(['tahun' => now()->year]);
        $chartLabaRugi = $grafikService->dataGrafikLabaRugi(['tahun' => now()->year]);

        return view('admin.dashboard', [
            'ringkasan' => [
                'produk' => Produk::count(),
                'pemasok' => Pemasok::count(),
                'pembeli' => Pembeli::count(),
                'penjualan_hari_ini' => Penjualan::whereDate('tanggal', $hariIni)->count(),
                'kas_masuk_hari_ini' => (float) ArusKas::where('arah', 'masuk')->whereDate('tanggal', $hariIni)->sum('jumlah'),
                'kas_keluar_hari_ini' => (float) ArusKas::where('arah', 'keluar')->whereDate('tanggal', $hariIni)->sum('jumlah'),
                'saldo_kas' => $saldoKas['saldo'],
            ],
            'aktivitas' => Aktivitas::with('pengguna.role')->latest('waktu')->take(6)->get(),
            'chartArusKas' => $chartArusKas,
            'chartPenjualan' => $chartPenjualan,
            'chartLabaRugi' => $chartLabaRugi,
            'kategoriChart' => Kategori::query()->withCount('produk')->orderByDesc('produk_count')->take(6)->get(),
        ]);
    }
}
