<?php

namespace App\Models;

class Stok extends MudainModel
{
    protected $table = 'stok';

    protected $primaryKey = 'id_stok';

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
        ];
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
