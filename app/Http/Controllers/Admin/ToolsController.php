<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolsController extends Controller
{
    public function generateBarcode(Request $request, LaporanService $laporanService)
    {
        return view('admin.tools.generate-barcode', [
            'produkOptions' => Produk::orderBy('nama_produk')->get(),
            'barcodeData' => $request->filled('id_produk')
                ? $laporanService->generateBarcode($request->string('id_produk')->toString())
                : null,
        ]);
    }

    public function backupData()
    {
        return view('admin.tools.backup-data', [
            'backups' => collect(Storage::disk('local')->files('backups'))
                ->map(fn (string $path) => [
                    'path' => $path,
                    'name' => basename($path),
                    'updated_at' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($path)),
                ])
                ->sortByDesc('updated_at')
                ->values(),
        ]);
    }

    public function prosesBackup(LaporanService $laporanService)
    {
        $laporanService->backupDatabase();

        return redirect()->route('admin.tools.backup-data')->with('success', 'Backup data berhasil dibuat.');
    }

    public function downloadBackup(Request $request)
    {
        $path = $request->query('path');

        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }
}
