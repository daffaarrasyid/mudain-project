<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Imports\ProduksImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil data produk berserta relasinya
        $produks = Produk::with(['kategori', 'satuan', 'supplier'])->latest()->paginate(10);
        // Lempar data kategori & satuan untuk dropdown di form modal
        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        $suppliers = Supplier::all();

        return view('admin.master-data.data_produk', compact('produks', 'kategoris', 'satuans', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'       => 'required|unique:produks,kode_barang',
            'nama_item'         => 'required|string|max:255',
            'kategori_id'       => 'required|exists:kategoris,id',
            'satuan_id'         => 'required|exists:satuans,id',
            'supplier_id'       => 'required|exists:suppliers,id', // Validasi supplier
            'harga_beli'        => 'required|numeric',
            'harga_jual_umum'   => 'required|numeric', // Validasi umum
            'harga_pelanggan'   => 'required|numeric', // Validasi pelanggan
            'stok'              => 'nullable|numeric',
            'gambar'            => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk_images', 'public');
        }

        Produk::create($data);
        return back()->with('success', 'Data produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item'         => 'required|string|max:255',
            'kategori_id'       => 'required|exists:kategoris,id',
            'satuan_id'         => 'required|exists:satuans,id',
            'supplier_id'       => 'required|exists:suppliers,id', // Validasi supplier
            'harga_beli'        => 'required|numeric',
            'harga_jual_umum'   => 'required|numeric', // Validasi umum
            'harga_pelanggan'   => 'required|numeric', // Validasi pelanggan
            'stok'              => 'required|numeric',
            'gambar'            => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);
        $data = $request->except('kode_barang');

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk_images', 'public');
        }

        $produk->update($data);
        return back()->with('success', 'Data produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Cek apakah produk sudah digunakan di transaksi pembelian
        if ($produk->pembelianDetails()->exists()) {
            return back()->with('error', 'Produk "' . $produk->nama_item . '" tidak dapat dihapus karena sudah memiliki riwayat transaksi pembelian.');
        }

        // Hapus file gambar fisik dari server
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->delete();

        return back()->with('success', 'Data produk berhasil dihapus!');
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProduksImport, $request->file('file_excel'));
        return back()->with('success', 'Data produk berhasil diimport!');
    }
}
