<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Ambil data, paginasi 10 data per halaman (ascending order)
        $kategoris = Kategori::oldest()->paginate(10);
        return view('admin.master-data.kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Kategori::create($request->all());

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Data kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return back()->with('success', 'Data kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        
        return back()->with('success', 'Data kategori berhasil dihapus!');
    }
}