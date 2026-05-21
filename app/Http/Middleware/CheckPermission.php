<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Peta: route name prefix => permission key (format: "Modul_SubModul")
     * Jika route name adalah resource/action seperti admin.data-produk.index,
     * maka akan cocok dengan prefix admin.data-produk.
     * Untuk Owner/Super Admin dengan permissions ['*'], semua akses diizinkan.
     */
    protected array $routePermissionMap = [
        // Master Data
        'admin.data-produk'   => 'Master Data_Data Produk',
        'admin.supplier'      => 'Master Data_Data Supplier',
        'admin.kategori'      => 'Master Data_Data Kategori',
        'admin.satuan'        => 'Master Data_Data Satuan',
        'admin.servis'        => 'Master Data_Data Servis',
        'admin.staf'          => 'Master Data_Data Staf',
        'admin.customer'      => 'Master Data_Data Customer',
        'admin.stok'          => 'Master Data_Stok In/Out',

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
        'admin.keuangan.pengeluaran-lainnya'  => 'Keuangan_Pengeluaran Lainnya',
        'admin.keuangan.pengeluaran-lainnya.store' => 'Keuangan_Pengeluaran Lainnya',

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
        'admin.laporan.barang'           => 'Laporan_Laporan Barang',
        'admin.laporan.barang.export'    => 'Laporan_Laporan Barang',
        'admin.laporan.stok'             => 'Laporan_Laporan Stok',
        'admin.laporan.stok.export'      => 'Laporan_Laporan Stok',
        'admin.laporan.hutang'           => 'Laporan_Laporan Hutang',
        'admin.laporan.hutang.export'    => 'Laporan_Laporan Hutang',
        'admin.laporan.piutang'          => 'Laporan_Laporan Piutang',
        'admin.laporan.piutang.export'   => 'Laporan_Laporan Piutang',

        // User & Role Management — khusus superadmin
        'admin.user.role'            => '__superadmin__',
        'admin.user.role.store'      => '__superadmin__',
        'admin.user.role.update'     => '__superadmin__',
        'admin.user.role.destroy'    => '__superadmin__',
        'admin.user.pengguna'        => '__superadmin__',
        'admin.user.pengguna.store'  => '__superadmin__',
        'admin.user.pengguna.update' => '__superadmin__',
        'admin.user.pengguna.destroy'=> '__superadmin__',
        'admin.user.histori'         => '__superadmin__',
        'admin.user.histori.clear'   => '__superadmin__',
        'admin.user.histori.export'  => '__superadmin__',

        // Tools — khusus superadmin
        'admin.tools.generate-barcode'     => '__superadmin__',
        'admin.tools.backup-data'          => '__superadmin__',
        'admin.tools.backup-data.process'  => '__superadmin__',

        // Grafik — khusus superadmin
        'admin.grafik.index'               => '__superadmin__',

        // Dashboard & Chart (diizinkan untuk semua, akan di-filter di controller jika perlu)
        // Tidak perlu di-protect di middleware
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Belum login — biarkan auth middleware handle
        if (!$user) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        // Jika tidak ada route name atau route publik (non-admin) — bebas diakses
        if (!$routeName) {
            return $next($request);
        }

        // Load role + permissions
        $role = $user->load('role')->role;
        $permissions = $role?->permissions ?? [];

        // Superadmin (wildcard '*') — izinkan semua route admin
        if (in_array('*', $permissions)) {
            return $next($request);
        }

        // Tentukan permission yang diperlukan berdasarkan route name atau prefix route name
        $required = $this->getRequiredPermission($routeName);

        // Jika route adalah admin route tapi tidak ada di permission map — BLOK dengan strict (default deny)
        if (str_starts_with($routeName, 'admin.') && !$required) {
            abort(403, 'Akses ke halaman ini tidak diizinkan.');
        }

        // Jika route bukan admin atau tidak butuh permission khusus — lanjut
        if (!$required) {
            return $next($request);
        }

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

    private function getRequiredPermission(string $routeName): ?string
    {
        if (array_key_exists($routeName, $this->routePermissionMap)) {
            return $this->routePermissionMap[$routeName];
        }

        foreach ($this->routePermissionMap as $prefix => $permission) {
            if (str_starts_with($routeName, $prefix . '.')) {
                return $permission;
            }
        }

        return null;
    }
}
