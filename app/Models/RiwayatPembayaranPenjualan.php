<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaranPenjualan extends Model
{
    protected $fillable = ['penjualan_id', 'nominal_bayar', 'tanggal_bayar', 'keterangan'];

    public function penjualan() {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}
