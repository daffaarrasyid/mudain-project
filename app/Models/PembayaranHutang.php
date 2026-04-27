<?php

namespace App\Models;

class PembayaranHutang extends MudainModel
{
    protected $table = 'pembayaran_hutang';

    protected $primaryKey = 'id_bayar_hutang';

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tanggal' => 'datetime',
        ];
    }

    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'id_hutang', 'id_hutang');
    }
}
