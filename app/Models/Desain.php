<?php

namespace App\Models;

class Desain extends MudainModel
{
    protected $table = 'desain';

    protected $primaryKey = 'id_desain';

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }
}
