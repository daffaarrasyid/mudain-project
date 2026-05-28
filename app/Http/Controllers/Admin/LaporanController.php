<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Kas;

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

    // 1. FUNGSI EXPORT KAS (PDF)
    public function exportKas(Request $request)
    {
        $request->validate(['tanggal_awal' => 'required|date', 'tanggal_akhir' => 'required|date']);
        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        $kas = $this->getDynamicKas($awal, $akhir);

        $totalMasuk = $kas->where('tipe', 'Masuk')->sum('nominal');
        $totalKeluar = $kas->where('tipe', 'Keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('admin.laporan.pdf-kas', compact('kas', 'totalMasuk', 'totalKeluar', 'saldo', 'request'));
        ob_clean();
        return $pdf->stream('Laporan_Kas_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }

    // 2. FUNGSI EXPORT LABA KOTOR (CSV/Excel) -> (Penjualan vs Pembelian Stok)
    public function exportLabaKotor(Request $request)
    {
        $request->validate(['tanggal_awal' => 'required|date', 'tanggal_akhir' => 'required|date']);
        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // Laba Kotor biasanya cuma ngitung transaksi Penjualan (Masuk) & Pembelian Stok (Keluar) dari data riil
        $transaksi = $this->getDynamicLabaRugi($awal, $akhir)->whereIn('jenis', ['Penjualan', 'Pembelian'])->values();

        $namaFile = 'Laba_Kotor_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$namaFile", "Pragma" => "no-cache"];

        $callback = function() use($transaksi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'No Referensi', 'Kategori', 'Tipe', 'Pendapatan (Masuk)', 'HPP/Pembelian (Keluar)']);
            
            $totalPendapatan = 0; $totalHPP = 0;

            foreach ($transaksi as $trx) {
                $masuk = $trx->tipe == 'Masuk' ? $trx->nominal : 0;
                $keluar = $trx->tipe == 'Keluar' ? $trx->nominal : 0;
                $totalPendapatan += $masuk; $totalHPP += $keluar;

                $formattedDate = \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i');
                fputcsv($file, [$formattedDate, $trx->kode_kas, $trx->jenis, $trx->tipe, $masuk, $keluar]);
            }
            fputcsv($file, ['', '', '', 'TOTAL', $totalPendapatan, $totalHPP]);
            fputcsv($file, ['', '', '', 'LABA KOTOR', $totalPendapatan - $totalHPP, '']);
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    // 3. FUNGSI EXPORT LABA BERSIH (CSV/Excel) -> (Semua Masuk vs Semua Keluar)
    public function exportLabaBersih(Request $request)
    {
        $request->validate(['tanggal_awal' => 'required|date', 'tanggal_akhir' => 'required|date']);
        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        $transaksi = $this->getDynamicLabaRugi($awal, $akhir);

        $namaFile = 'Laba_Bersih_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$namaFile", "Pragma" => "no-cache"];

        $callback = function() use($transaksi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'No Referensi', 'Kategori', 'Keterangan', 'Tipe', 'Pemasukan', 'Pengeluaran']);
            
            $totalMasuk = 0; $totalKeluar = 0;

            foreach ($transaksi as $trx) {
                $masuk = $trx->tipe == 'Masuk' ? $trx->nominal : 0;
                $keluar = $trx->tipe == 'Keluar' ? $trx->nominal : 0;
                $totalMasuk += $masuk; $totalKeluar += $keluar;

                $formattedDate = \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i');
                fputcsv($file, [$formattedDate, $trx->kode_kas, $trx->jenis, $trx->keterangan, $trx->tipe, $masuk, $keluar]);
            }
            fputcsv($file, ['', '', '', '', 'TOTAL', $totalMasuk, $totalKeluar]);
            fputcsv($file, ['', '', '', '', 'LABA BERSIH', $totalMasuk - $totalKeluar, '']);
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    private function getDynamicKas($awal, $akhir)
    {
        return Kas::getDynamicKas($awal, $akhir)->sortBy('created_at')->values();
    }

    private function getDynamicLabaRugi($awal, $akhir)
    {
        return Kas::getDynamicLabaRugi($awal, $akhir)->sortBy('created_at')->values();
    }


    // Fungsi untuk menampilkan halaman Laporan Stok In/Out
    public function laporanStok()
    {
        return view('admin.laporan.stok');
    }

    // FUNGSI BARU: Export PDF Laporan Stok
    public function exportStok(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'jenis' => 'required|in:Semua,Masuk,Keluar'
        ]);

        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // 2. Tarik Data Stok (Asumsi Model bernama RiwayatStok)
        $query = \App\Models\Stok::with(['produk', 'user'])
                    ->whereBetween('created_at', [$awal, $akhir]);

        // 3. Filter berdasarkan Jenis (Jika bukan 'Semua')
        if ($request->jenis != 'Semua') {
            $query->where('jenis', $request->jenis);
        }

        $riwayat = $query->orderBy('created_at', 'asc')->get();

        // 4. Render ke PDF
        $pdf = Pdf::loadView('admin.laporan.pdf-stok', compact('riwayat', 'request'));
        
        ob_clean();
        
        return $pdf->stream('Laporan_Stok_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }

    // Update fungsi ini untuk melempar data Supplier ke dropdown
    public function laporanHutang()
    {
        $suppliers = \App\Models\Supplier::all();
        return view('admin.laporan.hutang', compact('suppliers'));
    }

    // FUNGSI BARU: Export PDF Laporan Hutang
    public function exportHutang(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'supplier_id' => 'required'
        ]);

        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // Tarik data pembelian yang ngutang (Kredit / Belum Lunas)
        $query = \App\Models\Pembelian::with(['supplier', 'user'])
                    ->whereIn('status_pembayaran', ['Hutang', 'Belum Lunas'])
                    ->whereBetween('created_at', [$awal, $akhir]);

        // Filter jika spesifik 1 supplier
        if ($request->supplier_id != 'Semua') {
            $query->where('supplier_id', $request->supplier_id);
        }

        $hutangs = $query->orderBy('created_at', 'asc')->get();

        // Hitung Total Hutang (Total Harga Pembelian - Uang yang sudah dibayar)
        $totalHutang = $hutangs->sum(function ($item) {
            return $item->total_harga - $item->bayar;
        });

        $pdf = Pdf::loadView('admin.laporan.pdf-hutang', compact('hutangs', 'totalHutang', 'request'));
        
        ob_clean();
        return $pdf->stream('Laporan_Hutang_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }

    // Update fungsi ini untuk melempar data Customer ke dropdown
    public function laporanPiutang()
    {
        $customers = \App\Models\Customer::all();
        return view('admin.laporan.piutang', compact('customers'));
    }

    // FUNGSI BARU: Export PDF Laporan Piutang
    public function exportPiutang(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'customer_id' => 'required'
        ]);

        $awal = $request->tanggal_awal . ' 00:00:00';
        $akhir = $request->tanggal_akhir . ' 23:59:59';

        // 2. Tarik data PENJUALAN yang masih Kredit
        $query = Penjualan::with(['customer', 'user'])
                    ->whereIn('status_pembayaran', ['Kredit', 'Belum Lunas'])
                    ->whereBetween('created_at', [$awal, $akhir]);

        // 3. Filter spesifik 1 customer jika dipilih
        if ($request->customer_id != 'Semua') {
            $query->where('customer_id', $request->customer_id);
        }

        $piutangs = $query->orderBy('created_at', 'asc')->get();

        // 4. Hitung Total Piutang (Total Harga Penjualan - Uang yang sudah dibayar Customer)
        $totalPiutang = $piutangs->sum(function ($item) {
            return $item->total_harga - $item->bayar;
        });

        // 5. Render PDF
        $pdf = Pdf::loadView('admin.laporan.pdf-piutang', compact('piutangs', 'totalPiutang', 'request'));
        
        ob_clean();
        return $pdf->stream('Laporan_Piutang_' . $request->tanggal_awal . '_sd_' . $request->tanggal_akhir . '.pdf');
    }
}