<?php

namespace App\Models;

class Role extends MudainModel
{
    protected $table = 'role';

    protected $primaryKey = 'id_role';

    protected function casts(): array
    {
        return [
            'hak_akses' => 'array',
        ];
    }

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_role', 'id_role');
    }
}
