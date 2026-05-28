<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Matikan sementara proteksi Foreign Key biar aman saat insert data ID spesifik
        Schema::disableForeignKeyConstraints();

        // 1. Kosongkan tabel (opsional, jaga-jaga kalau db blm kosong)
        $tables = [
            'activity_logs',
            'historis',
            'riwayat_pembayaran_pembelians',
            'riwayat_pembayaran_penjualans',
            'penjualan_details',
            'pembelian_details',
            'pembelians',
            'penjualans',
            'stoks',
            'produks',
            'stafs',
            'kas',
            'users',
            'roles',
            'kategoris',
            'satuans',
            'servis',
            'suppliers',
            'customers',
            'mitras',
            'konten_produks',
            'portofolios',
            'testimonis'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // 2. SEEDER ROLES (Memanggil RoleSeeder)
        $this->call(RoleSeeder::class);

        // 3. SEEDER USERS
        DB::table('users')->insert([
            [
                'id' => 1, 'name' => 'Taufik', 'username' => 'taufik', 'role_id' => 1,
                'email' => 'taufik@example.com', 'telepon' => null, 'alamat' => null,
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => 2, 'name' => 'Sales Demo', 'username' => 'sales', 'role_id' => 2,
                'email' => 'sales@example.com', 'telepon' => '081234567802', 'alamat' => 'Bandung, Indonesia',
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => 3, 'name' => 'Desainer Demo', 'username' => 'desainer', 'role_id' => 3,
                'email' => 'desainer@example.com', 'telepon' => '081234567803', 'alamat' => 'Jakarta, Indonesia',
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => 4, 'name' => 'Admin Demo', 'username' => 'admin', 'role_id' => 4,
                'email' => 'admin@example.com', 'telepon' => '081234567804', 'alamat' => 'Surabaya, Indonesia',
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => 5, 'name' => 'Finance Demo', 'username' => 'finance', 'role_id' => 5,
                'email' => 'finance@example.com', 'telepon' => '081234567805', 'alamat' => 'Medan, Indonesia',
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => 6, 'name' => 'Purchasing Demo', 'username' => 'purchasing', 'role_id' => 6,
                'email' => 'purchasing@example.com', 'telepon' => '081234567806', 'alamat' => 'Semarang, Indonesia',
                'status' => 'Aktif', 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null, 'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 4. MASTER DATA DASAR
        DB::table('kategoris')->insert([
            ['id' => 1, 'nama_kategori' => 'Percetakan', 'created_at' => '2026-05-10 04:33:10', 'updated_at' => '2026-05-10 04:33:10'],
            ['id' => 2, 'nama_kategori' => 'Konveksi', 'created_at' => '2026-05-10 04:33:17', 'updated_at' => '2026-05-10 04:33:17']
        ]);

        DB::table('satuans')->insert([
            ['id' => 1, 'nama_satuan' => 'Pcs', 'created_at' => '2026-05-10 04:33:30', 'updated_at' => '2026-05-10 04:33:30'],
            ['id' => 2, 'nama_satuan' => 'Meter', 'created_at' => '2026-05-10 04:33:38', 'updated_at' => '2026-05-10 04:33:38'],
            ['id' => 3, 'nama_satuan' => 'Lusin', 'created_at' => '2026-05-10 04:33:51', 'updated_at' => '2026-05-10 04:33:51'],
            ['id' => 4, 'nama_satuan' => 'Kodi', 'created_at' => '2026-05-10 04:34:05', 'updated_at' => '2026-05-10 04:34:05']
        ]);

        DB::table('servis')->insert([
            ['id' => 1, 'kode_servis' => 'SRV-001', 'nama_servis' => 'Fotografer', 'harga_dasar' => 500000, 'created_at' => '2026-05-10 04:34:32', 'updated_at' => '2026-05-10 04:34:32'],
            ['id' => 2, 'kode_servis' => 'SRV-002', 'nama_servis' => 'Videografer', 'harga_dasar' => 1000000, 'created_at' => '2026-05-10 04:34:43', 'updated_at' => '2026-05-10 04:34:56']
        ]);

        DB::table('suppliers')->insert([
            ['id' => 1, 'kode_supplier' => 'SP-00001', 'nama_supplier' => 'HSM Family', 'no_telp' => '0812345678910', 'email' => 'hsm@gmail.com', 'nama_bank' => 'BCA', 'no_rekening' => '0987654321', 'alamat' => 'Jakarta', 'created_at' => '2026-05-10 04:36:10', 'updated_at' => '2026-05-10 04:36:10'],
            ['id' => 2, 'kode_supplier' => 'SP-00002', 'nama_supplier' => 'Valoza Store', 'no_telp' => '0812345678919', 'email' => 'valoza@store.com', 'nama_bank' => 'BRI', 'no_rekening' => '1234567890123', 'alamat' => 'Cianjur, Jawa Barat', 'created_at' => '2026-05-10 04:36:49', 'updated_at' => '2026-05-10 04:36:49'],
            ['id' => 3, 'kode_supplier' => 'SP-00003', 'nama_supplier' => 'Kreasi.in', 'no_telp' => '089876543212', 'email' => 'kreasiin@agency.com', 'nama_bank' => 'BCA', 'no_rekening' => '7368123218', 'alamat' => 'Bogor, Indonesia', 'created_at' => '2026-05-10 04:37:30', 'updated_at' => '2026-05-10 04:37:30']
        ]);

        DB::table('customers')->insert([
            ['id' => 1, 'kode_customer' => 'CS-000001', 'nama_customer' => 'Arief', 'no_telp' => '0812345678910', 'email' => 'arief@gmail.com', 'alamat' => 'Cirebon, Jawa Barat', 'jenis_customer' => 'Umum', 'created_at' => '2026-05-10 04:37:59', 'updated_at' => '2026-05-10 04:37:59'],
            ['id' => 2, 'kode_customer' => 'CS-000002', 'nama_customer' => 'July', 'no_telp' => '0812345678910', 'email' => 'july@gmail.com', 'alamat' => 'Bekasi, Indonesia', 'jenis_customer' => 'Pelanggan', 'created_at' => '2026-05-10 04:38:22', 'updated_at' => '2026-05-10 04:38:22'],
            ['id' => 3, 'kode_customer' => 'CS-000003', 'nama_customer' => 'Daffa', 'no_telp' => '0812345678910', 'email' => 'daffa@gmail.com', 'alamat' => 'Tasikmalaya, Jawa Barat', 'jenis_customer' => 'Umum', 'created_at' => '2026-05-10 05:44:27', 'updated_at' => '2026-05-10 05:44:27']
        ]);

        DB::table('stafs')->insert([
            ['id' => 1, 'kode_staf' => 'STF-001', 'nama_staf' => 'Adit', 'no_telp' => '0812345678910', 'servis_id' => 1, 'created_at' => '2026-05-10 04:35:13', 'updated_at' => '2026-05-10 04:35:13'],
            ['id' => 2, 'kode_staf' => 'STF-002', 'nama_staf' => 'Wicaksono', 'no_telp' => '089876543212', 'servis_id' => 2, 'created_at' => '2026-05-10 04:35:24', 'updated_at' => '2026-05-10 04:35:24'],
            ['id' => 3, 'kode_staf' => 'STF-003', 'nama_staf' => 'Moeslimar', 'no_telp' => '0812345678919', 'servis_id' => 1, 'created_at' => '2026-05-10 04:35:39', 'updated_at' => '2026-05-10 04:35:39']
        ]);

        // 4. DATA PRODUK & STOK
        DB::table('produks')->insert([
            ['id' => 1, 'gambar' => null, 'kode_barang' => 'WKS-0001', 'nama_item' => 'Workshirt', 'kategori_id' => 2, 'satuan_id' => 1, 'supplier_id' => 2, 'harga_beli' => 120000, 'harga_jual_umum' => 150000, 'harga_pelanggan' => 140000, 'stok' => 10, 'created_at' => '2026-05-10 05:45:42', 'updated_at' => '2026-05-10 05:48:01'],
            ['id' => 2, 'gambar' => null, 'kode_barang' => 'LNY-0001', 'nama_item' => 'Lanyard Custom', 'kategori_id' => 1, 'satuan_id' => 1, 'supplier_id' => 1, 'harga_beli' => 10000, 'harga_jual_umum' => 15000, 'harga_pelanggan' => 12000, 'stok' => 25, 'created_at' => '2026-05-10 05:46:38', 'updated_at' => '2026-05-10 05:46:38'],
            ['id' => 3, 'gambar' => null, 'kode_barang' => 'PDH-0001', 'nama_item' => 'PDH', 'kategori_id' => 2, 'satuan_id' => 1, 'supplier_id' => 3, 'harga_beli' => 120000, 'harga_jual_umum' => 160000, 'harga_pelanggan' => 145000, 'stok' => 20, 'created_at' => '2026-05-10 05:47:19', 'updated_at' => '2026-05-10 05:47:19']
        ]);

        DB::table('stoks')->insert([
            // Workshirt Stok
            ['id' => 1, 'produk_id' => 1, 'jenis' => 'Masuk', 'jumlah' => 10, 'nilai' => 1200000, 'tanggal' => '2026-05-10 12:48:01', 'keterangan' => 'Stok Awal', 'created_at' => '2026-05-10 05:48:01', 'updated_at' => '2026-05-10 05:48:01'],
            ['id' => 2, 'produk_id' => 1, 'jenis' => 'Masuk', 'jumlah' => 25, 'nilai' => 3000000, 'tanggal' => '2026-05-10 06:18:43', 'keterangan' => 'Pembelian PO BLP-20260510-0001-PO01', 'created_at' => '2026-05-10 06:18:43', 'updated_at' => '2026-05-10 06:18:43'],
            ['id' => 3, 'produk_id' => 1, 'jenis' => 'Keluar', 'jumlah' => 25, 'nilai' => 3000000, 'tanggal' => '2026-05-10 06:17:26', 'keterangan' => 'Penjualan Invoice BLP-20260510-0001', 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-10 06:17:26'],
            
            // Lanyard Custom Stok
            ['id' => 4, 'produk_id' => 2, 'jenis' => 'Masuk', 'jumlah' => 100, 'nilai' => 1000000, 'tanggal' => '2026-05-10 06:19:12', 'keterangan' => 'Pembelian PO BLP-20260510-0001-PO02', 'created_at' => '2026-05-10 06:19:12', 'updated_at' => '2026-05-10 06:19:12'],
            ['id' => 5, 'produk_id' => 2, 'jenis' => 'Keluar', 'jumlah' => 25, 'nilai' => 250000, 'tanggal' => '2026-05-10 06:17:26', 'keterangan' => 'Penjualan Invoice BLP-20260510-0001', 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-10 06:17:26'],
            ['id' => 6, 'produk_id' => 2, 'jenis' => 'Keluar', 'jumlah' => 50, 'nilai' => 500000, 'tanggal' => '2026-05-19 01:56:48', 'keterangan' => 'Penjualan Invoice BLP-20260519-0001', 'created_at' => '2026-05-19 01:56:48', 'updated_at' => '2026-05-19 01:56:48'],
            
            // PDH Stok
            ['id' => 7, 'produk_id' => 3, 'jenis' => 'Masuk', 'jumlah' => 50, 'nilai' => 6000000, 'tanggal' => '2026-05-10 06:20:00', 'keterangan' => 'Pembelian PO BLP-20260510-0001-PO03', 'created_at' => '2026-05-10 06:20:00', 'updated_at' => '2026-05-10 06:20:00'],
            ['id' => 8, 'produk_id' => 3, 'jenis' => 'Keluar', 'jumlah' => 30, 'nilai' => 3600000, 'tanggal' => '2026-05-18 14:52:51', 'keterangan' => 'Penjualan Invoice BLP-20260518-0001', 'created_at' => '2026-05-18 14:52:51', 'updated_at' => '2026-05-18 14:52:51']
        ]);

        // 5. TRANSAKSI PENJUALAN
        DB::table('penjualans')->insert([
            ['id' => 2, 'invoice' => 'BLP-20260510-0001', 'user_id' => 1, 'customer_id' => 2, 'total_harga' => 3800000, 'bayar' => 3500000, 'kembalian' => -300000, 'status_pembayaran' => 'Kredit', 'judul_desain' => 'Workshirt TPL', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => null, 'gambar_desain' => '1778398641_image_12.png', 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-18 14:51:39'],
            ['id' => 4, 'invoice' => 'BLP-20260518-0001', 'user_id' => 1, 'customer_id' => 2, 'total_harga' => 5149999, 'bayar' => 5149999, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => null, 'nama_desainer' => null, 'keterangan_desain' => null, 'gambar_desain' => null, 'created_at' => '2026-05-18 14:52:51', 'updated_at' => '2026-05-18 14:52:51'],
            ['id' => 5, 'invoice' => 'BLP-20260519-0001', 'user_id' => 1, 'customer_id' => 3, 'total_harga' => 750000, 'bayar' => 750000, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => null, 'nama_desainer' => null, 'keterangan_desain' => null, 'gambar_desain' => null, 'created_at' => '2026-05-19 01:56:48', 'updated_at' => '2026-05-19 01:56:48']
        ]);

        DB::table('penjualan_details')->insert([
            ['id' => 1, 'penjualan_id' => 2, 'produk_id' => 1, 'harga_satuan' => 140000, 'qty' => 25, 'subtotal' => 3500000, 'tahap_produksi' => 'Potong Bahan', 'progress' => 20, 'catatan_produksi' => 'Potong bahan untuk workshirt', 'produksi_updated_by' => 1, 'servis_id' => null, 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-10 06:43:56'],
            ['id' => 2, 'penjualan_id' => 2, 'produk_id' => 2, 'harga_satuan' => 12000, 'qty' => 25, 'subtotal' => 300000, 'tahap_produksi' => 'Belum Diproses', 'progress' => 0, 'catatan_produksi' => null, 'produksi_updated_by' => null, 'servis_id' => null, 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-10 06:17:26'],
            ['id' => 5, 'penjualan_id' => 4, 'produk_id' => 3, 'harga_satuan' => 145000, 'qty' => 30, 'subtotal' => 4350000, 'tahap_produksi' => 'Selesai', 'progress' => 100, 'catatan_produksi' => null, 'produksi_updated_by' => null, 'servis_id' => null, 'created_at' => '2026-05-18 14:52:51', 'updated_at' => '2026-05-18 14:52:51'],
            ['id' => 6, 'penjualan_id' => 4, 'produk_id' => null, 'harga_satuan' => 799999, 'qty' => 1, 'subtotal' => 799999, 'tahap_produksi' => 'Belum Diproses', 'progress' => 0, 'catatan_produksi' => null, 'produksi_updated_by' => null, 'servis_id' => 1, 'created_at' => '2026-05-18 14:52:51', 'updated_at' => '2026-05-18 14:52:51'],
            ['id' => 7, 'penjualan_id' => 5, 'produk_id' => 2, 'harga_satuan' => 15000, 'qty' => 50, 'subtotal' => 750000, 'tahap_produksi' => 'cetak', 'progress' => 100, 'catatan_produksi' => null, 'produksi_updated_by' => 1, 'servis_id' => null, 'created_at' => '2026-05-19 01:56:48', 'updated_at' => '2026-05-19 01:58:51']
        ]);

        // 6. TRANSAKSI PEMBELIAN
        DB::table('pembelians')->insert([
            ['id' => 1, 'faktur' => 'BLP-20260510-0001-PO01', 'tanggal_faktur' => '2026-05-10', 'supplier_id' => 2, 'penjualan_id' => 2, 'user_id' => 1, 'total_harga' => 3000000, 'diskon' => 0, 'grand_total' => 3000000, 'bayar' => 2000000, 'sisa_hutang' => 1000000, 'jatuh_tempo' => '2026-05-31', 'status_pembayaran' => 'Hutang', 'created_at' => '2026-05-10 06:18:43', 'updated_at' => '2026-05-10 06:18:43'],
            ['id' => 2, 'faktur' => 'BLP-20260510-0001-PO02', 'tanggal_faktur' => '2026-05-10', 'supplier_id' => 3, 'penjualan_id' => 2, 'user_id' => 1, 'total_harga' => 1000000, 'diskon' => 0, 'grand_total' => 1000000, 'bayar' => 1000000, 'sisa_hutang' => 0, 'jatuh_tempo' => null, 'status_pembayaran' => 'Lunas', 'created_at' => '2026-05-10 06:19:12', 'updated_at' => '2026-05-10 06:19:12'],
            ['id' => 3, 'faktur' => 'BLP-20260510-0001-PO03', 'tanggal_faktur' => '2026-05-10', 'supplier_id' => 1, 'penjualan_id' => 4, 'user_id' => 1, 'total_harga' => 6000000, 'diskon' => 0, 'grand_total' => 6000000, 'bayar' => 6000000, 'sisa_hutang' => 0, 'jatuh_tempo' => null, 'status_pembayaran' => 'Lunas', 'created_at' => '2026-05-10 06:20:00', 'updated_at' => '2026-05-10 06:20:00']
        ]);

        DB::table('pembelian_details')->insert([
            ['id' => 1, 'pembelian_id' => 1, 'produk_id' => 1, 'harga_beli' => 120000, 'harga_jual' => 150000, 'qty' => 25, 'subtotal' => 3000000, 'created_at' => '2026-05-10 06:18:43', 'updated_at' => '2026-05-10 06:18:43'],
            ['id' => 2, 'pembelian_id' => 2, 'produk_id' => 2, 'harga_beli' => 10000, 'harga_jual' => 15000, 'qty' => 100, 'subtotal' => 1000000, 'created_at' => '2026-05-10 06:19:12', 'updated_at' => '2026-05-10 06:19:12'],
            ['id' => 3, 'pembelian_id' => 3, 'produk_id' => 3, 'harga_beli' => 120000, 'harga_jual' => 160000, 'qty' => 50, 'subtotal' => 6000000, 'created_at' => '2026-05-10 06:20:00', 'updated_at' => '2026-05-10 06:20:00']
        ]);

        DB::table('riwayat_pembayaran_pembelians')->insert([
            ['id' => 1, 'pembelian_id' => 1, 'nominal_bayar' => 2000000, 'tanggal_bayar' => '2026-05-10', 'metode_bayar' => 'Transfer BCA', 'keterangan' => 'Uang Muka Pembelian Workshirt', 'created_at' => '2026-05-10 06:18:43', 'updated_at' => '2026-05-10 06:18:43'],
            ['id' => 2, 'pembelian_id' => 2, 'nominal_bayar' => 1000000, 'tanggal_bayar' => '2026-05-10', 'metode_bayar' => 'Transfer Mandiri', 'keterangan' => 'Pelunasan Lanyard Custom', 'created_at' => '2026-05-10 06:19:12', 'updated_at' => '2026-05-10 06:19:12'],
            ['id' => 3, 'pembelian_id' => 3, 'nominal_bayar' => 6000000, 'tanggal_bayar' => '2026-05-10', 'metode_bayar' => 'Transfer BCA', 'keterangan' => 'Pelunasan PDH', 'created_at' => '2026-05-10 06:20:00', 'updated_at' => '2026-05-10 06:20:00']
        ]);

        DB::table('riwayat_pembayaran_penjualans')->insert([
            ['id' => 1, 'penjualan_id' => 2, 'nominal_bayar' => 3500000, 'tanggal_bayar' => '2026-05-10', 'keterangan' => 'Pembayaran Pertama (Termin 1)', 'created_at' => '2026-05-10 06:17:26', 'updated_at' => '2026-05-10 06:17:26']
        ]);

        // 7. KAS (Hanya mencatat transaksi kas manual/pengeluaran lainnya, bukan data penjualan/pembelian karena itu dihitung dinamis)
        DB::table('kas')->insert([
            ['id' => 1, 'kode_kas' => 'KS-0000001', 'tipe' => 'Masuk', 'jenis' => 'Investasi Modal', 'nominal' => 20000000, 'keterangan' => 'Suntikan modal awal usaha', 'user_id' => 1, 'created_at' => '2026-05-01 08:00:00', 'updated_at' => '2026-05-01 08:00:00'],
            ['id' => 2, 'kode_kas' => 'KS-0000002', 'tipe' => 'Keluar', 'jenis' => 'Listrik & Air', 'nominal' => 500000, 'keterangan' => 'Pengeluaran Lainnya (Lunas)', 'user_id' => 1, 'created_at' => '2026-05-12 10:00:00', 'updated_at' => '2026-05-12 10:00:00'],
            ['id' => 3, 'kode_kas' => 'KS-0000003', 'tipe' => 'Keluar', 'jenis' => 'Sewa Kantor', 'nominal' => 1500000, 'keterangan' => 'Pengeluaran Lainnya (Lunas)', 'user_id' => 1, 'created_at' => '2026-05-15 14:00:00', 'updated_at' => '2026-05-15 14:00:00']
        ]);

        // 8. DATA FRONTEND / KONTEN COMPANY PROFILE
        DB::table('mitras')->insert([
            ['id' => 1, 'nama_mitra' => 'Mudain', 'logo' => 'mitra/DhmtbRRSPK5eh6rsqH3s3Hi1raBhiexUAj3ObRKR.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-05-19 04:31:00', 'updated_at' => '2026-05-19 05:16:40'],
            ['id' => 2, 'nama_mitra' => 'BRI', 'logo' => 'mitra/QKxSRhdrrc4MMLGZqecsjVcMWOeRXw1dITPDZU5m.jpg', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-05-19 05:17:33', 'updated_at' => '2026-05-19 05:17:33'],
            ['id' => 3, 'nama_mitra' => 'X', 'logo' => 'mitra/f4WNwXi13FbWyIySFNZj6daeAZb1UpSbrRWtIHyg.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-05-19 05:17:58', 'updated_at' => '2026-05-19 05:17:58'],
            ['id' => 4, 'nama_mitra' => 'Ideanation', 'logo' => 'mitra/Bri2ablZ5s5OhaP8qxwSNEUajd6aUbrWPBalcm5u.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-05-19 05:18:39', 'updated_at' => '2026-05-19 05:18:39'],
            ['id' => 5, 'nama_mitra' => 'Instagram', 'logo' => 'mitra/bsV03d9LQOlJrHXo5AvszV7qlBBumPL8SE3jtG9r.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-05-19 05:19:04', 'updated_at' => '2026-05-19 05:19:04']
        ]);

        DB::table('konten_produks')->insert([
            ['id' => 1, 'nama_produk' => 'Rompi', 'gambar' => 'konten_produk/QacFBJxrhHi86JUnmqXASzgflrJEQOkYKw693caB.png', 'created_at' => '2026-05-19 04:43:44', 'updated_at' => '2026-05-19 05:38:18'],
            ['id' => 2, 'nama_produk' => 'Topi', 'gambar' => 'konten_produk/Fa7ZEkqA1OiSeJhEuh6qIhYVEg9eEuHpaFimxW8T.png', 'created_at' => '2026-05-19 05:30:15', 'updated_at' => '2026-05-19 05:40:30'],
            ['id' => 3, 'nama_produk' => 'PDH', 'gambar' => 'konten_produk/hPrHrrqUTDgGn2UJgQBgy4IW0Pld1EJhl2IDBb71.png', 'created_at' => '2026-05-19 05:35:35', 'updated_at' => '2026-05-19 05:35:35'],
            ['id' => 4, 'nama_produk' => 'Lanyard', 'gambar' => 'konten_produk/InsstydZpnYwb4gkD7ZCysWUYWjyedrPUo8NDidb.png', 'created_at' => '2026-05-19 05:36:42', 'updated_at' => '2026-05-19 05:36:42'],
            ['id' => 5, 'nama_produk' => 'Jaket', 'gambar' => 'konten_produk/AfoaJomjcm9rVQaPGiFhVrpazDbYj7262PS6FFCt.png', 'created_at' => '2026-05-19 05:37:09', 'updated_at' => '2026-05-19 05:39:52'],
            ['id' => 6, 'nama_produk' => 'Kaos', 'gambar' => 'konten_produk/HIOp59V6z66eMDrBLpWKp0vUe5v2XVbY99PG2Lt6.png', 'created_at' => '2026-05-19 05:37:32', 'updated_at' => '2026-05-19 05:38:37']
        ]);

        DB::table('portofolios')->insert([
            ['id' => 1, 'nama_klien' => 'MakPanen', 'gambar' => 'portofolio/vYIIJH7P2WIOKmb84WF86p0Nf74IbnwJw2AVaWxZ.png', 'status' => 'Publish', 'created_at' => '2026-05-19 04:51:15', 'updated_at' => '2026-05-19 05:25:50'],
            ['id' => 2, 'nama_klien' => 'MakPanen', 'gambar' => 'portofolio/9JD3cjeKFcdHngGa5bokJIypLpLXfmzoeb1kRXOo.png', 'status' => 'Publish', 'created_at' => '2026-05-19 05:26:18', 'updated_at' => '2026-05-19 05:26:18'],
            ['id' => 3, 'nama_klien' => 'Ruang', 'gambar' => 'portofolio/rT9gYvMElz5kIO6GIcgGA87kNYnQV1YMn90wGXti.jpg', 'status' => 'Publish', 'created_at' => '2026-05-19 05:26:45', 'updated_at' => '2026-05-19 05:26:45']
        ]);

        DB::table('testimonis')->insert([
            ['id' => 1, 'foto_profil' => 'testimoni/a4xMbH3E4d7Ol27wktmNnrbboVT86sh4fAO163ZO.jpg', 'nama_customer' => 'Rifaldi', 'jabatan' => 'CEO Valoza Store', 'rating' => 5, 'testimoni' => 'adkshasdf', 'created_at' => '2026-05-19 05:03:50', 'updated_at' => '2026-05-19 05:03:50'],
            ['id' => 2, 'foto_profil' => 'testimoni/pM3ZCkYZYzuEEnx4i3MM0WqHz2npXtIcfghvdRHL.png', 'nama_customer' => 'MakPanen', 'jabatan' => null, 'rating' => 5, 'testimoni' => 'keren banget', 'created_at' => '2026-05-19 05:13:26', 'updated_at' => '2026-05-19 05:13:26']
        ]);

        // Aktifkan kembali Foreign Key Checks
        Schema::enableForeignKeyConstraints();
    }
}