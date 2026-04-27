<?php

namespace App\Models;

class IzinSumber extends MudainModel
{
    protected $table = 'izin_sumber';

    protected $primaryKey = 'id_izin_sumber';

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function sumber()
    {
        return $this->belongsTo(Sumber::class, 'id_sumber', 'id_sumber');
    }
}
