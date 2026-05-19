<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = ['faktur', 'tanggal_faktur', 'supplier_id', 'penjualan_id', 'user_id', 'total_harga', 'diskon', 'grand_total', 'bayar', 'sisa_hutang', 'jatuh_tempo', 'status_pembayaran'];

    // 1. Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // FUNGSI RELASI KE USER (Ini yang bikin error tadi)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 2. Relasi ke Penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    // 3. Relasi ke Detail Pembelian (Barang-barangnya)
    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }

    // Tambahkan fungsi ini di dalam class Pembelian
    public function riwayat_pembayarans()
    {
        return $this->hasMany(RiwayatPembayaranPembelian::class, 'pembelian_id');
    }
}
