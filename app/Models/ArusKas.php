<?php

namespace App\Models;

class ArusKas extends MudainModel
{
    protected $table = 'arus_kas';

    protected $primaryKey = 'id_arus_kas';

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'jumlah' => 'decimal:2',
        ];
    }
}
