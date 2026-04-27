<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role');
            $table->json('hak_akses')->nullable();
            $table->string('deskripsi_role')->nullable();
            $table->timestamps();
        });

        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->foreignId('id_role')->nullable()->constrained(table: 'role', column: 'id_role')->nullOnDelete();
            $table->string('nama_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('satuan', function (Blueprint $table) {
            $table->id('id_satuan');
            $table->string('nama_satuan');
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('pemasok', function (Blueprint $table) {
            $table->id('id_pemasok');
            $table->string('nama_pemasok');
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('pembeli', function (Blueprint $table) {
            $table->id('id_pembeli');
            $table->string('nama_pembeli');
            $table->string('jenis_kelamin')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->string('id_produk', 30)->primary();
            $table->string('nama_produk');
            $table->foreignId('id_kategori')->constrained(table: 'kategori', column: 'id_kategori')->restrictOnDelete();
            $table->foreignId('id_satuan')->constrained(table: 'satuan', column: 'id_satuan')->restrictOnDelete();
            $table->foreignId('id_pemasok')->nullable()->constrained(table: 'pemasok', column: 'id_pemasok')->nullOnDelete();
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('gambar')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('stok', function (Blueprint $table) {
            $table->id('id_stok');
            $table->string('id_produk', 30);
            $table->integer('jumlah_masuk')->default(0);
            $table->integer('jumlah_keluar')->default(0);
            $table->dateTime('tanggal');
            $table->string('keterangan')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->cascadeOnDelete();
            $table->index(['id_produk', 'tanggal']);
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('id_penjualan', 30)->primary();
            $table->foreignId('id_pengguna')->constrained(table: 'pengguna', column: 'id_pengguna')->restrictOnDelete();
            $table->foreignId('id_pembeli')->nullable()->constrained(table: 'pembeli', column: 'id_pembeli')->nullOnDelete();
            $table->dateTime('tanggal');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status_pembayaran')->default('tunai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('tanggal');
        });

        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_penjualan');
            $table->string('id_penjualan', 30);
            $table->string('id_produk', 30);
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk')->restrictOnDelete();
        });

        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id_pembelian', 30)->primary();
            $table->foreignId('id_pemasok')->constrained(table: 'pemasok', column: 'id_pemasok')->restrictOnDelete();
            $table->foreignId('id_pengguna')->constrained(table: 'pengguna', column: 'id_pengguna')->restrictOnDelete();
            $table->dateTime('tanggal');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status_pembayaran')->default('tunai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('tanggal');
        });

        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');
            $table->string('id_pembelian', 30);
            $table->string('id_produk', 30);
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk')->restrictOnDelete();
        });

        Schema::create('hutang', function (Blueprint $table) {
            $table->id('id_hutang');
            $table->string('id_pembelian', 30)->unique();
            $table->decimal('jumlah_hutang', 15, 2);
            $table->decimal('jumlah_terbayar', 15, 2)->default(0);
            $table->string('status')->default('belum_lunas');
            $table->dateTime('tanggal');
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();

            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->cascadeOnDelete();
        });

        Schema::create('piutang', function (Blueprint $table) {
            $table->id('id_piutang');
            $table->string('id_penjualan', 30)->unique();
            $table->decimal('jumlah_piutang', 15, 2);
            $table->decimal('jumlah_terbayar', 15, 2)->default(0);
            $table->string('status')->default('belum_lunas');
            $table->dateTime('tanggal');
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->cascadeOnDelete();
        });

        Schema::create('pembayaran_hutang', function (Blueprint $table) {
            $table->id('id_bayar_hutang');
            $table->foreignId('id_hutang')->constrained(table: 'hutang', column: 'id_hutang')->cascadeOnDelete();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->dateTime('tanggal');
            $table->string('keterangan')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('pembayaran_piutang', function (Blueprint $table) {
            $table->id('id_bayar_piutang');
            $table->foreignId('id_piutang')->constrained(table: 'piutang', column: 'id_piutang')->cascadeOnDelete();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->dateTime('tanggal');
            $table->string('keterangan')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('pengeluaran_lain', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->dateTime('tanggal');
            $table->string('keterangan');
            $table->string('kategori_pengeluaran')->nullable();
            $table->decimal('jumlah_pengeluaran', 15, 2);
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('arus_kas', function (Blueprint $table) {
            $table->id('id_arus_kas');
            $table->dateTime('tanggal');
            $table->string('jenis');
            $table->string('arah')->default('masuk');
            $table->decimal('jumlah', 15, 2);
            $table->string('referensi_tipe')->nullable();
            $table->string('referensi_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->index(['tanggal', 'jenis']);
        });

        Schema::create('laba_rugi', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->date('tanggal');
            $table->decimal('total_penjualan', 15, 2)->default(0);
            $table->decimal('total_pembelian', 15, 2)->default(0);
            $table->decimal('total_pengeluaran', 15, 2)->default(0);
            $table->decimal('laba_rugi', 15, 2)->default(0);
            $table->timestamps();

            $table->unique('tanggal');
        });

        Schema::create('produksi', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->string('id_penjualan', 30)->unique();
            $table->dateTime('tanggal_produksi')->nullable();
            $table->integer('jumlah_produksi')->default(0);
            $table->string('status')->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->cascadeOnDelete();
        });

        Schema::create('desain', function (Blueprint $table) {
            $table->id('id_desain');
            $table->string('id_penjualan', 30)->unique();
            $table->string('nama_desain')->nullable();
            $table->text('deskripsi_desain')->nullable();
            $table->string('status_desain')->default('belum_diisi');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->cascadeOnDelete();
        });

        Schema::create('aktivitas', function (Blueprint $table) {
            $table->id('id_aktivitas');
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->string('aktivitas');
            $table->string('tabel_target')->nullable();
            $table->string('id_referensi')->nullable();
            $table->text('detail')->nullable();
            $table->dateTime('waktu');
        });

        Schema::create('portofolio', function (Blueprint $table) {
            $table->id('id_portofolio');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('mitra', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->string('nama_mitra');
            $table->string('logo')->nullable();
            $table->text('deskripsi')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('produk_profil', function (Blueprint $table) {
            $table->id('id_produk_profil');
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('gambar')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('sumber', function (Blueprint $table) {
            $table->id('id_sumber');
            $table->string('nama_sumber');
            $table->string('kode_sumber')->unique();
            $table->string('deskripsi_sumber')->nullable();
            $table->timestamps();
        });

        Schema::create('izin_sumber', function (Blueprint $table) {
            $table->id('id_izin_sumber');
            $table->foreignId('id_role')->constrained(table: 'role', column: 'id_role')->cascadeOnDelete();
            $table->foreignId('id_sumber')->constrained(table: 'sumber', column: 'id_sumber')->cascadeOnDelete();
            $table->boolean('izin_tambah')->default(false);
            $table->boolean('izin_lihat')->default(true);
            $table->boolean('izin_ubah')->default(false);
            $table->boolean('izin_hapus')->default(false);
            $table->timestamps();

            $table->unique(['id_role', 'id_sumber']);
        });

        Schema::create('pengguna_peran', function (Blueprint $table) {
            $table->id('id_pengguna_peran');
            $table->foreignId('id_pengguna')->constrained(table: 'pengguna', column: 'id_pengguna')->cascadeOnDelete();
            $table->foreignId('id_role')->constrained(table: 'role', column: 'id_role')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('riwayat', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->foreignId('id_pengguna')->nullable()->constrained(table: 'pengguna', column: 'id_pengguna')->nullOnDelete();
            $table->foreignId('id_sumber')->nullable()->constrained(table: 'sumber', column: 'id_sumber')->nullOnDelete();
            $table->string('tabel_target')->nullable();
            $table->string('id_record')->nullable();
            $table->string('jenis_aksi');
            $table->longText('data_lama')->nullable();
            $table->longText('data_baru')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->dateTime('waktu');
        });
    }

    public function down(): void
    {
        foreach ([
            'riwayat',
            'pengguna_peran',
            'izin_sumber',
            'sumber',
            'produk_profil',
            'mitra',
            'portofolio',
            'aktivitas',
            'desain',
            'produksi',
            'laba_rugi',
            'arus_kas',
            'pengeluaran_lain',
            'pembayaran_piutang',
            'pembayaran_hutang',
            'piutang',
            'hutang',
            'detail_pembelian',
            'pembelian',
            'detail_penjualan',
            'penjualan',
            'stok',
            'produk',
            'pembeli',
            'pemasok',
            'satuan',
            'kategori',
            'pengguna',
            'role',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
