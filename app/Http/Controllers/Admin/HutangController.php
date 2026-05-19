<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\RiwayatPembayaranPembelian; // Asumsi lo udah bikin model & tabel ini
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    public function index()
    {
        // Tarik data pembelian yang sisa hutangnya LEBIH DARI 0
        // Sekalian bawa relasi supplier dan riwayat pembayarannya
        $hutangs = Pembelian::with(['supplier', 'riwayat_pembayarans'])
                    ->where('sisa_hutang', '>', 0)
                    ->latest()
                    ->paginate(20);
                    
        return view('admin.transaksi.hutang', compact('hutangs'));
    }

    public function bayarCicilan(Request $request, $id)
    {
        $request->validate([
            'nominal_bayar' => 'required|numeric|min:1',
            'metode_bayar' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::findOrFail($id);
            
            // 1. Catat ke tabel Riwayat Pembayaran (Biar muncul di modal Detail lo)
            RiwayatPembayaranPembelian::create([
                'pembelian_id' => $pembelian->id,
                'nominal_bayar' => $request->nominal_bayar,
                'tanggal_bayar' => now(),
                'metode_bayar' => $request->metode_bayar,
                'keterangan' => $request->keterangan ?? 'Pembayaran Cicilan Hutang'
            ]);

            // 2. Update saldo di tabel Pembelian utama
            $bayarBaru = $pembelian->bayar + $request->nominal_bayar;
            $sisaBaru = $pembelian->grand_total - $bayarBaru;

            $pembelian->update([
                'bayar' => $bayarBaru,
                'sisa_hutang' => $sisaBaru < 0 ? 0 : $sisaBaru,
                'status_pembayaran' => $sisaBaru <= 0 ? 'Lunas' : 'Hutang'
            ]);

            DB::commit();
            return back()->with('success', 'Pembayaran hutang berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mencatat pembayaran!']);
        }
    }
}