<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Kas;
use App\Models\Histori;
use App\Models\PenjualanDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Ringkasan Counter Atas
        $totalProduk = Produk::count();
        $totalSupplier = Supplier::count();
        $totalCustomer = Customer::count();
        $penjualanHariIni = Penjualan::whereDate('created_at', Carbon::today())->count();
        
        // Data Ringkasan Kas
        $kasMasukHariIni = Kas::whereDate('created_at', Carbon::today())->where('tipe', 'Masuk')->sum('nominal');
        $kasKeluarHariIni = Kas::whereDate('created_at', Carbon::today())->where('tipe', 'Keluar')->sum('nominal');

        // History Login Pengguna (4 Terakhir)
        $historis = Histori::with('user.role')->latest()->take(4)->get();
    
        return view('admin.dashboard', compact(
            'totalProduk', 'totalSupplier', 'totalCustomer', 
            'penjualanHariIni', 'kasMasukHariIni', 'kasKeluarHariIni', 'historis'
        ));
    }

    // Endpoint API untuk Filter Tiap Grafik
    public function chartData(Request $request)
    {
        $chartType = $request->chart;
        $filter = $request->filter ?? 'bulan_ini';

        $awal = Carbon::now()->startOfMonth();
        $akhir = Carbon::now()->endOfMonth();

        if ($filter == 'minggu_ini') {
            $awal = Carbon::now()->startOfWeek(); $akhir = Carbon::now()->endOfWeek();
        } elseif ($filter == 'tahun_ini') {
            $awal = Carbon::now()->startOfYear(); $akhir = Carbon::now()->endOfYear();
        }

        if ($chartType == 'pendapatan') {
            $kas = Kas::whereBetween('created_at', [$awal, $akhir])->get();
            $labels = []; $masuk = []; $keluar = [];
            
            $format = $filter == 'tahun_ini' ? 'M Y' : 'd M';
            foreach ($kas->groupBy(fn($item) => $item->created_at->format($format)) as $date => $val) {
                $labels[] = $date;
                $masuk[] = $val->where('tipe', 'Masuk')->sum('nominal');
                $keluar[] = $val->where('tipe', 'Keluar')->sum('nominal');
            }
            return response()->json(['labels' => $labels, 'datasets' => [['data' => $masuk], ['data' => $keluar]]]);
        }

        if ($chartType == 'kategori') {
            // Asumsi Kategori 1 = Percetakan, 2 = Konveksi sesuai di DB lo
            $kategoriData = collect([
                'Percetakan' => PenjualanDetail::whereBetween('penjualan_details.created_at', [$awal, $akhir])
                                ->join('produks', 'penjualan_details.produk_id', '=', 'produks.id')
                                ->where('produks.kategori_id', 1)->sum('qty'),
                'Konveksi' => PenjualanDetail::whereBetween('penjualan_details.created_at', [$awal, $akhir])
                                ->join('produks', 'penjualan_details.produk_id', '=', 'produks.id')
                                ->where('produks.kategori_id', 2)->sum('qty'),
            ]);
            return response()->json(['labels' => $kategoriData->keys(), 'data' => $kategoriData->values()]);
        }

        if ($chartType == 'kas') {
            $masuk = Kas::whereBetween('created_at', [$awal, $akhir])->where('tipe', 'Masuk')->sum('nominal');
            $keluar = Kas::whereBetween('created_at', [$awal, $akhir])->where('tipe', 'Keluar')->sum('nominal');
            return response()->json(['labels' => ['Kas Masuk', 'Kas Keluar'], 'data' => [$masuk, $keluar]]);
        }
    }
}