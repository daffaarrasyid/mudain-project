<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function entry()
    {
        // 1. Tarik semua supplier (sort ascending)
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();

        // 2. Filter penjualan: hanya yang punya produk stok minus
        //    DAN belum semua detail produksinya selesai (progress < 100)
        $penjualans = Penjualan::with(['details.produk', 'customer'])
            ->latest()
            ->get()
            ->filter(function ($penjualan) {
                // Syarat 1: Semua detail produksinya belum 100% (masih ada yang perlu diproses)
                $adaYangBelumSelesai = $penjualan->details->contains(fn($d) => $d->progress < 100);
                if (!$adaYangBelumSelesai) return false;

                // Syarat 2: Ada minimal 1 produk dengan stok minus (< 0)
                $adaStokMinus = $penjualan->details->contains(function ($d) {
                    return $d->produk && $d->produk->stok < 0;
                });

                return $adaStokMinus;
            })
            ->values(); // Re-index koleksi

        // 3. Lempar datanya ke View
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
                    'produk_id'   => $item['id'],
                    'harga_beli'  => $item['harga_beli'],
                    'harga_jual'  => 0,
                    'qty'         => $item['qty'],
                    'subtotal'    => $item['total'],
                ]);

                // Tambahkan/pulihkan stok produk
                $produk = Produk::find($item['id']);
                if ($produk) {
                    $produk->increment('stok', $item['qty']);

                    // Catat ke tabel Stock In/Out
                    Stok::create([
                        'produk_id'  => $produk->id,
                        'jenis'      => 'Masuk',
                        'jumlah'     => $item['qty'],
                        'nilai'      => $item['harga_beli'] * $item['qty'],
                        'tanggal'    => now(),
                        'keterangan' => 'Pembelian Faktur ' . $faktur,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.pembelian.entry')->with('success', 'Pembelian berhasil! Nomor Faktur: ' . $faktur);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function daftar()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        $pembelians = Pembelian::with(['supplier', 'penjualan', 'details.produk'])->latest()->paginate($perPage)->withQueryString();
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