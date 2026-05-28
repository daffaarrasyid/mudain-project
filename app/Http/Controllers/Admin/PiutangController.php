<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\RiwayatPembayaranPenjualan;
use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Tarik data penjualan yang kembaliannya minus (artinya ngutang/kurang bayar), 
        // atau yang punya riwayat pembayaran (untuk nampilin yang udah lunas dari hasil cicilan).
        $piutangs = Penjualan::with(['customer', 'riwayat_pembayarans'])
                    ->where('kembalian', '<', 0)
                    ->orWhereHas('riwayat_pembayarans')
                    ->latest()
                    ->paginate($perPage)
                    ->withQueryString();
                    
        return view('admin.transaksi.piutang', compact('piutangs'));
    }

    // Fungsi untuk catat cicilan customer (Modal Payment)
    public function bayarCicilan(Request $request, $id)
    {
        $request->validate([
            'nominal_bayar' => 'required|numeric|min:1'
        ]);

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($id);
            
            // Catat ke histori
            RiwayatPembayaranPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'nominal_bayar' => $request->nominal_bayar,
                'tanggal_bayar' => now(),
                'keterangan' => $request->keterangan ?? 'Pembayaran Cicilan'
            ]);

            // Update master penjualan
            $bayarBaru = $penjualan->bayar + $request->nominal_bayar;
            $kembalianBaru = $bayarBaru - $penjualan->total_harga; // Kalau minus berarti masih kurang (Piutang)

            $penjualan->update([
                'bayar' => $bayarBaru,
                'kembalian' => $kembalianBaru,
                'status_pembayaran' => $bayarBaru >= $penjualan->total_harga ? 'Lunas' : 'Kredit'
            ]);

            DB::commit();
            return back()->with('success', 'Pembayaran piutang dari customer berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mencatat pembayaran!']);
        }
    }

    // Fungsi untuk update data master (Modal Update)
    public function updateMaster(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        
        $kembalianBaru = $request->bayar - $request->total_harga;
        
        $penjualan->update([
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
            'kembalian' => $kembalianBaru,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status_pembayaran' => $kembalianBaru >= 0 ? 'Lunas' : 'Kredit'
        ]);

        return back()->with('success', 'Data piutang berhasil di-update manual!');
    }
}