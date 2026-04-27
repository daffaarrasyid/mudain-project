<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use App\Services\MasterService;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        return view('admin.resource.index', [
            'title' => 'Satuan Produk',
            'description' => 'Kelola satuan untuk memastikan kuantitas produk tercatat konsisten.',
            'items' => $masterService->getAllSatuan([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Satuan::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Satuan', 'key' => 'nama_satuan'],
                ['label' => 'Dibuat Oleh', 'key' => 'pengguna.nama_user'],
                ['label' => 'Terakhir Diperbarui', 'key' => 'updated_at', 'format' => 'datetime'],
            ],
            'fields' => [
                ['name' => 'nama_satuan', 'label' => 'Nama Satuan', 'type' => 'text', 'required' => true],
            ],
            'storeRoute' => 'admin.satuan.store',
            'updateRoute' => 'admin.satuan.update',
            'destroyRoute' => 'admin.satuan.destroy',
            'searchPlaceholder' => 'Cari satuan',
            'createLabel' => 'Simpan Satuan',
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_satuan' => ['required', 'string', 'max:255'],
        ]);

        $masterService->createSatuan($data, $request->user());

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, Satuan $satuan, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_satuan' => ['required', 'string', 'max:255'],
        ]);

        $masterService->updateSatuan($satuan, $data, $request->user());

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Request $request, Satuan $satuan, MasterService $masterService)
    {
        $masterService->deleteSatuan($satuan, $request->user());

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
