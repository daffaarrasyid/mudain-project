<?php

namespace App\Models;

class DetailPenjualan extends MudainModel
{
    protected $table = 'detail_penjualan';

    protected $primaryKey = 'id_detail_penjualan';

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
