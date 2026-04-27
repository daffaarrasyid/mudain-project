<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hutang;
use App\Models\Pembeli;
use App\Models\Pemasok;
use App\Models\Piutang;
use App\Models\Produk;
use App\Services\KeuanganService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function entryPenjualan()
    {
        return view('admin.transaksi.entry-penjualan', [
            'pembeliOptions' => Pembeli::orderBy('nama_pembeli')->get(),
            'produkOptions' => Produk::with(['kategori', 'satuan', 'stok'])->orderBy('nama_produk')->get(),
        ]);
    }

    public function storePenjualan(Request $request, TransaksiService $transaksiService)
    {
        $data = $request->validate([
            'id_pembeli' => ['nullable', 'exists:pembeli,id_pembeli'],
            'tanggal' => ['required', 'date'],
            'status_pembayaran' => ['required', 'in:tunai,piutang'],
            'jatuh_tempo' => ['nullable', 'date'],
            'catatan' => ['nullable', 'string'],
            'nama_desain' => ['nullable', 'string', 'max:255'],
            'deskripsi_desain' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*.id_produk' => ['nullable', 'exists:produk,id_produk'],
            'items.*.jumlah' => ['nullable', 'integer', 'min:1'],
            'items.*.harga' => ['nullable', 'numeric', 'min:0'],
        ]);

        $transaksiService->createPenjualan($data, $request->user());

        return redirect()->route('admin.transaksi.daftar-penjualan')->with('success', 'Penjualan berhasil disimpan.');
    }

    public function daftarPenjualan(Request $request, TransaksiService $transaksiService)
    {
        return view('admin.transaksi.daftar-penjualan', [
            'items' => $transaksiService->getAllPenjualan([
                'search' => $request->string('search')->toString(),
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function entryPembelian()
    {
        return view('admin.transaksi.entry-pembelian', [
            'pemasokOptions' => Pemasok::orderBy('nama_pemasok')->get(),
            'produkOptions' => Produk::with(['kategori', 'satuan'])->orderBy('nama_produk')->get(),
        ]);
    }

    public function storePembelian(Request $request, TransaksiService $transaksiService)
    {
        $data = $request->validate([
            'id_pemasok' => ['required', 'exists:pemasok,id_pemasok'],
            'tanggal' => ['required', 'date'],
            'status_pembayaran' => ['required', 'in:tunai,hutang'],
            'jatuh_tempo' => ['nullable', 'date'],
            'catatan' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*.id_produk' => ['nullable', 'exists:produk,id_produk'],
            'items.*.jumlah' => ['nullable', 'integer', 'min:1'],
            'items.*.harga' => ['nullable', 'numeric', 'min:0'],
        ]);

        $transaksiService->createPembelian($data, $request->user());

        return redirect()->route('admin.transaksi.daftar-pembelian')->with('success', 'Pembelian berhasil disimpan.');
    }

    public function daftarPembelian(Request $request, TransaksiService $transaksiService)
    {
        return view('admin.transaksi.daftar-pembelian', [
            'items' => $transaksiService->getAllPembelian([
                'search' => $request->string('search')->toString(),
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function hutang(Request $request, KeuanganService $keuanganService)
    {
        return view('admin.transaksi.hutang', [
            'items' => $keuanganService->getAllHutang([
                'search' => $request->string('search')->toString(),
                'status' => $request->input('status'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function bayarHutang(Request $request, Hutang $hutang, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:0.01'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $keuanganService->bayarHutang($hutang, $data, $request->user());

        return redirect()->route('admin.transaksi.hutang')->with('success', 'Pembayaran hutang berhasil dicatat.');
    }

    public function updateStatusHutang(Request $request, Hutang $hutang, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'status' => ['required', 'in:belum_lunas,sebagian,lunas'],
        ]);

        $keuanganService->updateStatusHutang($hutang, $data['status'], $request->user());

        return redirect()->route('admin.transaksi.hutang')->with('success', 'Status hutang berhasil diperbarui.');
    }

    public function piutang(Request $request, KeuanganService $keuanganService)
    {
        return view('admin.transaksi.piutang', [
            'items' => $keuanganService->getAllPiutang([
                'search' => $request->string('search')->toString(),
                'status' => $request->input('status'),
                'per_page' => $request->integer('per_page', 10),
            ]),
        ]);
    }

    public function bayarPiutang(Request $request, Piutang $piutang, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:0.01'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $keuanganService->bayarPiutang($piutang, $data, $request->user());

        return redirect()->route('admin.transaksi.piutang')->with('success', 'Pembayaran piutang berhasil dicatat.');
    }

    public function updateStatusPiutang(Request $request, Piutang $piutang, KeuanganService $keuanganService)
    {
        $data = $request->validate([
            'status' => ['required', 'in:belum_lunas,sebagian,lunas'],
        ]);

        $keuanganService->updateStatusPiutang($piutang, $data['status'], $request->user());

        return redirect()->route('admin.transaksi.piutang')->with('success', 'Status piutang berhasil diperbarui.');
    }
}
