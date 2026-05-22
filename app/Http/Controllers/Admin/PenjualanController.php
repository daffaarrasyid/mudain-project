<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Servis; // <-- Panggil model Servis di sini
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    // Halaman Entry Penjualan (Kasir)
    public function entry()
    {
        // Generate Invoice Unik (Contoh: BLP-20260508-0001)
        $dateStr = now()->format('Ymd');
        $lastPenjualan = Penjualan::where('invoice', 'LIKE', 'BLP-' . $dateStr . '-%')->latest()->first();

        if ($lastPenjualan) {
            $lastCount = (int) substr($lastPenjualan->invoice, -4);
            $invoice = 'BLP-' . $dateStr . '-' . str_pad($lastCount + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $invoice = 'BLP-' . $dateStr . '-0001';
        }

        $customers = Customer::all();
        $produks = Produk::orderBy('nama_item', 'asc')->get();
        $servis = Servis::orderBy('nama_servis', 'asc')->get();

        return view('admin.transaksi.entry-penjualan', compact('invoice', 'customers', 'produks', 'servis'));
    }

    // Proses Simpan Transaksi
    public function store(Request $request)
    {
        // Decode data cart dari JSON Alpine (Dipisah antara Produk dan Servis)
        $cartProduk = json_decode($request->cart_produk, true) ?? [];
        $cartService = json_decode($request->cart_service, true) ?? [];

        if (empty($cartProduk) && empty($cartService)) {
            return back()->withErrors(['cart' => 'Keranjang produk dan servis tidak boleh kosong!']);
        }

        DB::beginTransaction();
        try {
            // 1. Simpan header penjualan
            $penjualan = Penjualan::create([
                'invoice' => $request->invoice,
                'user_id' => Auth::id() ?? 1,
                'customer_id' => $request->customer_id,
                'total_harga' => $request->total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $request->kembalian,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            // 2. Simpan detail KERANJANG PRODUK
            foreach ($cartProduk as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => $item['id'],
                    'servis_id' => null,
                    'harga_satuan' => $item['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['total'],
                ]);

                // Kurangi stok produk (bisa menjadi negatif jika stok awalnya 0)
                $produk = Produk::find($item['id']);
                if ($produk) {
                    $produk->decrement('stok', $item['qty']);

                    // Catat ke tabel Stock In/Out
                    Stok::create([
                        'produk_id'  => $produk->id,
                        'jenis'      => 'Keluar',
                        'jumlah'     => $item['qty'],
                        'nilai'      => $item['harga'] * $item['qty'],
                        'tanggal'    => now(),
                        'keterangan' => 'Penjualan Invoice ' . $request->invoice,
                    ]);
                }
            }

            // 3. Simpan detail KERANJANG SERVIS
            foreach ($cartService as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => null, // Pastikan ini null
                    'servis_id' => $item['id'], // ID dari servis
                    'harga_satuan' => $item['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['total'],
                    'tahap_produksi' => 'Selesai', // Jasa biasanya langsung dianggap selesai
                    'progress' => 100,
                ]);
            }

            // === CATAT KE BUKU KAS ===
            // 1. Generate Kode Kas (KS-0000001 dst)
            $lastKas = \App\Models\Kas::where('kode_kas', 'LIKE', 'KS-%')->latest('id')->first();
            $lastCount = $lastKas ? (int) substr($lastKas->kode_kas, 3) : 0;
            $kodeKas = 'KS-' . str_pad($lastCount + 1, 7, '0', STR_PAD_LEFT);

            // 2. Simpan ke tabel Kas
            \App\Models\Kas::create([
                'kode_kas' => $kodeKas,
                'tipe' => 'Masuk',
                'jenis' => 'Penjualan',
                'nominal' => $request->bayar, // Uang yang beneran dibayar customer saat itu
                'keterangan' => 'Pembayaran Invoice ' . $request->invoice,
                'user_id' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('admin.penjualan.entry')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    // UPDATE fungsi daftar()
    public function daftar()
    {
        // Eager load details.produk DAN details.servis
        $penjualans = Penjualan::with(['user', 'customer', 'details.produk', 'details.servis'])->latest()->paginate(15);
        return view('admin.transaksi.daftar-penjualan', compact('penjualans'));
    }

    // UPDATE fungsi pembayaran kredit
    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([
            'nominal_tambah' => 'required|numeric|min:1'
        ]);

        $penjualan = Penjualan::findOrFail($id);

        // Akumulasi: Bayar yang lama ditambah nominal bayaran baru
        $bayarBaru = $penjualan->bayar + $request->nominal_tambah;
        $kembalianBaru = $bayarBaru - $penjualan->total_harga;

        $penjualan->update([
            'bayar' => $bayarBaru,
            'kembalian' => $kembalianBaru,
            // Jika total bayar sudah nutupin total harga, otomatis Lunas
            'status_pembayaran' => $bayarBaru >= $penjualan->total_harga ? 'Lunas' : 'Kredit'
        ]);

        return back()->with('success', 'Pembayaran cicilan berhasil ditambahkan!');
    }

    // UPDATE fungsi cetak invoice
    public function cetakInvoice($id)
    {
        // Eager load details.produk DAN details.servis
        $penjualan = Penjualan::with(['user', 'customer', 'details.produk', 'details.servis'])->findOrFail($id);

        // Render view HTML menjadi file PDF
        $pdf = Pdf::loadView('admin.transaksi.invoice-pdf', compact('penjualan'));

        // Otomatis download file dengan nama Invoice-BLPXXX.pdf
        return $pdf->download('Invoice-' . $penjualan->invoice . '.pdf');
    }

    // fungsi hapus (TANPA ROLLBACK STOK)
    public function destroy($id)
    {
        $penjualan = Penjualan::with('details')->findOrFail($id);

        $penjualan->delete();
        return back()->with('success', 'Transaksi dibatalkan dan dihapus dari sistem!');
    }
}
