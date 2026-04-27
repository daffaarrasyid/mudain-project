<?php

namespace App\Models;

class Piutang extends MudainModel
{
    protected $table = 'piutang';

    protected $primaryKey = 'id_piutang';

    protected $appends = [
        'sisa',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_piutang' => 'decimal:2',
            'jumlah_terbayar' => 'decimal:2',
            'tanggal' => 'datetime',
            'jatuh_tempo' => 'date',
        ];
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranPiutang::class, 'id_piutang', 'id_piutang');
    }

    public function getSisaAttribute(): float
    {
        return max(0, (float) $this->jumlah_piutang - (float) $this->jumlah_terbayar);
    }
}
