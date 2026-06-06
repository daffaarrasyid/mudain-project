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
        Schema::disableForeignKeyConstraints();

        $tables = [
            'activity_logs', 'historis', 'riwayat_pembayaran_pembelians', 'riwayat_pembayaran_penjualans',
            'penjualan_details', 'pembelian_details', 'pembelians', 'penjualans', 'stoks', 'produks',
            'stafs', 'kas', 'users', 'roles', 'kategoris', 'satuans', 'servis', 'suppliers',
            'customers', 'mitras', 'konten_produks', 'portofolios', 'testimonis'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        $this->call(RoleSeeder::class);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Taufik', 'username' => 'taufik', 'role_id' => 1, 'email' => 'taufik@example.com', 'telepon' => null, 'alamat' => null, 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Sales Demo', 'username' => 'sales', 'role_id' => 2, 'email' => 'sales@example.com', 'telepon' => '081234567802', 'alamat' => 'Bandung', 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Desainer Demo', 'username' => 'desainer', 'role_id' => 3, 'email' => 'desainer@example.com', 'telepon' => '081234567803', 'alamat' => 'Jakarta', 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Admin Demo', 'username' => 'admin', 'role_id' => 4, 'email' => 'admin@example.com', 'telepon' => '081234567804', 'alamat' => 'Surabaya', 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Finance Demo', 'username' => 'finance', 'role_id' => 5, 'email' => 'finance@example.com', 'telepon' => '081234567805', 'alamat' => 'Medan', 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Purchasing Demo', 'username' => 'purchasing', 'role_id' => 6, 'email' => 'purchasing@example.com', 'telepon' => '081234567806', 'alamat' => 'Semarang', 'status' => 'Aktif', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => null, 'created_at' => now(), 'updated_at' => now()]
        ]);

        DB::table('kategoris')->insert([
            ['id' => 1, 'nama_kategori' => 'Percetakan', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['id' => 2, 'nama_kategori' => 'Konveksi', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        DB::table('satuans')->insert([
            ['id' => 1, 'nama_satuan' => 'Pcs', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['id' => 2, 'nama_satuan' => 'Lusin', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        DB::table('servis')->insert([
            ['id' => 1, 'kode_servis' => 'SRV-001', 'nama_servis' => 'Desain Kustom', 'harga_dasar' => 50000, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['id' => 2, 'kode_servis' => 'SRV-002', 'nama_servis' => 'Sablon Ekspres', 'harga_dasar' => 20000, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        DB::table('suppliers')->insert([
            ['id' => 1, 'kode_supplier' => 'SP-00001', 'nama_supplier' => 'Grosir Kain Textile', 'no_telp' => '08111111', 'email' => 'kain@grosir.com', 'nama_bank' => 'BCA', 'no_rekening' => '1111', 'alamat' => 'Bandung', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['id' => 2, 'kode_supplier' => 'SP-00002', 'nama_supplier' => 'Pabrik Lanyard & ID Card', 'no_telp' => '08222222', 'email' => 'lanyard@pabrik.com', 'nama_bank' => 'Mandiri', 'no_rekening' => '2222', 'alamat' => 'Jakarta', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        DB::table('customers')->insert([
            ['id' => 1, 'kode_customer' => 'CS-000001', 'nama_customer' => 'BEM Kampus', 'no_telp' => '08333333', 'email' => 'bem@kampus.com', 'alamat' => 'Bogor', 'jenis_customer' => 'Pelanggan', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['id' => 2, 'kode_customer' => 'CS-000002', 'nama_customer' => 'Dinas Pendidikan', 'no_telp' => '08444444', 'email' => 'dinas@pendidikan.com', 'alamat' => 'Jakarta', 'jenis_customer' => 'Umum', 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        DB::table('stafs')->insert([
            ['id' => 1, 'kode_staf' => 'STF-001', 'nama_staf' => 'Rifaldi (Desainer)', 'no_telp' => '08999999', 'servis_id' => 1, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00']
        ]);

        // DATA PRODUK (Kalkulasi Stok Akhir per Juni 2026)
        DB::table('produks')->insert([
            ['id' => 1, 'gambar' => null, 'kode_barang' => 'WKS-0001', 'nama_item' => 'Workshirt', 'kategori_id' => 2, 'satuan_id' => 1, 'supplier_id' => 1, 'harga_beli' => 120000, 'harga_jual_umum' => 150000, 'harga_pelanggan' => 140000, 'stok' => 40, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-06-15 10:00:00'],
            ['id' => 2, 'gambar' => null, 'kode_barang' => 'LNY-0001', 'nama_item' => 'Lanyard Custom', 'kategori_id' => 1, 'satuan_id' => 1, 'supplier_id' => 2, 'harga_beli' => 10000, 'harga_jual_umum' => 15000, 'harga_pelanggan' => 12000, 'stok' => 170, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-06-15 10:00:00'],
            ['id' => 3, 'gambar' => null, 'kode_barang' => 'PDH-0001', 'nama_item' => 'PDH', 'kategori_id' => 2, 'satuan_id' => 1, 'supplier_id' => 1, 'harga_beli' => 120000, 'harga_jual_umum' => 160000, 'harga_pelanggan' => 150000, 'stok' => 60, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-06-15 10:00:00']
        ]);

        // ----------------------------------------------------
        // TRANSAKSI PEMBELIAN (KULAKAN)
        // ----------------------------------------------------
        DB::table('pembelians')->insert([
            ['id' => 1, 'faktur' => 'BLP-20260405-0001-PO01', 'tanggal_faktur' => '2026-04-05', 'supplier_id' => 2, 'penjualan_id' => null, 'user_id' => 6, 'total_harga' => 13500000, 'diskon' => 0, 'grand_total' => 13500000, 'bayar' => 13500000, 'sisa_hutang' => 0, 'jatuh_tempo' => null, 'status_pembayaran' => 'Lunas', 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['id' => 2, 'faktur' => 'BLP-20260415-0001-PO02', 'tanggal_faktur' => '2026-04-15', 'supplier_id' => 1, 'penjualan_id' => null, 'user_id' => 6, 'total_harga' => 12000000, 'diskon' => 0, 'grand_total' => 12000000, 'bayar' => 6000000, 'sisa_hutang' => 6000000, 'jatuh_tempo' => '2026-05-25', 'status_pembayaran' => 'Hutang', 'created_at' => '2026-04-15 10:00:00', 'updated_at' => '2026-04-15 10:00:00'],
            ['id' => 3, 'faktur' => 'BLP-20260505-0001-PO03', 'tanggal_faktur' => '2026-05-05', 'supplier_id' => 2, 'penjualan_id' => null, 'user_id' => 6, 'total_harga' => 1000000, 'diskon' => 0, 'grand_total' => 1000000, 'bayar' => 1000000, 'sisa_hutang' => 0, 'jatuh_tempo' => null, 'status_pembayaran' => 'Lunas', 'created_at' => '2026-05-05 09:00:00', 'updated_at' => '2026-05-05 09:00:00'],
            ['id' => 4, 'faktur' => 'BLP-20260605-0001-PO04', 'tanggal_faktur' => '2026-06-05', 'supplier_id' => 1, 'penjualan_id' => null, 'user_id' => 6, 'total_harga' => 12000000, 'diskon' => 0, 'grand_total' => 12000000, 'bayar' => 6000000, 'sisa_hutang' => 6000000, 'jatuh_tempo' => '2026-07-05', 'status_pembayaran' => 'Hutang', 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00']
        ]);

        DB::table('pembelian_details')->insert([
            ['pembelian_id' => 1, 'produk_id' => 2, 'harga_beli' => 10000, 'harga_jual' => 15000, 'qty' => 150, 'subtotal' => 1500000, 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['pembelian_id' => 1, 'produk_id' => 3, 'harga_beli' => 120000, 'harga_jual' => 160000, 'qty' => 100, 'subtotal' => 12000000, 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['pembelian_id' => 2, 'produk_id' => 1, 'harga_beli' => 120000, 'harga_jual' => 150000, 'qty' => 100, 'subtotal' => 12000000, 'created_at' => '2026-04-15 10:00:00', 'updated_at' => '2026-04-15 10:00:00'],
            ['pembelian_id' => 3, 'produk_id' => 2, 'harga_beli' => 10000, 'harga_jual' => 15000, 'qty' => 100, 'subtotal' => 1000000, 'created_at' => '2026-05-05 09:00:00', 'updated_at' => '2026-05-05 09:00:00'],
            ['pembelian_id' => 4, 'produk_id' => 3, 'harga_beli' => 120000, 'harga_jual' => 160000, 'qty' => 50, 'subtotal' => 6000000, 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00'],
            ['pembelian_id' => 4, 'produk_id' => 1, 'harga_beli' => 120000, 'harga_jual' => 150000, 'qty' => 50, 'subtotal' => 6000000, 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00']
        ]);

        DB::table('riwayat_pembayaran_pembelians')->insert([
            ['pembelian_id' => 1, 'nominal_bayar' => 13500000, 'tanggal_bayar' => '2026-04-05', 'metode_bayar' => 'Transfer BCA', 'keterangan' => 'Pelunasan PO 1', 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['pembelian_id' => 2, 'nominal_bayar' => 6000000, 'tanggal_bayar' => '2026-04-15', 'metode_bayar' => 'Transfer Mandiri', 'keterangan' => 'DP Pembelian Workshirt', 'created_at' => '2026-04-15 10:00:00', 'updated_at' => '2026-04-15 10:00:00'],
            ['pembelian_id' => 2, 'nominal_bayar' => 6000000, 'tanggal_bayar' => '2026-05-25', 'metode_bayar' => 'Transfer Mandiri', 'keterangan' => 'Pelunasan Hutang PO 2', 'created_at' => '2026-05-25 10:00:00', 'updated_at' => '2026-05-25 10:00:00'],
            ['pembelian_id' => 3, 'nominal_bayar' => 1000000, 'tanggal_bayar' => '2026-05-05', 'metode_bayar' => 'Cash', 'keterangan' => 'Pelunasan Lanyard', 'created_at' => '2026-05-05 09:00:00', 'updated_at' => '2026-05-05 09:00:00'],
            ['pembelian_id' => 4, 'nominal_bayar' => 6000000, 'tanggal_bayar' => '2026-06-05', 'metode_bayar' => 'Transfer BCA', 'keterangan' => 'DP PO 4', 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00']
        ]);

        // ----------------------------------------------------
        // TRANSAKSI PENJUALAN (BARANG KELUAR)
        // ----------------------------------------------------
        DB::table('penjualans')->insert([
            ['id' => 1, 'invoice' => 'BLP-20260410-0001', 'user_id' => 2, 'customer_id' => 2, 'total_harga' => 3650000, 'bayar' => 3650000, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => 'Desain April', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => 'Warna Biru', 'gambar_desain' => null, 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-10 14:00:00'],
            ['id' => 2, 'invoice' => 'BLP-20260420-0002', 'user_id' => 2, 'customer_id' => 1, 'total_harga' => 6000000, 'bayar' => 6000000, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => 'Workshirt BEM', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => 'Size M L XL', 'gambar_desain' => null, 'created_at' => '2026-04-20 10:00:00', 'updated_at' => '2026-04-20 10:00:00'],
            ['id' => 3, 'invoice' => 'BLP-20260510-0003', 'user_id' => 2, 'customer_id' => 2, 'total_harga' => 4800000, 'bayar' => 2500000, 'kembalian' => -2300000, 'status_pembayaran' => 'Kredit', 'judul_desain' => 'Order Mei', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => null, 'gambar_desain' => null, 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-10 11:00:00'],
            ['id' => 4, 'invoice' => 'BLP-20260515-0004', 'user_id' => 2, 'customer_id' => 1, 'total_harga' => 4500000, 'bayar' => 4500000, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => 'PDH Mei', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => null, 'gambar_desain' => null, 'created_at' => '2026-05-15 13:00:00', 'updated_at' => '2026-05-15 13:00:00'],
            ['id' => 5, 'invoice' => 'BLP-20260610-0005', 'user_id' => 2, 'customer_id' => 2, 'total_harga' => 12400000, 'bayar' => 12400000, 'kembalian' => 0, 'status_pembayaran' => 'Lunas', 'judul_desain' => 'Order Besar Juni', 'nama_desainer' => 'Rifaldi', 'keterangan_desain' => null, 'gambar_desain' => null, 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00']
        ]);

        DB::table('penjualan_details')->insert([
            ['penjualan_id' => 1, 'produk_id' => 2, 'harga_satuan' => 15000, 'qty' => 30, 'subtotal' => 450000, 'tahap_produksi' => 'Selesai', 'progress' => 100, 'catatan_produksi' => 'Selesai', 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-12 10:00:00'],
            ['penjualan_id' => 1, 'produk_id' => 3, 'harga_satuan' => 160000, 'qty' => 20, 'subtotal' => 3200000, 'tahap_produksi' => 'Selesai', 'progress' => 100, 'catatan_produksi' => 'Selesai', 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-11 09:00:00'],
            ['penjualan_id' => 2, 'produk_id' => 1, 'harga_satuan' => 150000, 'qty' => 40, 'subtotal' => 6000000, 'tahap_produksi' => 'Selesai', 'progress' => 100, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-04-20 10:00:00', 'updated_at' => '2026-04-25 11:00:00'],
            ['penjualan_id' => 3, 'produk_id' => 1, 'harga_satuan' => 140000, 'qty' => 30, 'subtotal' => 4200000, 'tahap_produksi' => 'Jahit', 'progress' => 50, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-12 11:00:00'],
            ['penjualan_id' => 3, 'produk_id' => 2, 'harga_satuan' => 12000, 'qty' => 50, 'subtotal' => 600000, 'tahap_produksi' => 'Cetak', 'progress' => 80, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-12 11:00:00'],
            ['penjualan_id' => 4, 'produk_id' => 3, 'harga_satuan' => 150000, 'qty' => 30, 'subtotal' => 4500000, 'tahap_produksi' => 'Selesai', 'progress' => 100, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-05-15 13:00:00', 'updated_at' => '2026-05-18 13:00:00'],
            ['penjualan_id' => 5, 'produk_id' => 3, 'harga_satuan' => 160000, 'qty' => 40, 'subtotal' => 6400000, 'tahap_produksi' => 'Potong Bahan', 'progress' => 20, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00'],
            ['penjualan_id' => 5, 'produk_id' => 1, 'harga_satuan' => 150000, 'qty' => 40, 'subtotal' => 6000000, 'tahap_produksi' => 'Potong Bahan', 'progress' => 20, 'catatan_produksi' => null, 'produksi_updated_by' => 3, 'servis_id' => null, 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00']
        ]);

        DB::table('riwayat_pembayaran_penjualans')->insert([
            ['penjualan_id' => 1, 'nominal_bayar' => 3650000, 'tanggal_bayar' => '2026-04-10', 'keterangan' => 'Pelunasan INV-01', 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-10 14:00:00'],
            ['penjualan_id' => 2, 'nominal_bayar' => 6000000, 'tanggal_bayar' => '2026-04-20', 'keterangan' => 'Pelunasan INV-02', 'created_at' => '2026-04-20 10:00:00', 'updated_at' => '2026-04-20 10:00:00'],
            ['penjualan_id' => 3, 'nominal_bayar' => 2500000, 'tanggal_bayar' => '2026-05-10', 'keterangan' => 'DP INV-03', 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-10 11:00:00'],
            ['penjualan_id' => 3, 'nominal_bayar' => 2300000, 'tanggal_bayar' => '2026-06-02', 'keterangan' => 'Pelunasan Piutang INV-03', 'created_at' => '2026-06-02 11:00:00', 'updated_at' => '2026-06-02 11:00:00'],
            ['penjualan_id' => 4, 'nominal_bayar' => 4500000, 'tanggal_bayar' => '2026-05-15', 'keterangan' => 'Pelunasan INV-04', 'created_at' => '2026-05-15 13:00:00', 'updated_at' => '2026-05-15 13:00:00'],
            ['penjualan_id' => 5, 'nominal_bayar' => 12400000, 'tanggal_bayar' => '2026-06-10', 'keterangan' => 'Pelunasan INV-05', 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00']
        ]);

        // ----------------------------------------------------
        // LOG STOK (ARUS KELUAR MASUK BARANG)
        // ----------------------------------------------------
        DB::table('stoks')->insert([
            ['produk_id' => 2, 'jenis' => 'Masuk', 'jumlah' => 150, 'nilai' => 1500000, 'tanggal' => '2026-04-05 09:00:00', 'keterangan' => 'Pembelian BLP-20260405-0001-PO01', 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['produk_id' => 3, 'jenis' => 'Masuk', 'jumlah' => 100, 'nilai' => 12000000, 'tanggal' => '2026-04-05 09:00:00', 'keterangan' => 'Pembelian BLP-20260405-0001-PO01', 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['produk_id' => 2, 'jenis' => 'Keluar', 'jumlah' => 30, 'nilai' => 450000, 'tanggal' => '2026-04-10 14:00:00', 'keterangan' => 'Penjualan BLP-20260410-0001', 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-10 14:00:00'],
            ['produk_id' => 3, 'jenis' => 'Keluar', 'jumlah' => 20, 'nilai' => 3200000, 'tanggal' => '2026-04-10 14:00:00', 'keterangan' => 'Penjualan BLP-20260410-0001', 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-10 14:00:00'],
            ['produk_id' => 1, 'jenis' => 'Masuk', 'jumlah' => 100, 'nilai' => 12000000, 'tanggal' => '2026-04-15 10:00:00', 'keterangan' => 'Pembelian BLP-20260415-0001-PO02', 'created_at' => '2026-04-15 10:00:00', 'updated_at' => '2026-04-15 10:00:00'],
            ['produk_id' => 1, 'jenis' => 'Keluar', 'jumlah' => 40, 'nilai' => 6000000, 'tanggal' => '2026-04-20 10:00:00', 'keterangan' => 'Penjualan BLP-20260420-0002', 'created_at' => '2026-04-20 10:00:00', 'updated_at' => '2026-04-20 10:00:00'],
            ['produk_id' => 2, 'jenis' => 'Masuk', 'jumlah' => 100, 'nilai' => 1000000, 'tanggal' => '2026-05-05 09:00:00', 'keterangan' => 'Pembelian BLP-20260505-0001-PO03', 'created_at' => '2026-05-05 09:00:00', 'updated_at' => '2026-05-05 09:00:00'],
            ['produk_id' => 1, 'jenis' => 'Keluar', 'jumlah' => 30, 'nilai' => 4200000, 'tanggal' => '2026-05-10 11:00:00', 'keterangan' => 'Penjualan BLP-20260510-0003', 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-10 11:00:00'],
            ['produk_id' => 2, 'jenis' => 'Keluar', 'jumlah' => 50, 'nilai' => 600000, 'tanggal' => '2026-05-10 11:00:00', 'keterangan' => 'Penjualan BLP-20260510-0003', 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-10 11:00:00'],
            ['produk_id' => 3, 'jenis' => 'Keluar', 'jumlah' => 30, 'nilai' => 4500000, 'tanggal' => '2026-05-15 13:00:00', 'keterangan' => 'Penjualan BLP-20260515-0004', 'created_at' => '2026-05-15 13:00:00', 'updated_at' => '2026-05-15 13:00:00'],
            ['produk_id' => 3, 'jenis' => 'Masuk', 'jumlah' => 50, 'nilai' => 6000000, 'tanggal' => '2026-06-05 10:00:00', 'keterangan' => 'Pembelian BLP-20260605-0001-PO04', 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00'],
            ['produk_id' => 1, 'jenis' => 'Masuk', 'jumlah' => 50, 'nilai' => 6000000, 'tanggal' => '2026-06-05 10:00:00', 'keterangan' => 'Pembelian BLP-20260605-0001-PO04', 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00'],
            ['produk_id' => 3, 'jenis' => 'Keluar', 'jumlah' => 40, 'nilai' => 6400000, 'tanggal' => '2026-06-10 15:00:00', 'keterangan' => 'Penjualan BLP-20260610-0005', 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00'],
            ['produk_id' => 1, 'jenis' => 'Keluar', 'jumlah' => 40, 'nilai' => 6000000, 'tanggal' => '2026-06-10 15:00:00', 'keterangan' => 'Penjualan BLP-20260610-0005', 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00']
        ]);

        // ----------------------------------------------------
        // LOG KAS (ARUS UANG MASUK KELUAR 3 BULAN)
        // ----------------------------------------------------
        DB::table('kas')->insert([
            ['kode_kas' => 'KS-0000001', 'tipe' => 'Masuk', 'jenis' => 'Lainnya', 'nominal' => 100000000, 'keterangan' => 'Modal Awal April', 'user_id' => 1, 'created_at' => '2026-04-01 08:00:00', 'updated_at' => '2026-04-01 08:00:00'],
            ['kode_kas' => 'KS-0000002', 'tipe' => 'Keluar', 'jenis' => 'Pembelian', 'nominal' => 13500000, 'keterangan' => 'Pelunasan PO 1', 'user_id' => 6, 'created_at' => '2026-04-05 09:00:00', 'updated_at' => '2026-04-05 09:00:00'],
            ['kode_kas' => 'KS-0000003', 'tipe' => 'Masuk', 'jenis' => 'Penjualan', 'nominal' => 3650000, 'keterangan' => 'Pelunasan INV-01', 'user_id' => 2, 'created_at' => '2026-04-10 14:00:00', 'updated_at' => '2026-04-10 14:00:00'],
            ['kode_kas' => 'KS-0000004', 'tipe' => 'Keluar', 'jenis' => 'Pembelian', 'nominal' => 6000000, 'keterangan' => 'DP PO 2', 'user_id' => 6, 'created_at' => '2026-04-15 10:00:00', 'updated_at' => '2026-04-15 10:00:00'],
            ['kode_kas' => 'KS-0000005', 'tipe' => 'Masuk', 'jenis' => 'Penjualan', 'nominal' => 6000000, 'keterangan' => 'Pelunasan INV-02', 'user_id' => 2, 'created_at' => '2026-04-20 10:00:00', 'updated_at' => '2026-04-20 10:00:00'],
            ['kode_kas' => 'KS-0000006', 'tipe' => 'Keluar', 'jenis' => 'Lainnya', 'nominal' => 1500000, 'keterangan' => 'Operasional Listrik/Sewa April', 'user_id' => 5, 'created_at' => '2026-04-25 10:00:00', 'updated_at' => '2026-04-25 10:00:00'],
            
            ['kode_kas' => 'KS-0000007', 'tipe' => 'Keluar', 'jenis' => 'Pembelian', 'nominal' => 1000000, 'keterangan' => 'Pelunasan PO 3', 'user_id' => 6, 'created_at' => '2026-05-05 09:00:00', 'updated_at' => '2026-05-05 09:00:00'],
            ['kode_kas' => 'KS-0000008', 'tipe' => 'Masuk', 'jenis' => 'Penjualan', 'nominal' => 2500000, 'keterangan' => 'DP INV-03', 'user_id' => 2, 'created_at' => '2026-05-10 11:00:00', 'updated_at' => '2026-05-10 11:00:00'],
            ['kode_kas' => 'KS-0000009', 'tipe' => 'Masuk', 'jenis' => 'Penjualan', 'nominal' => 4500000, 'keterangan' => 'Pelunasan INV-04', 'user_id' => 2, 'created_at' => '2026-05-15 13:00:00', 'updated_at' => '2026-05-15 13:00:00'],
            ['kode_kas' => 'KS-0000010', 'tipe' => 'Keluar', 'jenis' => 'Lainnya', 'nominal' => 1500000, 'keterangan' => 'Operasional Listrik/Sewa Mei', 'user_id' => 5, 'created_at' => '2026-05-20 10:00:00', 'updated_at' => '2026-05-20 10:00:00'],
            ['kode_kas' => 'KS-0000011', 'tipe' => 'Keluar', 'jenis' => 'Pembayaran Hutang', 'nominal' => 6000000, 'keterangan' => 'Bayar Lunas Hutang PO 2', 'user_id' => 5, 'created_at' => '2026-05-25 10:00:00', 'updated_at' => '2026-05-25 10:00:00'],
            
            ['kode_kas' => 'KS-0000012', 'tipe' => 'Masuk', 'jenis' => 'Pembayaran Piutang', 'nominal' => 2300000, 'keterangan' => 'Lunas Piutang INV-03', 'user_id' => 5, 'created_at' => '2026-06-02 11:00:00', 'updated_at' => '2026-06-02 11:00:00'],
            ['kode_kas' => 'KS-0000013', 'tipe' => 'Keluar', 'jenis' => 'Pembelian', 'nominal' => 6000000, 'keterangan' => 'DP PO 4', 'user_id' => 6, 'created_at' => '2026-06-05 10:00:00', 'updated_at' => '2026-06-05 10:00:00'],
            ['kode_kas' => 'KS-0000014', 'tipe' => 'Masuk', 'jenis' => 'Penjualan', 'nominal' => 12400000, 'keterangan' => 'Pelunasan INV-05', 'user_id' => 2, 'created_at' => '2026-06-10 15:00:00', 'updated_at' => '2026-06-10 15:00:00'],
            ['kode_kas' => 'KS-0000015', 'tipe' => 'Keluar', 'jenis' => 'Lainnya', 'nominal' => 1500000, 'keterangan' => 'Operasional Listrik/Sewa Juni', 'user_id' => 5, 'created_at' => '2026-06-20 10:00:00', 'updated_at' => '2026-06-20 10:00:00']
        ]);

        // 10. CMS DATA
        DB::table('mitras')->insert([
            ['id' => 1, 'nama_mitra' => 'Mudain', 'logo' => 'mitra/DhmtbRRSPK5eh6rsqH3s3Hi1raBhiexUAj3ObRKR.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-04-19 04:31:00', 'updated_at' => '2026-04-19 05:16:40'],
            ['id' => 2, 'nama_mitra' => 'BRI', 'logo' => 'mitra/QKxSRhdrrc4MMLGZqecsjVcMWOeRXw1dITPDZU5m.jpg', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-04-19 05:17:33', 'updated_at' => '2026-04-19 05:17:33'],
            ['id' => 3, 'nama_mitra' => 'Ideanation', 'logo' => 'mitra/Bri2ablZ5s5OhaP8qxwSNEUajd6aUbrWPBalcm5u.png', 'url' => null, 'status' => 'Publish', 'created_at' => '2026-04-19 05:18:39', 'updated_at' => '2026-04-19 05:18:39']
        ]);

        DB::table('portofolios')->insert([
            ['id' => 1, 'nama_klien' => 'MakPanen', 'gambar' => 'portofolio/vYIIJH7P2WIOKmb84WF86p0Nf74IbnwJw2AVaWxZ.png', 'status' => 'Publish', 'created_at' => '2026-04-19 04:51:15', 'updated_at' => '2026-04-19 05:25:50']
        ]);

        DB::table('testimonis')->insert([
            ['id' => 1, 'foto_profil' => 'testimoni/a4xMbH3E4d7Ol27wktmNnrbboVT86sh4fAO163ZO.jpg', 'nama_customer' => 'Rifaldi', 'jabatan' => 'CEO Valoza Store', 'rating' => 5, 'testimoni' => 'Produk keren banget!', 'created_at' => '2026-04-19 05:03:50', 'updated_at' => '2026-04-19 05:03:50']
        ]);

        Schema::enableForeignKeyConstraints();
    }
}