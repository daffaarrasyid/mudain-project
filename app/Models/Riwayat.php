<?php

namespace App\Models;

class Riwayat extends MudainModel
{
    protected $table = 'riwayat';

    protected $primaryKey = 'id_riwayat';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
        ];
    }
}
