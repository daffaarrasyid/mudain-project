<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penjualan;

class LaporanController extends Controller
{
    // Fungsi untuk menampilkan halaman Laporan Barang
    public function laporanBarang()
    {
        // Tarik data supplier buat ngisi dropdown secara dinamis
        $suppliers = Supplier::all(); 
        
        return view('admin.laporan.barang', compact('suppliers'));
    }

    // FUNGSI BARU: Export Data ke CSV (Bisa dibuka di Excel)
    public function exportBarang(Request $request)
    {
        // Tarik data produk. Kalau ada filter supplier_id, pakai where()
        $query = Produk::query();
        
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
            $supplier = Supplier::find($request->supplier_id);
            $namaFile = 'Laporan_Barang_' . str_replace(' ', '_', $supplier->nama_supplier ?? 'Supplier') . '_' . date('Y-m-d') . '.csv';
        } else {
            $namaFile = 'Laporan_Semua_Barang_' . date('Y-m-d') . '.csv';
        }

        $produks = $query->get();

        // Siapkan header untuk file CSV agar langsung ter-download
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$namaFile",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Header Kolom di dalam file Excel
        $columns = ['No', 'Kode', 'Nama Barang', 'Harga Umum', 'Harga Pelanggan']; // Tambahin 'Stok' kalau MTO lo nyatet stok

        // Buat file dan tulis datanya
        $callback = function() use($produks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header kolom

            foreach ($produks as $index => $produk) {
                $row['No'] = $index + 1;
                $row['Kode'] = $produk->kode_barang;
                $row['Nama Barang'] = $produk->nama_item;
                $row['Harga Umum'] = $produk->harga_jual_umum;
                $row['Harga Pelanggan'] = $produk->harga_pelanggan;

                fputcsv($file, [$row['No'], $row['Kode'], $row['Nama Barang'], $row['Harga Umum'], $row['Harga Pelanggan']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Fungsi untuk menampilkan halaman Laporan Penjualan
    public function laporanPenjualan()
    {
        return view('admin.laporan.penjualan');
    }

    // FUNGSI BARU: Export PDF Laporan Penjualan
    public function exportPenjualan(Request $request)
    {
        // 1. Validasi Input Tanggal
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // 2. Format tanggal agar mencakup waktu 00:00:00 sampai 23:59:59
        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // 3. Tarik data penjualan berdasarkan range tanggal
        $penjualans = Penjualan::with(['customer', 'user'])
                        ->whereBetween('created_at', [$awal, $akhir])
                        ->orderBy('created_at', 'asc')
                        ->get();

        // 4. Hitung Total Keseluruhan untuk di laporan
        $totalPendapatan = $penjualans->sum('total_harga');

        // 5. Render ke PDF
        $pdf = Pdf::loadView('admin.laporan.pdf-penjualan', compact('penjualans', 'totalPendapatan', 'request'));
        
        // Bersihkan output buffer biar PDF gak error/blank
        ob_clean();

        // Gunakan stream agar terbuka di tab baru, bukan langsung paksa download
        return $pdf->stream('Laporan_Penjualan_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }

    // Fungsi untuk menampilkan halaman Laporan Pembelian
    public function laporanPembelian()
    {
        return view('admin.laporan.pembelian');
    }

    public function exportPembelian(Request $request)
    {
        // 1. Validasi Input Tanggal
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // 2. Format tanggal (mencakup waktu 00:00:00 sampai 23:59:59)
        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // 3. Tarik data pembelian berdasarkan range tanggal
        // Asumsi relasi di model Pembelian adalah 'supplier' dan 'user'
        $pembelians = \App\Models\Pembelian::with(['supplier', 'user'])
                        ->whereBetween('created_at', [$awal, $akhir])
                        ->orderBy('created_at', 'asc')
                        ->get();

        // 4. Hitung Total Pengeluaran Pembelian
        $totalPengeluaran = $pembelians->sum('total_harga');

        // 5. Render ke PDF
        $pdf = Pdf::loadView('admin.laporan.pdf-pembelian', compact('pembelians', 'totalPengeluaran', 'request'));
        
        // Bersihkan output buffer
        ob_clean();

        // Buka di tab baru (stream)
        return $pdf->stream('Laporan_Pembelian_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }

    // Fungsi untuk menampilkan halaman Laporan Laba Rugi
    public function laporanKeuangan()
    {
        return view ('admin.laporan.keuangan');
    }


    // Fungsi untuk menampilkan halaman Laporan Stok In/Out
    public function laporanStok()
    {
        return view('admin.laporan.stok');
    }

    // Fungsi untuk menampilkan halaman Laporan Hutang
    public function laporanHutang()
    {
        return view('admin.laporan.hutang');
    }

    // Fungsi untuk menampilkan halaman Laporan Piutang
    public function laporanPiutang()
    {
        return view('admin.laporan.piutang');
    }
}