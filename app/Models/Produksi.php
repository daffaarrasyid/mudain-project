<?php

namespace App\Models;

class Produksi extends MudainModel
{
    protected $table = 'produksi';

    protected $primaryKey = 'id_produksi';

    protected function casts(): array
    {
        return [
            'tanggal_produksi' => 'datetime',
        ];
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }
}
