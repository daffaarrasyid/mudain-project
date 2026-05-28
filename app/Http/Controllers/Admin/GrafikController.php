<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Carbon\Carbon;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        // 1. FILTER GLOBAL
        $periode = $request->periode ?? 'bulan_ini';
        
        $awal = Carbon::now()->startOfMonth();
        $akhir = Carbon::now()->endOfMonth();

        if ($periode == 'hari_ini') {
            $awal = Carbon::today();
            $akhir = Carbon::today()->endOfDay();
        } elseif ($periode == 'minggu_ini') {
            $awal = Carbon::now()->startOfWeek();
            $akhir = Carbon::now()->endOfWeek();
        } elseif ($periode == 'tahun_ini') {
            $awal = Carbon::now()->startOfYear();
            $akhir = Carbon::now()->endOfYear();
        }

        // 2. DATA PENDAPATAN VS PENGELUARAN (LINE CHART)
        $dataKas = Kas::getDynamicKas($awal, $akhir);
        $totalMasuk = $dataKas->where('tipe', 'Masuk')->sum('nominal');
        $totalKeluar = $dataKas->where('tipe', 'Keluar')->sum('nominal');

        $chartPendapatan = ['labels' => [], 'masuk' => [], 'keluar' => []];
        $formatGroup = $periode == 'tahun_ini' ? 'M Y' : 'd M';
        
        $groupedKas = $dataKas->groupBy(function($item) use ($formatGroup) {
            return $item->created_at->format($formatGroup);
        });

        foreach ($groupedKas as $date => $items) {
            $chartPendapatan['labels'][] = $date;
            $chartPendapatan['masuk'][] = $items->where('tipe', 'Masuk')->sum('nominal');
            $chartPendapatan['keluar'][] = $items->where('tipe', 'Keluar')->sum('nominal');
        }

        // 3. DATA KATEGORI: KONVEKSI VS PERCETAKAN (BAR CHART)
        $kategoriData = PenjualanDetail::with('produk.kategori')
            ->whereNotNull('produk_id')
            ->whereBetween('created_at', [$awal, $akhir])
            ->get()
            ->groupBy(function($detail) {
                return optional($detail->produk->kategori)->nama_kategori ?? 'Lainnya';
            });

        $chartKategori = [
            'Konveksi' => $kategoriData->has('Konveksi') ? $kategoriData['Konveksi']->sum('qty') : 0,
            'Percetakan' => $kategoriData->has('Percetakan') ? $kategoriData['Percetakan']->sum('qty') : 0,
        ];

        // 4. DATA BARANG TERLARIS (BAR CHART)
        $terlaris = PenjualanDetail::with('produk')
            ->whereBetween('created_at', [$awal, $akhir])
            ->selectRaw('produk_id, sum(qty) as total_qty')
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        $chartTerlaris = ['labels' => [], 'data' => []];
        foreach ($terlaris as $item) {
            $chartTerlaris['labels'][] = $item->produk->nama_item ?? 'Produk Dihapus';
            $chartTerlaris['data'][] = $item->total_qty;
        }

        // 5. INSIGHT BARU: STATUS PEMBAYARAN / PIUTANG (DOUGHNUT CHART)
        $pembayaran = Penjualan::whereBetween('created_at', [$awal, $akhir])->get();
        $chartPembayaran = [
            'Lunas' => $pembayaran->where('status_pembayaran', 'Lunas')->count(),
            'Kredit' => $pembayaran->whereIn('status_pembayaran', ['Kredit', 'Belum Lunas'])->count(),
        ];

        return view('admin.grafik.index', compact(
            'periode', 'chartPendapatan', 'totalMasuk', 'totalKeluar', 'chartTerlaris', 'chartKategori', 'chartPembayaran'
        ));
    }
}