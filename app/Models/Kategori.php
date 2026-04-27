<?php

namespace App\Models;

class Kategori extends MudainModel
{
    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}
