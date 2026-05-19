<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Peta: route name prefix => permission key (format: "Modul_SubModul")
     * Untuk Owner/Super Admin dengan permissions ['*'], semua akses diizinkan.
     */
    protected array $routePermissionMap = [
        // Master Data
        'admin.data-produk'   => 'Master Data_Data Produk',
        'admin.supplier'      => 'Master Data_Data Supplier',
        'admin.kategori'      => 'Master Data_Data Kategori',
        'admin.satuan'        => 'Master Data_Data Satuan',
        'admin.servis'        => 'Master Data_Data Kategori', // servis termasuk master data umum
        'admin.staf'          => 'Master Data_Data Kategori',
        'admin.customer'      => 'Master Data_Data Produk',
        'admin.stok'          => 'Master Data_Data Produk',

        // Transaksi - Penjualan
        'admin.penjualan.entry'   => 'Transaksi_Entry Penjualan',
        'admin.penjualan.store'   => 'Transaksi_Entry Penjualan',
        'admin.penjualan.daftar'  => 'Transaksi_Daftar Penjualan',
        'admin.penjualan.update-pembayaran' => 'Transaksi_Daftar Penjualan',
        'admin.penjualan.destroy' => 'Transaksi_Daftar Penjualan',
        'admin.penjualan.cetak'   => 'Transaksi_Daftar Penjualan',

        // Transaksi - Pembelian
        'admin.pembelian.entry'   => 'Transaksi_Entry Pembelian',
        'admin.pembelian.store'   => 'Transaksi_Entry Pembelian',
        'admin.pembelian.daftar'  => 'Transaksi_Daftar Pembelian',
        'admin.pembelian.update-pembayaran' => 'Transaksi_Daftar Pembelian',
        'admin.pembelian.destroy' => 'Transaksi_Daftar Pembelian',

        // Transaksi - Hutang & Piutang
        'admin.transaksi.hutang'  => 'Transaksi_Hutang',
        'admin.transaksi.piutang' => 'Transaksi_Piutang',

        // Produksi
        'admin.produksi.update-produksi' => 'Produksi_Update Produksi',
        'admin.produksi.update-desain'   => 'Produksi_Update Desain',

        // Keuangan
        'admin.keuangan.kas'                  => 'Keuangan_Kas',
        'admin.keuangan.kas.store'            => 'Keuangan_Kas',
        'admin.keuangan.laba-rugi'            => 'Keuangan_Laba Rugi',
        'admin.keuangan.pengeluaran-lainnya'  => 'Keuangan_Kas',
        'admin.keuangan.pengeluaran-lainnya.store' => 'Keuangan_Kas',

        // Konten
        'admin.konten.mitra'       => 'Konten_Mitra',
        'admin.konten.mitra.store' => 'Konten_Mitra',
        'admin.konten.mitra.update'   => 'Konten_Mitra',
        'admin.konten.mitra.destroy'  => 'Konten_Mitra',
        'admin.konten.produk'         => 'Konten_Produk (Konten)',
        'admin.konten.produk.store'   => 'Konten_Produk (Konten)',
        'admin.konten.produk.update'  => 'Konten_Produk (Konten)',
        'admin.konten.produk.destroy' => 'Konten_Produk (Konten)',
        'admin.konten.portofolio'         => 'Konten_Portofolio',
        'admin.konten.portofolio.store'   => 'Konten_Portofolio',
        'admin.konten.portofolio.update'  => 'Konten_Portofolio',
        'admin.konten.portofolio.destroy' => 'Konten_Portofolio',
        'admin.konten.testimoni'         => 'Konten_Testimoni',
        'admin.konten.testimoni.store'   => 'Konten_Testimoni',
        'admin.konten.testimoni.update'  => 'Konten_Testimoni',
        'admin.konten.testimoni.destroy' => 'Konten_Testimoni',

        // Laporan
        'admin.laporan.penjualan'        => 'Laporan_Laporan Penjualan',
        'admin.laporan.penjualan.export' => 'Laporan_Laporan Penjualan',
        'admin.laporan.pembelian'        => 'Laporan_Laporan Pembelian',
        'admin.laporan.pembelian.export' => 'Laporan_Laporan Pembelian',
        'admin.laporan.keuangan'         => 'Laporan_Laporan Keuangan',
        'admin.laporan.kas.export'       => 'Laporan_Laporan Keuangan',
        'admin.laporan.laba-kotor.export'  => 'Laporan_Laporan Keuangan',
        'admin.laporan.laba-bersih.export' => 'Laporan_Laporan Keuangan',
        'admin.laporan.barang'           => 'Laporan_Laporan Produksi',
        'admin.laporan.barang.export'    => 'Laporan_Laporan Produksi',
        'admin.laporan.stok'             => 'Laporan_Laporan Produksi',
        'admin.laporan.stok.export'      => 'Laporan_Laporan Produksi',
        'admin.laporan.hutang'           => 'Transaksi_Hutang',
        'admin.laporan.hutang.export'    => 'Transaksi_Hutang',
        'admin.laporan.piutang'          => 'Transaksi_Piutang',
        'admin.laporan.piutang.export'   => 'Transaksi_Piutang',

        // User & Role Management — khusus superadmin (tidak ada permission key = otomatis blok non-superadmin)
        'admin.user.role'            => '__superadmin__',
        'admin.user.role.store'      => '__superadmin__',
        'admin.user.role.update'     => '__superadmin__',
        'admin.user.role.destroy'    => '__superadmin__',
        'admin.user.pengguna'        => '__superadmin__',
        'admin.user.pengguna.store'  => '__superadmin__',
        'admin.user.pengguna.update' => '__superadmin__',
        'admin.user.pengguna.destroy'=> '__superadmin__',
        'admin.user.histori'         => '__superadmin__',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Belum login — biarkan auth middleware handle
        if (!$user) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        // Route tidak ada di map — bebas diakses (dashboard, dll)
        if (!$routeName || !array_key_exists($routeName, $this->routePermissionMap)) {
            return $next($request);
        }

        // Load role + permissions
        $role = $user->load('role')->role;
        $permissions = $role?->permissions ?? [];

        // Superadmin (wildcard '*') — izinkan semua
        if (in_array('*', $permissions)) {
            return $next($request);
        }

        $required = $this->routePermissionMap[$routeName];

        // Route yang membutuhkan superadmin
        if ($required === '__superadmin__') {
            abort(403, 'Halaman ini hanya bisa diakses oleh Owner/Super Admin.');
        }

        // Cek apakah permission ada di role user
        if (!in_array($required, $permissions)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
