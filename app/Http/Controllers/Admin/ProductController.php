<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Produk;
use App\Models\Satuan;
use App\Services\MasterService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        $items = $masterService->getAllProduk([
            'search' => $request->string('search')->toString(),
            'id_kategori' => $request->input('id_kategori'),
            'per_page' => $request->integer('per_page', 10),
        ]);

        return view('admin.resource.index', [
            'title' => 'Data Produk',
            'description' => 'Kelola produk, kategori, pemasok, harga, dan pantau stok aktifnya.',
            'items' => $items,
            'editItem' => $request->filled('edit') ? Produk::findOrFail($request->string('edit')->toString()) : null,
            'columns' => [
                ['label' => 'Kode', 'key' => 'id_produk'],
                ['label' => 'Nama Produk', 'key' => 'nama_produk'],
                ['label' => 'Kategori', 'key' => 'kategori.nama_kategori'],
                ['label' => 'Satuan', 'key' => 'satuan.nama_satuan'],
                ['label' => 'Pemasok', 'key' => 'pemasok.nama_pemasok'],
                ['label' => 'Harga', 'key' => 'harga', 'format' => 'currency'],
                ['label' => 'Stok Aktif', 'key' => 'stok_aktif'],
            ],
            'fields' => [
                ['name' => 'id_produk', 'label' => 'Kode Produk', 'type' => 'text', 'placeholder' => 'Kosongkan untuk auto generate'],
                ['name' => 'nama_produk', 'label' => 'Nama Produk', 'type' => 'text', 'required' => true],
                ['name' => 'id_kategori', 'label' => 'Kategori', 'type' => 'select', 'required' => true, 'options' => Kategori::orderBy('nama_kategori')->pluck('nama_kategori', 'id_kategori')->all()],
                ['name' => 'id_satuan', 'label' => 'Satuan', 'type' => 'select', 'required' => true, 'options' => Satuan::orderBy('nama_satuan')->pluck('nama_satuan', 'id_satuan')->all()],
                ['name' => 'id_pemasok', 'label' => 'Pemasok', 'type' => 'select', 'options' => Pemasok::orderBy('nama_pemasok')->pluck('nama_pemasok', 'id_pemasok')->all()],
                ['name' => 'harga', 'label' => 'Harga Jual', 'type' => 'number', 'required' => true, 'step' => '0.01'],
                ['name' => 'gambar', 'label' => 'URL Gambar', 'type' => 'url'],
            ],
            'filters' => [
                ['name' => 'id_kategori', 'label' => 'Kategori', 'type' => 'select', 'options' => ['' => 'Semua kategori'] + Kategori::orderBy('nama_kategori')->pluck('nama_kategori', 'id_kategori')->all()],
            ],
            'storeRoute' => 'admin.data-produk.store',
            'updateRoute' => 'admin.data-produk.update',
            'destroyRoute' => 'admin.data-produk.destroy',
            'searchPlaceholder' => 'Cari kode atau nama produk',
            'createLabel' => 'Simpan Produk',
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'id_produk' => ['nullable', 'string', 'max:30', 'unique:produk,id_produk'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'id_satuan' => ['required', 'exists:satuan,id_satuan'],
            'id_pemasok' => ['nullable', 'exists:pemasok,id_pemasok'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'url'],
        ]);

        $masterService->createProduk($data, $request->user());

        return redirect()->route('admin.data-produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk, MasterService $masterService)
    {
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'id_satuan' => ['required', 'exists:satuan,id_satuan'],
            'id_pemasok' => ['nullable', 'exists:pemasok,id_pemasok'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'url'],
        ]);

        $masterService->updateProduk($produk, $data, $request->user());

        return redirect()->route('admin.data-produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Produk $produk, MasterService $masterService)
    {
        $masterService->deleteProduk($produk, $request->user());

        return redirect()->route('admin.data-produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
