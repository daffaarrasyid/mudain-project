<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Ambil data stok dan relasinya
        $stoks = Stok::with('produk.satuan')->latest()->paginate($perPage)->withQueryString();
        
        // Ambil data produk untuk datalist (pencarian)
        $daftarProduk = Produk::all();

        return view('admin.master-data.stok', compact('stoks', 'daftarProduk'));
    }

    public function store(Request $request)
    {
        // Validasi tanpa kolom tanggal
        $request->validate([
            'produk_search' => 'required|exists:produks,kode_barang', 
            'jenis'         => 'required|in:Masuk,Keluar',
            'jumlah'        => 'required|integer|min:1',
        ]);

        $produk = Produk::where('kode_barang', $request->produk_search)->firstOrFail();

        if ($request->jenis == 'Keluar' && $produk->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok produk tidak mencukupi untuk dikeluarkan!']);
        }

        $nilai = $produk->harga_beli * $request->jumlah;

        Stok::create([
            'produk_id'  => $produk->id,
            'jenis'      => $request->jenis,
            'jumlah'     => $request->jumlah,
            'nilai'      => $nilai,
            'tanggal'    => now(), // <--- Otomatis generate waktu saat ini
            'keterangan' => $request->keterangan,
        ]);

        if ($request->jenis == 'Masuk') {
            $produk->increment('stok', $request->jumlah);
        } else {
            $produk->decrement('stok', $request->jumlah);
        }

        return back()->with('success', 'Pencatatan stok berhasil disimpan!');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $produk = Produk::find($stok->produk_id);

        // Jika dihapus, kita harus mengembalikan (rollback) efek stoknya ke tabel produk
        if ($produk) {
            if ($stok->jenis == 'Masuk') {
                $produk->decrement('stok', $stok->jumlah);
            } else {
                $produk->increment('stok', $stok->jumlah);
            }
        }

        $stok->delete();
        
        return back()->with('success', 'Riwayat stok berhasil dihapus dan dikembalikan!');
    }
}