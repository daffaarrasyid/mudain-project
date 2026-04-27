<?php

namespace App\Models;

class Satuan extends MudainModel
{
    protected $table = 'satuan';

    protected $primaryKey = 'id_satuan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_satuan', 'id_satuan');
    }
}
