<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Portofolio;
use App\Models\ProdukProfil;
use App\Services\CMSService;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function mitra(Request $request, CMSService $cmsService)
    {
        return view('admin.resource.index', [
            'title' => 'Konten Mitra',
            'description' => 'Kelola daftar mitra yang akan ditampilkan pada landing page publik.',
            'items' => $cmsService->getAllMitra([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Mitra::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Mitra', 'key' => 'nama_mitra'],
                ['label' => 'Logo', 'key' => 'logo'],
                ['label' => 'Deskripsi', 'key' => 'deskripsi'],
            ],
            'fields' => [
                ['name' => 'nama_mitra', 'label' => 'Nama Mitra', 'type' => 'text', 'required' => true],
                ['name' => 'logo', 'label' => 'URL Logo', 'type' => 'url'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'storeRoute' => 'admin.konten.mitra.store',
            'updateRoute' => 'admin.konten.mitra.update',
            'destroyRoute' => 'admin.konten.mitra.destroy',
            'searchPlaceholder' => 'Cari mitra',
            'createLabel' => 'Simpan Mitra',
        ]);
    }

    public function storeMitra(Request $request, CMSService $cmsService)
    {
        $data = $request->validate([
            'nama_mitra' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->createMitra($data, $request->user());

        return redirect()->route('admin.konten.mitra')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function updateMitra(Request $request, Mitra $mitra, CMSService $cmsService)
    {
        $data = $request->validate([
            'nama_mitra' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->updateMitra($mitra, $data, $request->user());

        return redirect()->route('admin.konten.mitra')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroyMitra(Request $request, Mitra $mitra, CMSService $cmsService)
    {
        $cmsService->deleteMitra($mitra, $request->user());

        return redirect()->route('admin.konten.mitra')->with('success', 'Mitra berhasil dihapus.');
    }

    public function produk(Request $request, CMSService $cmsService)
    {
        return view('admin.resource.index', [
            'title' => 'Produk Landing Page',
            'description' => 'Kelola produk profil yang tampil pada halaman publik Mudain.',
            'items' => $cmsService->getAllProdukProfil([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? ProdukProfil::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Produk', 'key' => 'nama_produk'],
                ['label' => 'Harga', 'key' => 'harga', 'format' => 'currency'],
                ['label' => 'Gambar', 'key' => 'gambar'],
                ['label' => 'Deskripsi', 'key' => 'deskripsi'],
            ],
            'fields' => [
                ['name' => 'nama_produk', 'label' => 'Nama Produk', 'type' => 'text', 'required' => true],
                ['name' => 'harga', 'label' => 'Harga', 'type' => 'number', 'required' => true, 'step' => '0.01'],
                ['name' => 'gambar', 'label' => 'URL Gambar', 'type' => 'url'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'storeRoute' => 'admin.konten.produk.store',
            'updateRoute' => 'admin.konten.produk.update',
            'destroyRoute' => 'admin.konten.produk.destroy',
            'searchPlaceholder' => 'Cari produk landing page',
            'createLabel' => 'Simpan Produk',
        ]);
    }

    public function storeProduk(Request $request, CMSService $cmsService)
    {
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->createProdukProfil($data, $request->user());

        return redirect()->route('admin.konten.produk')->with('success', 'Produk landing page berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, ProdukProfil $produkProfil, CMSService $cmsService)
    {
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->updateProdukProfil($produkProfil, $data, $request->user());

        return redirect()->route('admin.konten.produk')->with('success', 'Produk landing page berhasil diperbarui.');
    }

    public function destroyProduk(Request $request, ProdukProfil $produkProfil, CMSService $cmsService)
    {
        $cmsService->deleteProdukProfil($produkProfil, $request->user());

        return redirect()->route('admin.konten.produk')->with('success', 'Produk landing page berhasil dihapus.');
    }

    public function portofolio(Request $request, CMSService $cmsService)
    {
        return view('admin.resource.index', [
            'title' => 'Portofolio',
            'description' => 'Kelola portofolio karya untuk ditampilkan kepada pengunjung pada landing page.',
            'items' => $cmsService->getAllPortofolio([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Portofolio::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Judul', 'key' => 'judul'],
                ['label' => 'Gambar', 'key' => 'gambar'],
                ['label' => 'Deskripsi', 'key' => 'deskripsi'],
            ],
            'fields' => [
                ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'required' => true],
                ['name' => 'gambar', 'label' => 'URL Gambar', 'type' => 'url'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'storeRoute' => 'admin.konten.portofolio.store',
            'updateRoute' => 'admin.konten.portofolio.update',
            'destroyRoute' => 'admin.konten.portofolio.destroy',
            'searchPlaceholder' => 'Cari portofolio',
            'createLabel' => 'Simpan Portofolio',
        ]);
    }

    public function storePortofolio(Request $request, CMSService $cmsService)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'gambar' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->createPortofolio($data, $request->user());

        return redirect()->route('admin.konten.portofolio')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function updatePortofolio(Request $request, Portofolio $portofolio, CMSService $cmsService)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'gambar' => ['nullable', 'url'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $cmsService->updatePortofolio($portofolio, $data, $request->user());

        return redirect()->route('admin.konten.portofolio')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroyPortofolio(Request $request, Portofolio $portofolio, CMSService $cmsService)
    {
        $cmsService->deletePortofolio($portofolio, $request->user());

        return redirect()->route('admin.konten.portofolio')->with('success', 'Portofolio berhasil dihapus.');
    }

    public function testimoni()
    {
        return view('admin.konten.testimoni');
    }
}
