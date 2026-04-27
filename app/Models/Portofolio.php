<?php

namespace App\Models;

class Portofolio extends MudainModel
{
    protected $table = 'portofolio';

    protected $primaryKey = 'id_portofolio';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
