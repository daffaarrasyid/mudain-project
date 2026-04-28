<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Role;
use App\Services\CMSService;
use App\Services\KeuanganService;
use App\Services\MasterService;
use App\Services\TransaksiService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create([
            'nama_role' => 'Admin',
            'deskripsi_role' => 'Akses penuh ke seluruh modul aplikasi.',
            'hak_akses' => ['dashboard', 'master-data', 'transaksi', 'keuangan', 'laporan', 'grafik', 'tools', 'konten', 'user'],
        ]);

        $admin = Pengguna::create([
            'id_role' => $adminRole->id_role,
            'nama_user' => 'Administrator Mudain',
            'username' => 'admin',
            'password' => 'admin12345',
        ]);

        /** @var MasterService $masterService */
        $masterService = app(MasterService::class);
        /** @var TransaksiService $transaksiService */
        $transaksiService = app(TransaksiService::class);
        /** @var KeuanganService $keuanganService */
        $keuanganService = app(KeuanganService::class);
        /** @var CMSService $cmsService */
        $cmsService = app(CMSService::class);

        $kategoriKonveksi = $masterService->createKategori(['nama_kategori' => 'Konveksi'], $admin);
        $kategoriMerch = $masterService->createKategori(['nama_kategori' => 'Merchandise'], $admin);

        $satuanPcs = $masterService->createSatuan(['nama_satuan' => 'Pcs'], $admin);
        $satuanSet = $masterService->createSatuan(['nama_satuan' => 'Set'], $admin);

        $supplierA = $masterService->createPemasok([
            'nama_pemasok' => 'CV Bahan Prima',
            'no_telp' => '081234567890',
            'alamat' => 'Bandung',
        ], $admin);

        $supplierB = $masterService->createPemasok([
            'nama_pemasok' => 'UD Kreatif Jaya',
            'no_telp' => '082233445566',
            'alamat' => 'Yogyakarta',
        ], $admin);

        $customerA = $masterService->createPembeli([
            'nama_pembeli' => 'Himpunan Mahasiswa Teknologi',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081298765432',
            'alamat' => 'Bandung',
        ], $admin);

        $customerB = $masterService->createPembeli([
            'nama_pembeli' => 'Komunitas Kreatif Nusantara',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081277788899',
            'alamat' => 'Jakarta',
        ], $admin);

        $produk1 = $masterService->createProduk([
            'nama_produk' => 'Jaket Organisasi',
            'id_kategori' => $kategoriKonveksi->id_kategori,
            'id_satuan' => $satuanPcs->id_satuan,
            'id_pemasok' => $supplierA->id_pemasok,
            'harga' => 185000,
            'gambar' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
        ], $admin);

        $produk2 = $masterService->createProduk([
            'nama_produk' => 'Paket Seminar Kit',
            'id_kategori' => $kategoriMerch->id_kategori,
            'id_satuan' => $satuanSet->id_satuan,
            'id_pemasok' => $supplierB->id_pemasok,
            'harga' => 95000,
            'gambar' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
        ], $admin);

        $produk3 = $masterService->createProduk([
            'nama_produk' => 'Totebag Custom',
            'id_kategori' => $kategoriMerch->id_kategori,
            'id_satuan' => $satuanPcs->id_satuan,
            'id_pemasok' => $supplierB->id_pemasok,
            'harga' => 45000,
            'gambar' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
        ], $admin);

        $transaksiService->createPembelian([
            'id_pemasok' => $supplierA->id_pemasok,
            'tanggal' => now()->subDays(10)->format('Y-m-d H:i:s'),
            'status_pembayaran' => 'tunai',
            'catatax    n' => 'Pembelian stok awal konveksi',
            'items' => [
                ['id_produk' => $produk1->id_produk, 'jumlah' => 25, 'harga' => 120000],
                ['id_produk' => $produk3->id_produk, 'jumlah' => 40, 'harga' => 25000],
            ],
        ], $admin);

        $transaksiService->createPembelian([
            'id_pemasok' => $supplierB->id_pemasok,
            'tanggal' => now()->subDays(7)->format('Y-m-d H:i:s'),
            'status_pembayaran' => 'hutang',
            'jatuh_tempo' => now()->addDays(14)->toDateString(),
            'catatan' => 'Pembelian seminar kit kredit',
            'items' => [
                ['id_produk' => $produk2->id_produk, 'jumlah' => 20, 'harga' => 60000],
            ],
        ], $admin);

        $transaksiService->createPenjualan([
            'id_pembeli' => $customerA->id_pembeli,
            'tanggal' => now()->subDays(4)->format('Y-m-d H:i:s'),
            'status_pembayaran' => 'tunai',
            'catatan' => 'Penjualan event organisasi',
            'nama_desain' => 'Jaket Angkatan',
            'deskripsi_desain' => 'Warna navy dengan bordir logo.',
            'items' => [
                ['id_produk' => $produk1->id_produk, 'jumlah' => 8, 'harga' => 185000],
                ['id_produk' => $produk3->id_produk, 'jumlah' => 15, 'harga' => 45000],
            ],
        ], $admin);

        $transaksiService->createPenjualan([
            'id_pembeli' => $customerB->id_pembeli,
            'tanggal' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status_pembayaran' => 'piutang',
            'jatuh_tempo' => now()->addDays(10)->toDateString(),
            'catatan' => 'Penjualan kebutuhan seminar',
            'nama_desain' => 'Paket Seminar',
            'deskripsi_desain' => 'Desain minimalis sesuai brand event.',
            'items' => [
                ['id_produk' => $produk2->id_produk, 'jumlah' => 10, 'harga' => 95000],
            ],
        ], $admin);

        $hutang = \App\Models\Hutang::first();
        if ($hutang) {
            $keuanganService->bayarHutang($hutang, [
                'jumlah_bayar' => 500000,
                'tanggal' => now()->subDay()->toDateString(),
                'keterangan' => 'Pembayaran termin pertama',
            ], $admin);
        }

        $piutang = \App\Models\Piutang::first();
        if ($piutang) {
            $keuanganService->bayarPiutang($piutang, [
                'jumlah_bayar' => 300000,
                'tanggal' => now()->toDateString(),
                'keterangan' => 'DP customer',
            ], $admin);
        }

        $keuanganService->createPengeluaran([
            'tanggal' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'kategori_pengeluaran' => 'Operasional',
            'keterangan' => 'Biaya listrik dan internet',
            'jumlah_pengeluaran' => 350000,
        ], $admin);

        $cmsService->createMitra([
            'nama_mitra' => 'Universitas Nusantara',
            'logo' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?auto=format&fit=crop&w=300&q=80',
            'deskripsi' => 'Kolaborasi kebutuhan merchandise kampus.',
        ], $admin);

        $cmsService->createMitra([
            'nama_mitra' => 'Startup Kreativa',
            'logo' => 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=300&q=80',
            'deskripsi' => 'Produksi seminar kit dan apparel perusahaan.',
        ], $admin);

        $cmsService->createPortofolio([
            'judul' => 'Produksi Jaket Kepanitiaan',
            'gambar' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
            'deskripsi' => 'Produksi jaket custom untuk panitia event kampus dengan bordir identitas lengkap.',
        ], $admin);

        $cmsService->createPortofolio([
            'judul' => 'Seminar Kit Nasional',
            'gambar' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
            'deskripsi' => 'Paket seminar kit custom untuk acara skala nasional.',
        ], $admin);

        $cmsService->createProdukProfil([
            'nama_produk' => 'Jaket Organisasi Premium',
            'harga' => 185000,
            'gambar' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
            'deskripsi' => 'Jaket organisasi dengan bahan premium dan bordir custom.',
        ], $admin);

        $cmsService->createProdukProfil([
            'nama_produk' => 'Seminar Kit Eksklusif',
            'harga' => 95000,
            'gambar' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
            'deskripsi' => 'Paket seminar kit siap branding untuk event kampus dan perusahaan.',
        ], $admin);
    }
}
