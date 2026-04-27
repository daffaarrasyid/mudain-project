<?php

namespace App\Services;

use App\Models\Mitra;
use App\Models\Portofolio;
use App\Models\ProdukProfil;
use App\Models\Penjualan;

class LandingService
{
    public function integrasiProfil(): array
    {
        return [
            'nama' => 'Mudain Project',
            'tagline' => 'Solusi produksi, konveksi, dan merchandise untuk kebutuhan organisasi dan bisnis.',
            'deskripsi' => 'Mudain membantu pengelolaan produk, produksi, dan transaksi dari satu dashboard agar operasional lebih rapi dan mudah dipantau.',
        ];
    }

    public function getPortofolioPublik()
    {
        return Portofolio::query()->latest()->take(6)->get();
    }

    public function getMitraPublik()
    {
        return Mitra::query()->orderBy('nama_mitra')->take(8)->get();
    }

    public function getProdukPublik()
    {
        return ProdukProfil::query()->orderBy('nama_produk')->take(6)->get();
    }

    public function getTotalPenjualan(): float
    {
        return (float) Penjualan::sum('total');
    }
}
