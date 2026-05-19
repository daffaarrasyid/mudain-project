<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function entry()
    {
        // 1. Tarik data dari database
        $suppliers = Supplier::all();
        $penjualans = Penjualan::with('details.produk')->latest()->get();

        // 2. Lempar (passing) datanya ke View pakai compact()
        return view('admin.transaksi.entry-pembelian', compact('suppliers', 'penjualans'));
    }

    public function store(Request $request)
    {
        // Ambil data dari array AlpineJS
        $cart = json_decode($request->cart_data, true);
        if(empty($cart)) return back()->withErrors(['cart' => 'Belum ada item yang diceklis untuk dibeli!']);

        DB::beginTransaction();
        try {
            // Tarik data penjualan aslinya
            $penjualan = Penjualan::findOrFail($request->penjualan_id);
            
            // LOGIKA FAKTUR OTOMATIS: NGIKUTIN PENJUALAN + URUTAN PO
            // Hitung sudah ada berapa pembelian untuk invoice penjualan ini
            $urutanPO = Pembelian::where('penjualan_id', $penjualan->id)->count() + 1;
            // Hasilnya: BLP2026...-PO01
            $faktur = $penjualan->invoice . '-PO' . str_pad($urutanPO, 2, '0', STR_PAD_LEFT);

            $pembelian = Pembelian::create([
                'faktur' => $faktur,
                'tanggal_faktur' => $request->tanggal_faktur,
                'supplier_id' => $request->supplier_id,
                'penjualan_id' => $penjualan->id, // Relasi ke Penjualan
                'user_id' => Auth::id() ?? 1,
                'total_harga' => $request->total_harga,
                'diskon' => $request->diskon ?? 0,
                'grand_total' => $request->grand_total,
                'bayar' => $request->bayar,
                'sisa_hutang' => $request->sisa_hutang,
                'jatuh_tempo' => $request->sisa_hutang > 0 ? $request->jatuh_tempo : null,
                'status_pembayaran' => $request->sisa_hutang > 0 ? 'Hutang' : 'Lunas',
            ]);

            // Looping barang yang diceklis
            foreach ($cart as $item) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'produk_id' => $item['id'],
                    'harga_beli' => $item['harga_beli'],
                    'harga_jual' => 0, // Dikosongkan karena tidak perlu update harga jual
                    'qty' => $item['qty'],
                    'subtotal' => $item['total'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.pembelian.entry')->with('success', 'Pembelian berhasil! Nomor Faktur: ' . $faktur);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    // Fungsi untuk nampilin Daftar Pembelian
    public function daftar()
    {
        $pembelians = Pembelian::with(['supplier', 'penjualan', 'details.produk'])->latest()->paginate(15);
        return view('admin.transaksi.daftar-pembelian', compact('pembelians'));
    }

    // Fungsi untuk ngedit pembayaran/cicilan ke supplier
    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([
            'nominal_tambah' => 'required|numeric|min:1'
        ]);

        $pembelian = Pembelian::findOrFail($id);
        
        // Akumulasi: Bayar yang lama ditambah nominal bayaran baru
        $bayarBaru = $pembelian->bayar + $request->nominal_tambah;
        $sisaHutangBaru = $pembelian->grand_total - $bayarBaru;
        
        $pembelian->update([
            'bayar' => $bayarBaru,
            'sisa_hutang' => $sisaHutangBaru < 0 ? 0 : $sisaHutangBaru,
            'status_pembayaran' => $sisaHutangBaru <= 0 ? 'Lunas' : 'Hutang'
        ]);

        return back()->with('success', 'Pembayaran ke supplier berhasil diupdate!');
    }

    // Fungsi untuk membatalkan/menghapus pembelian
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        
        // Catatan: Karena sistem Make-to-Order, menghapus pembelian TIDAK mengurangi stok di master produk.
        // Hanya menghapus riwayat arsip pembeliannya saja.
        $pembelian->delete();
        
        return back()->with('success', 'Arsip pembelian berhasil dibatalkan dan dihapus!');
    }
}