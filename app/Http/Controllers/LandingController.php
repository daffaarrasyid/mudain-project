<?php

namespace App\Http\Controllers;

use App\Services\LandingService;

class LandingController extends Controller
{
    public function index(LandingService $landingService)
    {
        return view('landing.index', [
            'profil' => $landingService->integrasiProfil(),
            'portofolio' => $landingService->getPortofolioPublik(),
            'mitra' => $landingService->getMitraPublik(),
            'produk' => $landingService->getProdukPublik(),
            'totalPenjualan' => $landingService->getTotalPenjualan(),
        ]);
    }
}
