<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Peta method HTTP + route name → [action, module, deskripsi]
     */
    protected array $routeMap = [
        // ── MASTER DATA ──
        'admin.data-produk.store'   => ['create', 'Master Data', 'Menambahkan data produk baru'],
        'admin.data-produk.update'  => ['update', 'Master Data', 'Mengubah data produk'],
        'admin.data-produk.destroy' => ['delete', 'Master Data', 'Menghapus data produk'],
        'admin.data-produk.import-excel' => ['create', 'Master Data', 'Import produk dari Excel'],

        'admin.supplier.store'   => ['create', 'Master Data', 'Menambahkan data supplier baru'],
        'admin.supplier.update'  => ['update', 'Master Data', 'Mengubah data supplier'],
        'admin.supplier.destroy' => ['delete', 'Master Data', 'Menghapus data supplier'],
        'admin.supplier.import-excel' => ['create', 'Master Data', 'Import supplier dari Excel'],
        'admin.supplier.export-pdf'   => ['export', 'Master Data', 'Ekspor data supplier ke PDF'],

        'admin.kategori.store'   => ['create', 'Master Data', 'Menambahkan kategori produk baru'],
        'admin.kategori.update'  => ['update', 'Master Data', 'Mengubah kategori produk'],
        'admin.kategori.destroy' => ['delete', 'Master Data', 'Menghapus kategori produk'],

        'admin.satuan.store'   => ['create', 'Master Data', 'Menambahkan satuan produk baru'],
        'admin.satuan.update'  => ['update', 'Master Data', 'Mengubah satuan produk'],
        'admin.satuan.destroy' => ['delete', 'Master Data', 'Menghapus satuan produk'],

        'admin.servis.store'   => ['create', 'Master Data', 'Menambahkan data servis baru'],
        'admin.servis.update'  => ['update', 'Master Data', 'Mengubah data servis'],
        'admin.servis.destroy' => ['delete', 'Master Data', 'Menghapus data servis'],

        'admin.staf.store'   => ['create', 'Master Data', 'Menambahkan data staf baru'],
        'admin.staf.update'  => ['update', 'Master Data', 'Mengubah data staf'],
        'admin.staf.destroy' => ['delete', 'Master Data', 'Menghapus data staf'],

        'admin.customer.store'   => ['create', 'Master Data', 'Menambahkan data customer baru'],
        'admin.customer.update'  => ['update', 'Master Data', 'Mengubah data customer'],
        'admin.customer.destroy' => ['delete', 'Master Data', 'Menghapus data customer'],
        'admin.customer.import-excel' => ['create', 'Master Data', 'Import customer dari Excel'],
        'admin.customer.export-pdf'   => ['export', 'Master Data', 'Ekspor data customer ke PDF'],

        'admin.stok.store'   => ['create', 'Master Data', 'Menambahkan data stok baru'],
        'admin.stok.destroy' => ['delete', 'Master Data', 'Menghapus data stok'],

        // ── TRANSAKSI ──
        'admin.penjualan.store'             => ['create', 'Transaksi', 'Membuat entry penjualan baru'],
        'admin.penjualan.update-pembayaran' => ['update', 'Transaksi', 'Memperbarui pembayaran penjualan'],
        'admin.penjualan.destroy'           => ['delete', 'Transaksi', 'Menghapus data penjualan'],

        'admin.pembelian.store'             => ['create', 'Transaksi', 'Membuat entry pembelian baru'],
        'admin.pembelian.update-pembayaran' => ['update', 'Transaksi', 'Memperbarui pembayaran pembelian'],
        'admin.pembelian.destroy'           => ['delete', 'Transaksi', 'Menghapus data pembelian'],

        // ── PRODUKSI ──
        'admin.produksi.update-produksi' => ['update', 'Produksi', 'Memperbarui progress produksi'],
        'admin.produksi.update-desain'   => ['update', 'Produksi', 'Memperbarui desain produksi'],

        // ── KEUANGAN ──
        'admin.keuangan.kas.store'              => ['create', 'Keuangan', 'Menambahkan transaksi kas baru'],
        'admin.keuangan.pengeluaran-lainnya.store' => ['create', 'Keuangan', 'Menambahkan pengeluaran lainnya'],

        // ── KONTEN ──
        'admin.konten.mitra.store'      => ['create', 'Konten', 'Menambahkan mitra baru'],
        'admin.konten.mitra.update'     => ['update', 'Konten', 'Mengubah data mitra'],
        'admin.konten.mitra.destroy'    => ['delete', 'Konten', 'Menghapus data mitra'],
        'admin.konten.produk.store'     => ['create', 'Konten', 'Menambahkan produk konten baru'],
        'admin.konten.produk.update'    => ['update', 'Konten', 'Mengubah produk konten'],
        'admin.konten.produk.destroy'   => ['delete', 'Konten', 'Menghapus produk konten'],
        'admin.konten.portofolio.store'  => ['create', 'Konten', 'Menambahkan portofolio baru'],
        'admin.konten.portofolio.update' => ['update', 'Konten', 'Mengubah data portofolio'],
        'admin.konten.portofolio.destroy'=> ['delete', 'Konten', 'Menghapus data portofolio'],
        'admin.konten.testimoni.store'   => ['create', 'Konten', 'Menambahkan testimoni baru'],
        'admin.konten.testimoni.update'  => ['update', 'Konten', 'Mengubah data testimoni'],
        'admin.konten.testimoni.destroy' => ['delete', 'Konten', 'Menghapus data testimoni'],

        // ── LAPORAN ──
        'admin.laporan.penjualan.export' => ['export', 'Laporan', 'Ekspor laporan penjualan'],
        'admin.laporan.pembelian.export' => ['export', 'Laporan', 'Ekspor laporan pembelian'],
        'admin.laporan.kas.export'       => ['export', 'Laporan', 'Ekspor laporan kas'],
        'admin.laporan.laba-kotor.export'  => ['export', 'Laporan', 'Ekspor laporan laba kotor'],
        'admin.laporan.laba-bersih.export' => ['export', 'Laporan', 'Ekspor laporan laba bersih'],
        'admin.laporan.barang.export'    => ['export', 'Laporan', 'Ekspor laporan barang'],
        'admin.laporan.stok.export'      => ['export', 'Laporan', 'Ekspor laporan stok'],
        'admin.laporan.hutang.export'    => ['export', 'Laporan', 'Ekspor laporan hutang'],
        'admin.laporan.piutang.export'   => ['export', 'Laporan', 'Ekspor laporan piutang'],

        // ── MANAJEMEN USER & ROLE ──
        'admin.user.role.store'       => ['create', 'Manajemen Role',     'Menambahkan role baru'],
        'admin.user.role.update'      => ['update', 'Manajemen Role',     'Mengubah data role'],
        'admin.user.role.destroy'     => ['delete', 'Manajemen Role',     'Menghapus role'],
        'admin.user.pengguna.store'   => ['create', 'Manajemen Pengguna', 'Menambahkan akun pengguna baru'],
        'admin.user.pengguna.update'  => ['update', 'Manajemen Pengguna', 'Mengubah data pengguna'],
        'admin.user.pengguna.destroy' => ['delete', 'Manajemen Pengguna', 'Menghapus akun pengguna'],
    ];

    /**
     * Field mana yang dibaca sebagai "nama data" per route.
     * Urutan: cek field pertama dulu, jika kosong cek berikutnya.
     */
    protected array $nameFieldMap = [
        'admin.data-produk.store'   => ['nama_produk', 'nama'],
        'admin.data-produk.update'  => ['nama_produk', 'nama'],
        'admin.supplier.store'      => ['nama_supplier', 'nama'],
        'admin.supplier.update'     => ['nama_supplier', 'nama'],
        'admin.kategori.store'      => ['nama_kategori', 'nama'],
        'admin.kategori.update'     => ['nama_kategori', 'nama'],
        'admin.satuan.store'        => ['nama_satuan', 'nama'],
        'admin.satuan.update'       => ['nama_satuan', 'nama'],
        'admin.servis.store'        => ['nama_servis', 'nama'],
        'admin.servis.update'       => ['nama_servis', 'nama'],
        'admin.staf.store'          => ['nama', 'nama_staf'],
        'admin.staf.update'         => ['nama', 'nama_staf'],
        'admin.customer.store'      => ['nama_customer', 'nama'],
        'admin.customer.update'     => ['nama_customer', 'nama'],
        'admin.konten.mitra.store'      => ['nama_mitra', 'nama'],
        'admin.konten.mitra.update'     => ['nama_mitra', 'nama'],
        'admin.konten.produk.store'     => ['nama_produk', 'nama'],
        'admin.konten.produk.update'    => ['nama_produk', 'nama'],
        'admin.konten.portofolio.store'  => ['judul', 'nama'],
        'admin.konten.portofolio.update' => ['judul', 'nama'],
        'admin.konten.testimoni.store'   => ['nama', 'nama_pelanggan'],
        'admin.konten.testimoni.update'  => ['nama', 'nama_pelanggan'],
        'admin.user.role.store'       => ['nama_role', 'nama'],
        'admin.user.role.update'      => ['nama_role', 'nama'],
        'admin.user.pengguna.store'   => ['nama', 'name'],
        'admin.user.pengguna.update'  => ['nama', 'name'],
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat jika user login
        if (!auth()->check()) {
            return $response;
        }

        $routeName = $request->route()?->getName();

        if ($routeName && isset($this->routeMap[$routeName])) {
            // Hanya catat jika response adalah redirect sukses
            if ($response->isRedirect() && $response->getStatusCode() < 400) {
                [$action, $module, $baseDescription] = $this->routeMap[$routeName];

                // Coba ambil nama data dari request
                $dataName = null;
                if (isset($this->nameFieldMap[$routeName])) {
                    foreach ($this->nameFieldMap[$routeName] as $field) {
                        if ($request->filled($field)) {
                            $dataName = $request->input($field);
                            break;
                        }
                    }
                }

                // Susun deskripsi final
                $description = $dataName
                    ? "{$baseDescription} dengan nama \"{$dataName}\""
                    : $baseDescription;

                ActivityLog::record($action, $description, $module, $request);
            }
        }

        return $response;
    }
}
