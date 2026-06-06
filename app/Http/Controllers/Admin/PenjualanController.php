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
    // Halaman Entry Penjualan (Kasir / Edit Mode)
    public function entry(Request $request)
    {
        $customers = Customer::all();
        $produks = Produk::orderBy('nama_item', 'asc')->get();
        $servis = Servis::orderBy('nama_servis', 'asc')->get();

        $editPenjualan = null;
        $editProdukCart = [];
        $editServiceCart = [];

        if ($request->has('edit_id')) {
            $editPenjualan = Penjualan::with(['customer', 'details.produk', 'details.servis'])->findOrFail($request->edit_id);
            // Cek progress produksi
            if (($editPenjualan->average_progress ?? 0) >= 100) {
                return redirect()->route('admin.penjualan.daftar')->withErrors(['error' => 'Transaksi tidak dapat di-edit karena produksi sudah selesai 100%!']);
            }
            $invoice = $editPenjualan->invoice;
            
            // Map data details ke JSON format yang bisa dipahami Alpine di entry-penjualan
            foreach ($editPenjualan->details as $detail) {
                if ($detail->produk_id) {
                    $editProdukCart[] = [
                        'id' => $detail->produk_id,
                        'kode' => $detail->produk->kode_barang ?? 'Item Dihapus',
                        'nama' => $detail->produk->nama_item ?? 'Item Dihapus',
                        'hargaUmum' => (float)($detail->produk->harga_jual_umum ?? $detail->harga_satuan),
                        'hargaPelanggan' => (float)($detail->produk->harga_pelanggan ?? $detail->harga_satuan),
                        'harga' => (float)$detail->harga_satuan,
                        'qty' => (int)$detail->qty,
                        'total' => (float)$detail->subtotal
                    ];
                } elseif ($detail->servis_id) {
                    $editServiceCart[] = [
                        'id' => $detail->servis_id,
                        'kode' => $detail->servis->kode_servis ?? 'Jasa Dihapus',
                        'nama' => $detail->servis->nama_servis ?? 'Jasa Dihapus',
                        'harga' => (float)$detail->harga_satuan,
                        'qty' => (int)$detail->qty,
                        'total' => (float)$detail->subtotal
                    ];
                }
            }
        } else {
            // Generate Invoice Unik (Contoh: BLP-20260508-0001)
            $dateStr = now()->format('Ymd');
            $lastPenjualan = Penjualan::where('invoice', 'LIKE', 'BLP-' . $dateStr . '-%')->latest()->first();

            if ($lastPenjualan) {
                $lastCount = (int) substr($lastPenjualan->invoice, -4);
                $invoice = 'BLP-' . $dateStr . '-' . str_pad($lastCount + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $invoice = 'BLP-' . $dateStr . '-0001';
            }
        }

        return view('admin.transaksi.entry-penjualan', compact('invoice', 'customers', 'produks', 'servis', 'editPenjualan', 'editProdukCart', 'editServiceCart'));
    }

    // Proses Simpan Transaksi (Create / Update)
    public function store(Request $request)
    {
        // Decode data cart dari JSON 
        $cartProduk = json_decode($request->cart_produk, true) ?? [];
        $cartService = json_decode($request->cart_service, true) ?? [];

        if (empty($cartProduk) && empty($cartService)) {
            return back()->withErrors(['cart' => 'Keranjang produk dan servis tidak boleh kosong!']);
        }

        DB::beginTransaction();
        try {
            if ($request->filled('edit_id')) {
                // LOGIKA UPDATE
                $penjualan = Penjualan::with('details')->findOrFail($request->edit_id);

                if (($penjualan->average_progress ?? 0) >= 100) {
                    return back()->withErrors(['error' => 'Transaksi tidak dapat di-edit karena produksi sudah selesai 100%!']);
                }

                // Pulangkan stok produk lama sebelum dihapus
                foreach ($penjualan->details as $oldDetail) {
                    if ($oldDetail->produk_id) {
                        $produk = Produk::find($oldDetail->produk_id);
                        if ($produk) {
                            $produk->increment('stok', $oldDetail->qty);
                        }
                    }
                }

                // Hapus detail lama dan rekaman stok lama
                $penjualan->details()->delete();
                Stok::where('keterangan', 'Penjualan Invoice ' . $penjualan->invoice)->delete();

                // Update penjualan header
                $penjualan->update([
                    'customer_id' => $request->customer_id,
                    'total_harga' => $request->total_harga,
                    'bayar' => $request->bayar,
                    'kembalian' => $request->kembalian,
                    'status_pembayaran' => $request->status_pembayaran,
                    'jatuh_tempo' => $request->kembalian < 0 ? $request->jatuh_tempo : null,
                ]);
            } else {
                // LOGIKA CREATE BARU
                $penjualan = Penjualan::create([
                    'invoice' => $request->invoice,
                    'user_id' => Auth::id() ?? 1,
                    'customer_id' => $request->customer_id,
                    'total_harga' => $request->total_harga,
                    'bayar' => $request->bayar,
                    'kembalian' => $request->kembalian,
                    'status_pembayaran' => $request->status_pembayaran,
                    'jatuh_tempo' => $request->kembalian < 0 ? $request->jatuh_tempo : null,
                ]);
            }

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
                        'keterangan' => 'Penjualan Invoice ' . $penjualan->invoice,
                    ]);
                }
            }

            // 3. Simpan detail KERANJANG SERVIS
            foreach ($cartService as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => null, 
                    'servis_id' => $item['id'], 
                    'harga_satuan' => $item['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['total'],
                    'tahap_produksi' => 'Selesai', // Jasa biasanya langsung dianggap selesai
                    'progress' => 100,
                ]);
            }

            DB::commit();

            if ($request->filled('edit_id')) {
                return redirect()->route('admin.penjualan.daftar')->with('success', 'Transaksi invoice ' . $penjualan->invoice . ' berhasil diperbarui!');
            }
            return redirect()->route('admin.penjualan.entry')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function daftar()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Eager load details.produk DAN details.servis
        $penjualans = Penjualan::with(['user', 'customer', 'details.produk', 'details.servis'])->latest()->paginate($perPage)->withQueryString();
        return view('admin.transaksi.daftar-penjualan', compact('penjualans'));
    }

    // UPDATE fungsi pembayaran kredit
    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([
            'nominal_tambah' => 'required|numeric|min:1'
        ]);

        $penjualan = Penjualan::findOrFail($id);

        $sisaPiutang = (float) ($penjualan->total_harga - $penjualan->bayar);
        $nominalTambah = min((float) $request->nominal_tambah, $sisaPiutang);

        // Akumulasi: Bayar yang lama ditambah nominal bayaran baru
        $bayarBaru = (float) $penjualan->bayar + $nominalTambah;
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
