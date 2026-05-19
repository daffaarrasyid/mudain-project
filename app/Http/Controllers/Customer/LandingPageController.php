<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // 1. Tarik Data Mitra (Hanya yang statusnya Publish)
        $mitras = Mitra::where('status', 'Publish')->latest()->get();

        // 2. Tarik Data Testimoni (Misal kita ambil 4 terbaru aja biar pas gridnya)
        $testimonis = Testimoni::latest()->take(4)->get();

        return view('customer.beranda', compact('mitras', 'testimonis'));
    }
}
