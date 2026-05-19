<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['invoice', 'user_id', 'customer_id', 'total_harga', 'bayar', 'kembalian', 'status_pembayaran', 'judul_desain', 'nama_desainer', 'keterangan_desain', 'gambar_desain'];
    protected $appends = ['average_progress'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Detail Penjualan (Satu penjualan punya banyak item)
    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function riwayat_pembayarans() {
        return $this->hasMany(RiwayatPembayaranPenjualan::class, 'penjualan_id');
    }

    // Hitung otomatis rata-rata progress produksi dari semua item di invoice ini
    public function getAverageProgressAttribute()
    {
        // Pastikan relasi details sudah ter-load
        if ($this->details->isEmpty()) {
            return 0;
        }
        
        // Ambil rata-rata kolom progress dari tabel penjualan_details
        return round($this->details->avg('progress'));
    }
}
