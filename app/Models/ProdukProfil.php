<?php

namespace App\Models;

class ProdukProfil extends MudainModel
{
    protected $table = 'produk_profil';

    protected $primaryKey = 'id_produk_profil';

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
