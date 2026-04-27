<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GrafikService;
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    public function index(Request $request, GrafikService $grafikService)
    {
        $tahun = $request->integer('tahun', now()->year);

        return view('admin.grafik.index', [
            'tahun' => $tahun,
            'chartArusKas' => $grafikService->dataGrafikArusKas(['tahun' => $tahun]),
            'chartPenjualan' => $grafikService->dataGrafikPenjualan(['tahun' => $tahun]),
            'chartLabaRugi' => $grafikService->dataGrafikLabaRugi(['tahun' => $tahun]),
        ]);
    }
}
