<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desain;
use App\Models\Produksi;
use App\Services\ProduksiService;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function updateProduksi(Request $request, ProduksiService $produksiService)
    {
        return view('admin.produksi.update-produksi', [
            'items' => $produksiService->getAllProduksi([
                'status' => $request->input('status'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function simpanProduksi(Request $request, Produksi $produksi, ProduksiService $produksiService)
    {
        $data = $request->validate([
            'tanggal_produksi' => ['nullable', 'date'],
            'jumlah_produksi' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:menunggu,diproses,selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $produksiService->updateProduksi($produksi, $data, $request->user());

        return redirect()->route('admin.produksi.update-produksi')->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function updateDesain(Request $request, ProduksiService $produksiService)
    {
        return view('admin.produksi.update-desain', [
            'items' => $produksiService->getAllDesain([
                'status_desain' => $request->input('status_desain'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function simpanDesain(Request $request, Desain $desain, ProduksiService $produksiService)
    {
        $data = $request->validate([
            'nama_desain' => ['nullable', 'string', 'max:255'],
            'deskripsi_desain' => ['nullable', 'string'],
            'status_desain' => ['required', 'in:belum_diisi,siap,revisi,final'],
        ]);

        $produksiService->updateDesain($desain, $data, $request->user());

        return redirect()->route('admin.produksi.update-desain')->with('success', 'Data desain berhasil diperbarui.');
    }
}
