<?php

namespace App\Models;

class Pemasok extends MudainModel
{
    protected $table = 'pemasok';

    protected $primaryKey = 'id_pemasok';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_pemasok', 'id_pemasok');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_pemasok', 'id_pemasok');
    }
}
