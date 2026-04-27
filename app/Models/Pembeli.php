<?php

namespace App\Models;

class Pembeli extends MudainModel
{
    protected $table = 'pembeli';

    protected $primaryKey = 'id_pembeli';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pembeli', 'id_pembeli');
    }
}
