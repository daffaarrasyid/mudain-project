<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function kas()
    {
        $allKas = Kas::getDynamicKas();

        // 5. Ngitung Saldo Saat Ini
        $totalMasuk = $allKas->where('tipe', 'Masuk')->sum('nominal');
        $totalKeluar = $allKas->where('tipe', 'Keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        // 6. Buat pagination manual
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }
        $page = request()->get('page', 1);
        $sliced = $allKas->slice(($page - 1) * $perPage, $perPage)->values();
        
        $kas = new \Illuminate\Pagination\LengthAwarePaginator(
            $sliced,
            $allKas->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.keuangan.kas', compact('kas', 'saldo'));
    }

    public function storeKas(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:Masuk,Keluar',
            'jenis' => 'required|string',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Generate Kode Kas (KS-0000001 dst) yang seragam!
        $lastKas = Kas::where('kode_kas', 'LIKE', 'KS-%')->latest('id')->first();
        $lastCount = $lastKas ? (int) substr($lastKas->kode_kas, 3) : 0;
        $kodeKas = 'KS-' . str_pad($lastCount + 1, 7, '0', STR_PAD_LEFT);

        Kas::create([
            'kode_kas' => $kodeKas,
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'Mutasi kas manual berhasil ditambahkan!');
    }

    // Fungsi untuk menampilkan halaman Laba Rugi
    public function labaRugi()
    {
        $allRiwayat = Kas::getDynamicLabaRugi();

        // 5. Hitung Laba Rugi Aggregates
        $totalPemasukan = $allRiwayat->where('tipe', 'Masuk')->sum('nominal');
        $totalPengeluaran = $allRiwayat->where('tipe', 'Keluar')->sum('nominal');
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // 6. Buat pagination manual
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }
        $page = request()->get('page', 1);
        $sliced = $allRiwayat->slice(($page - 1) * $perPage, $perPage)->values();
        
        $riwayat = new \Illuminate\Pagination\LengthAwarePaginator(
            $sliced,
            $allRiwayat->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.keuangan.laba-rugi', compact('labaBersih', 'totalPemasukan', 'totalPengeluaran', 'riwayat'));
    }


    public function pengeluaranLainnya()
    {
        return view('admin.keuangan.pengeluaran-lainnya');
    }

    // Fungsi untuk memproses simpan Pengeluaran Lainnya
    public function storePengeluaranLainnya(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'jenis' => 'required|string',
            'nominal' => 'required|numeric|min:1',
            'status' => 'required|in:Lunas,Belum Lunas'
        ]);

        // 2. Generate Kode Kas (KS-0000001 dst) biar seragam
        $lastKas = Kas::where('kode_kas', 'LIKE', 'KS-%')->latest('id')->first();
        $lastCount = $lastKas ? (int) substr($lastKas->kode_kas, 3) : 0;
        $kodeKas = 'KS-' . str_pad($lastCount + 1, 7, '0', STR_PAD_LEFT);

        // 3. Gabungkan keterangan dengan status
        $keterangan = 'Pengeluaran Lainnya (' . $request->status . ')';

        // 4. Simpan ke tabel Kas sebagai uang KELUAR
        Kas::create([
            'kode_kas' => $kodeKas,
            'tipe' => 'Keluar',
            'jenis' => $request->jenis, // Cth: Listrik, Operasional
            'nominal' => $request->nominal,
            'keterangan' => $keterangan,
            'user_id' => Auth::id()
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data pengeluaran berhasil dicatat ke dalam Kas!');
    }
}