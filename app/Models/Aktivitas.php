<?php

namespace App\Models;

class Aktivitas extends MudainModel
{
    protected $table = 'aktivitas';

    protected $primaryKey = 'id_aktivitas';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
        ];
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
