<?php

namespace App\Models;

class Mitra extends MudainModel
{
    protected $table = 'mitra';

    protected $primaryKey = 'id_mitra';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
