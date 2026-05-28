<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Ambil data, paginasi data per halaman (ascending order)
        $kategoris = Kategori::oldest()->paginate($perPage)->withQueryString();
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