<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanBarang(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Barang',
            'description' => 'Daftar barang lengkap beserta kategori, satuan, pemasok, dan stok aktif.',
            'items' => $laporanService->generateLaporanBarang($request->all()),
            'columns' => [
                ['label' => 'Kode', 'key' => 'id_produk'],
                ['label' => 'Nama Produk', 'key' => 'nama_produk'],
                ['label' => 'Kategori', 'key' => 'kategori.nama_kategori'],
                ['label' => 'Satuan', 'key' => 'satuan.nama_satuan'],
                ['label' => 'Pemasok', 'key' => 'pemasok.nama_pemasok'],
                ['label' => 'Harga', 'key' => 'harga', 'format' => 'currency'],
                ['label' => 'Stok Aktif', 'key' => 'stok_aktif'],
            ],
        ]);
    }

    public function laporanPenjualan(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Penjualan',
            'description' => 'Rekap transaksi penjualan berikut total nominal dan status pembayarannya.',
            'items' => $laporanService->generateLaporanPenjualan($request->all()),
            'columns' => [
                ['label' => 'Invoice', 'key' => 'id_penjualan'],
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Customer', 'key' => 'pembeli.nama_pembeli'],
                ['label' => 'Status', 'key' => 'status_pembayaran'],
                ['label' => 'Total', 'key' => 'total', 'format' => 'currency'],
            ],
        ]);
    }

    public function laporanPembelian(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Pembelian',
            'description' => 'Rekap pembelian perusahaan dari pemasok beserta nilai transaksinya.',
            'items' => $laporanService->generateLaporanPembelian($request->all()),
            'columns' => [
                ['label' => 'Invoice', 'key' => 'id_pembelian'],
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Pemasok', 'key' => 'pemasok.nama_pemasok'],
                ['label' => 'Status', 'key' => 'status_pembayaran'],
                ['label' => 'Total', 'key' => 'total', 'format' => 'currency'],
            ],
        ]);
    }

    public function laporanKeuangan(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Laba Rugi',
            'description' => 'Ringkasan laba rugi harian berdasarkan penjualan, pembelian, dan pengeluaran lainnya.',
            'items' => $laporanService->generateLaporanLabaRugi($request->all()),
            'columns' => [
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'date'],
                ['label' => 'Penjualan', 'key' => 'total_penjualan', 'format' => 'currency'],
                ['label' => 'Pembelian', 'key' => 'total_pembelian', 'format' => 'currency'],
                ['label' => 'Pengeluaran', 'key' => 'total_pengeluaran', 'format' => 'currency'],
                ['label' => 'Laba / Rugi', 'key' => 'laba_rugi', 'format' => 'currency'],
            ],
        ]);
    }

    public function laporanArusKas(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Arus Kas',
            'description' => 'Seluruh mutasi kas masuk dan keluar dari penjualan, pembelian, pembayaran, dan pengeluaran.',
            'items' => $laporanService->generateLaporanArusKas($request->all()),
            'columns' => [
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Jenis', 'key' => 'jenis'],
                ['label' => 'Arah', 'key' => 'arah'],
                ['label' => 'Jumlah', 'key' => 'jumlah', 'format' => 'currency'],
                ['label' => 'Keterangan', 'key' => 'keterangan'],
            ],
        ]);
    }

    public function laporanStok(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Stok In/Out',
            'description' => 'Histori pergerakan stok masuk dan keluar per produk.',
            'items' => $laporanService->generateLaporanStokInOut($request->all()),
            'columns' => [
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Produk', 'key' => 'produk.nama_produk'],
                ['label' => 'Masuk', 'key' => 'jumlah_masuk'],
                ['label' => 'Keluar', 'key' => 'jumlah_keluar'],
                ['label' => 'Keterangan', 'key' => 'keterangan'],
            ],
        ]);
    }

    public function laporanHutang(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Hutang',
            'description' => 'Pantau hutang pembelian beserta status dan sisa kewajibannya.',
            'items' => $laporanService->generateLaporanHutang($request->all()),
            'columns' => [
                ['label' => 'Pembelian', 'key' => 'id_pembelian'],
                ['label' => 'Pemasok', 'key' => 'pembelian.pemasok.nama_pemasok'],
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Status', 'key' => 'status'],
                ['label' => 'Total Hutang', 'key' => 'jumlah_hutang', 'format' => 'currency'],
                ['label' => 'Sisa', 'key' => 'sisa', 'format' => 'currency'],
            ],
        ]);
    }

    public function laporanPiutang(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'title' => 'Laporan Piutang',
            'description' => 'Pantau piutang penjualan beserta status dan sisa penagihannya.',
            'items' => $laporanService->generateLaporanPiutang($request->all()),
            'columns' => [
                ['label' => 'Penjualan', 'key' => 'id_penjualan'],
                ['label' => 'Customer', 'key' => 'penjualan.pembeli.nama_pembeli'],
                ['label' => 'Tanggal', 'key' => 'tanggal', 'format' => 'datetime'],
                ['label' => 'Status', 'key' => 'status'],
                ['label' => 'Total Piutang', 'key' => 'jumlah_piutang', 'format' => 'currency'],
                ['label' => 'Sisa', 'key' => 'sisa', 'format' => 'currency'],
            ],
        ]);
    }
}
