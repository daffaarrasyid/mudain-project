<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id', 'produk_id', 'harga_beli', 'harga_jual', 'qty', 'subtotal'
    ];

    // Relasi ke tabel Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}