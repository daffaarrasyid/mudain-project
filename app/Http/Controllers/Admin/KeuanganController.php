<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengeluaranLain;
use App\Services\KeuanganService;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function kas(Request $request, KeuanganService $keuanganService)
    {
        return view('admin.keuangan.kas', [
            'items' => $keuanganService->getArusKas([
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'jenis' => $request->input('jenis'),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'ringkasan' => $keuanganService->hitungSaldoKas([
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
            ]),
        ]);
    }

    public function labaRugi(Request $request, KeuanganService $keuanganService)
    {
        return view('admin.keuangan.laba-rugi', [
            'items' => $keuanganService->getLabaRugi([
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'ringkasan' => $keuanganService->hitungLabaRugi([
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
            ]),
        ]);
    }

    public function pengeluaranLainnya(Request $request, KeuanganService $keuanganService)
    {
        return view('admin.keuangan.pengeluaran-lainnya', [
            'items' => $keuanganService->getAllPengeluaran([
                'search' => $request->string('search')->toString(),
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? PengeluaranLain::findOrFail($request->integer('edit')) : null,
        ]);
    }

    public function storePengeluaran(Request $request, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string', 'max:255'],
            'kategori_pengeluaran' => ['nullable', 'string', 'max:255'],
            'jumlah_pengeluaran' => ['required', 'numeric', 'min:0.01'],
        ]);

        $keuanganService->createPengeluaran($data, $request->user());

        return redirect()->route('admin.keuangan.pengeluaran-lainnya')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function updatePengeluaran(Request $request, PengeluaranLain $pengeluaran, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string', 'max:255'],
            'kategori_pengeluaran' => ['nullable', 'string', 'max:255'],
            'jumlah_pengeluaran' => ['required', 'numeric', 'min:0.01'],
        ]);

        $keuanganService->updatePengeluaran($pengeluaran, $data, $request->user());

        return redirect()->route('admin.keuangan.pengeluaran-lainnya')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroyPengeluaran(Request $request, PengeluaranLain $pengeluaran, KeuanganService $keuanganService)
    {
        $keuanganService->deletePengeluaran($pengeluaran, $request->user());

        return redirect()->route('admin.keuangan.pengeluaran-lainnya')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
