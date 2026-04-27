<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasok;
use App\Services\MasterService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        return view('admin.resource.index', [
            'title' => 'Data Supplier',
            'description' => 'Kelola pemasok untuk pencatatan pembelian dan referensi produk.',
            'items' => $masterService->getAllPemasok([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Pemasok::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Supplier', 'key' => 'nama_pemasok'],
                ['label' => 'No. Telepon', 'key' => 'no_telp'],
                ['label' => 'Alamat', 'key' => 'alamat'],
                ['label' => 'Dibuat Oleh', 'key' => 'pengguna.nama_user'],
            ],
            'fields' => [
                ['name' => 'nama_pemasok', 'label' => 'Nama Supplier', 'type' => 'text', 'required' => true],
                ['name' => 'no_telp', 'label' => 'No. Telepon', 'type' => 'text'],
                ['name' => 'alamat', 'label' => 'Alamat', 'type' => 'textarea'],
            ],
            'storeRoute' => 'admin.supplier.store',
            'updateRoute' => 'admin.supplier.update',
            'destroyRoute' => 'admin.supplier.destroy',
            'searchPlaceholder' => 'Cari supplier',
            'createLabel' => 'Simpan Supplier',
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_pemasok' => ['required', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ]);

        $masterService->createPemasok($data, $request->user());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, Pemasok $pemasok, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_pemasok' => ['required', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ]);

        $masterService->updatePemasok($pemasok, $data, $request->user());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Request $request, Pemasok $pemasok, MasterService $masterService)
    {
        $masterService->deletePemasok($pemasok, $request->user());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
