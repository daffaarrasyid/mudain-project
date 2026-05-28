<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduksiController extends Controller
{
    // Fungsi untuk menampilkan halaman Update Produksi
    public function updateProduksi()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Tarik semua detail pesanan untuk dikerjakan tim produksi
        $produksis = PenjualanDetail::with(['penjualan.customer', 'produk', 'servis', 'operator'])
                        ->latest('updated_at')
                        ->paginate($perPage)
                        ->withQueryString();

        return view('admin.produksi.update-produksi', compact('produksis'));
    }

    // Fungsi simpan update progress
    public function simpanUpdate(Request $request, $id)
    {
        $request->validate([
            'tahap_produksi' => 'required|string|max:255',
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $detail = PenjualanDetail::findOrFail($id);
        
        $detail->update([
            'tahap_produksi' => $request->tahap_produksi,
            'progress' => $request->progress,
            'catatan_produksi' => $request->catatan_produksi,
            'produksi_updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Progress item produksi berhasil diperbarui!');
    }

    // Fungsi reset (Hapus Log Produksi)
    public function resetUpdate($id)
    {
        $detail = PenjualanDetail::findOrFail($id);
        
        $detail->update([
            'tahap_produksi' => 'Belum Diproses',
            'progress' => 0,
            'catatan_produksi' => null,
            'produksi_updated_by' => null,
        ]);

        return back()->with('success', 'Catatan produksi berhasil direset ke 0%!');
    }

    // Buka file ProduksiController.php dan timpa fungsi updateDesain() dengan ini:

    public function updateDesain()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Tarik semua data penjualan (invoice)
        $desains = \App\Models\Penjualan::with('customer')->latest()->paginate($perPage)->withQueryString();
        return view('admin.produksi.update-desain', compact('desains'));
    }

    public function simpanDesain(Request $request, $id)
    {
        $request->validate([
            'judul_desain' => 'required',
            'nama_desainer' => 'required',
            'gambar_desain' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $penjualan = \App\Models\Penjualan::findOrFail($id);
        
        // Handle upload gambar
        if ($request->hasFile('gambar_desain')) {
            // Hapus gambar lama kalau ada (Pakai disk 'public' secara eksplisit)
            if ($penjualan->gambar_desain && \Illuminate\Support\Facades\Storage::disk('public')->exists('desain/' . $penjualan->gambar_desain)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('desain/' . $penjualan->gambar_desain);
            }
            
            $file = $request->file('gambar_desain');
            // Bersihkan nama file biar aman dari spasi/karakter aneh
            $namaAsli = str_replace(' ', '_', $file->getClientOriginalName());
            $namaFile = time() . '_' . $namaAsli;
            
            // SIMPAN GAMBAR: Paksa Laravel pakai disk 'public'
            $file->storeAs('desain', $namaFile, 'public');
            
            $penjualan->gambar_desain = $namaFile;
        }

        $penjualan->update([
            'judul_desain' => $request->judul_desain,
            'nama_desainer' => $request->nama_desainer,
            'keterangan_desain' => $request->keterangan_desain,
        ]);

        $penjualan->save(); 

        return back()->with('success', 'Data desain berhasil disimpan!');
    }

    public function hapusDesain($id)
    {
        $penjualan = \App\Models\Penjualan::findOrFail($id);
        
        // Hapus file fisik dari storage
        if ($penjualan->gambar_desain && Storage::exists('public/desain/' . $penjualan->gambar_desain)) {
            Storage::delete('public/desain/' . $penjualan->gambar_desain);
        }

        // Reset kolom desain jadi null (bukan hapus invoicenya)
        $penjualan->update([
            'judul_desain' => null,
            'nama_desainer' => null,
            'keterangan_desain' => null,
            'gambar_desain' => null,
        ]);

        return back()->with('success', 'Gambar dan data desain berhasil dihapus!');
    }
}



