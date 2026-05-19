<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi ke User (Operator Produksi)
    public function operator()
    {
        return $this->belongsTo(User::class, 'produksi_updated_by');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    // --- INI SOLUSINYA ---
    // Relasi ke Produk (Barang yang dibeli)
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function servis() 
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

}
