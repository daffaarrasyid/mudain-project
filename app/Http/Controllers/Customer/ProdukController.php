<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portofolio; 
use App\Models\KontenProduk; 

class ProdukController extends Controller
{
    public function index()
    {
        // 1. Tarik Data Portofolio (Hanya yang Publish, misal ambil 5 terbaru buat slider)
        $portofolios = Portofolio::where('status', 'Publish')->latest()->take(5)->get();

        // 2. Tarik Data Katalog Produk
        $produks = KontenProduk::latest()->get();

        return view('customer.produk', compact('portofolios', 'produks'));
    }
} 