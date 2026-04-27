<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Services\MasterService;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request, MasterService $masterService)
    {
        return view('admin.master-data.stok', [
            'items' => $masterService->getStok([
                'search' => $request->string('search')->toString(),
                'id_produk' => $request->input('id_produk'),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'produkOptions' => Produk::orderBy('nama_produk')->get(),
        ]);
    }

    public function store(Request $request, MasterService $masterService)
    {
        $data = $request->validate([
            'id_produk' => ['required', 'exists:produk,id_produk'],
            'arah' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['arah'] === 'masuk') {
            $masterService->tambahStokMasuk([
                'id_produk' => $data['id_produk'],
                'jumlah_masuk' => $data['jumlah'],
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
            ], $request->user());
        } else {
            $masterService->tambahStokKeluar([
                'id_produk' => $data['id_produk'],
                'jumlah_keluar' => $data['jumlah'],
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
            ], $request->user());
        }

        return redirect()->route('admin.stok.index')->with('success', 'Pergerakan stok berhasil dicatat.');
    }
}
