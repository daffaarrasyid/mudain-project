<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nama' => 'Owner / Super Admin',
                'permissions' => ['*'], // wildcard = semua akses
            ],
            [
                'nama' => 'Sales',
                'permissions' => [
                    'Master Data_Data Produk',
                    'Transaksi_Entry Penjualan',
                    'Transaksi_Daftar Penjualan',
                    'Transaksi_Piutang',
                    'Produksi_Update Produksi',
                    'Laporan_Laporan Penjualan',
                ],
            ],
            [
                'nama' => 'Desainer',
                'permissions' => [
                    'Produksi_Update Desain',
                ],
            ],
            [
                'nama' => 'Admin',
                'permissions' => [
                    'Konten_Mitra',
                    'Konten_Produk (Konten)',
                    'Konten_Portofolio',
                    'Konten_Testimoni',
                ],
            ],
            [
                'nama' => 'Finance',
                'permissions' => [
                    'Transaksi_Daftar Penjualan',
                    'Transaksi_Daftar Pembelian',
                    'Transaksi_Hutang',
                    'Transaksi_Piutang',
                    'Keuangan_Kas',
                    'Keuangan_Laba Rugi',
                    'Laporan_Laporan Penjualan',
                    'Laporan_Laporan Pembelian',
                    'Laporan_Laporan Keuangan',
                ],
            ],
            [
                'nama' => 'Purchasing',
                'permissions' => [
                    'Master Data_Data Produk',
                    'Master Data_Data Supplier',
                    'Transaksi_Entry Pembelian',
                    'Transaksi_Daftar Pembelian',
                    'Transaksi_Hutang',
                    'Laporan_Laporan Pembelian',
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['nama' => $role['nama']], ['permissions' => $role['permissions']]);
        }
    }
}
