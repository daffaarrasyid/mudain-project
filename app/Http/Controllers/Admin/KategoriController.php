<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Services\MasterService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        return view('admin.resource.index', [
            'title' => 'Kategori Produk',
            'description' => 'Kelola kategori untuk mengelompokkan produk dan memudahkan pencarian.',
            'items' => $masterService->getAllKategori([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Kategori::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Kategori', 'key' => 'nama_kategori'],
                ['label' => 'Dibuat Oleh', 'key' => 'pengguna.nama_user'],
                ['label' => 'Terakhir Diperbarui', 'key' => 'updated_at', 'format' => 'datetime'],
            ],
            'fields' => [
                ['name' => 'nama_kategori', 'label' => 'Nama Kategori', 'type' => 'text', 'required' => true],
            ],
            'storeRoute' => 'admin.kategori.store',
            'updateRoute' => 'admin.kategori.update',
            'destroyRoute' => 'admin.kategori.destroy',
            'searchPlaceholder' => 'Cari kategori',
            'createLabel' => 'Simpan Kategori',
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
        ]);

        $masterService->createKategori($data, $request->user());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
        ]);

        $masterService->updateKategori($kategori, $data, $request->user());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Kategori $kategori, MasterService $masterService)
    {
        $masterService->deleteKategori($kategori, $request->user());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
