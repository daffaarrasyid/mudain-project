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
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Tarik data pembelian yang sisa hutangnya LEBIH DARI 0
        // Sekalian bawa relasi supplier dan riwayat pembayarannya
        $hutangs = Pembelian::with(['supplier', 'riwayat_pembayarans'])
                    ->where('sisa_hutang', '>', 0)
                    ->latest()
                    ->paginate($perPage)
                    ->withQueryString();
                    
        return view('admin.transaksi.hutang', compact('hutangs'));
    }

    public function bayarCicilan(Request $request, $id)
    {
        $request->validate([
            'nominal_bayar' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::findOrFail($id);
            
            $sisaHutang = (float) $pembelian->sisa_hutang;
            $nominalBayar = min((float) $request->nominal_bayar, $sisaHutang);

            // 1. Catat ke tabel Riwayat Pembayaran (Biar muncul di modal Detail lo)
            RiwayatPembayaranPembelian::create([
                'pembelian_id' => $pembelian->id,
                'nominal_bayar' => $nominalBayar,
                'tanggal_bayar' => now(),
                'metode_bayar' => $request->metode_bayar ?? 'Cash / Tunai',
                'keterangan' => $request->keterangan ?? 'Pembayaran Cicilan Hutang'
            ]);

            // 2. Update saldo di tabel Pembelian utama
            $bayarBaru = (float) $pembelian->bayar + $nominalBayar;
            $sisaBaru = max(0.0, (float) $pembelian->grand_total - $bayarBaru);

            $pembelian->update([
                'bayar' => $bayarBaru,
                'sisa_hutang' => $sisaBaru,
                'status_pembayaran' => $sisaBaru <= 0 ? 'Lunas' : 'Hutang'
            ]);

            DB::commit();
            return back()->with('success', 'Pembayaran hutang berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mencatat pembayaran!']);
        }
    }

    // Fungsi untuk update data master secara manual (Modal Koreksi)
    public function updateMaster(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        
        $grandTotal = (float) $request->grand_total;
        $bayar = (float) $request->bayar;
        $sisaHutangBaru = max(0.0, $grandTotal - $bayar);
        
        $pembelian->update([
            'grand_total' => $grandTotal,
            'total_harga' => $grandTotal + $pembelian->diskon, // Sync with diskon
            'bayar' => $bayar,
            'sisa_hutang' => $sisaHutangBaru,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status_pembayaran' => $sisaHutangBaru <= 0 ? 'Lunas' : 'Hutang'
        ]);

        return back()->with('success', 'Data hutang berhasil dikoreksi secara manual!');
    }
}