<?php

namespace App\Models;

class PenggunaPeran extends MudainModel
{
    protected $table = 'pengguna_peran';

    protected $primaryKey = 'id_pengguna_peran';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
