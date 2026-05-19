<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaranPembelian extends Model
{
    use HasFactory;

    // Tabel yang diizinkan untuk diisi datanya
    protected $fillable = [
        'pembelian_id', 
        'nominal_bayar', 
        'tanggal_bayar', 
        'metode_bayar', 
        'keterangan'
    ];

    // Relasi balik ke tabel Pembelian (Satu riwayat milik satu PO)
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}