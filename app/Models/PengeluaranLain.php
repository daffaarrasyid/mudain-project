<?php

namespace App\Models;

class PengeluaranLain extends MudainModel
{
    protected $table = 'pengeluaran_lain';

    protected $primaryKey = 'id_pengeluaran';

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'jumlah_pengeluaran' => 'decimal:2',
        ];
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
