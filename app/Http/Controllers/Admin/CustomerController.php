<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembeli;
use App\Services\MasterService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        return view('admin.resource.index', [
            'title' => 'Data Customer',
            'description' => 'Simpan data pelanggan untuk memudahkan pencatatan penjualan dan histori transaksi.',
            'items' => $masterService->getAllPembeli([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Pembeli::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Customer', 'key' => 'nama_pembeli'],
                ['label' => 'Jenis Kelamin', 'key' => 'jenis_kelamin'],
                ['label' => 'No. Telepon', 'key' => 'no_telp'],
                ['label' => 'Alamat', 'key' => 'alamat'],
            ],
            'fields' => [
                ['name' => 'nama_pembeli', 'label' => 'Nama Customer', 'type' => 'text', 'required' => true],
                ['name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']],
                ['name' => 'no_telp', 'label' => 'No. Telepon', 'type' => 'text'],
                ['name' => 'alamat', 'label' => 'Alamat', 'type' => 'textarea'],
            ],
            'storeRoute' => 'admin.customer.store',
            'updateRoute' => 'admin.customer.update',
            'destroyRoute' => 'admin.customer.destroy',
            'searchPlaceholder' => 'Cari customer',
            'createLabel' => 'Simpan Customer',
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_pembeli' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', 'string', 'max:50'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ]);

        $masterService->createPembeli($data, $request->user());

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function update(Request $request, Pembeli $pembeli, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_pembeli' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', 'string', 'max:50'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ]);

        $masterService->updatePembeli($pembeli, $data, $request->user());

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Request $request, Pembeli $pembeli, MasterService $masterService)
    {
        $masterService->deletePembeli($pembeli, $request->user());

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil dihapus.');
    }
}
