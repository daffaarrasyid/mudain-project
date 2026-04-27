<?php

namespace App\Models;

class PembayaranPiutang extends MudainModel
{
    protected $table = 'pembayaran_piutang';

    protected $primaryKey = 'id_bayar_piutang';

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tanggal' => 'datetime',
        ];
    }

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'id_piutang', 'id_piutang');
    }
}
