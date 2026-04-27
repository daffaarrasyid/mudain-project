<?php

namespace App\Models;

class Hutang extends MudainModel
{
    protected $table = 'hutang';

    protected $primaryKey = 'id_hutang';

    protected $appends = [
        'sisa',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_hutang' => 'decimal:2',
            'jumlah_terbayar' => 'decimal:2',
            'tanggal' => 'datetime',
            'jatuh_tempo' => 'date',
        ];
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id_pembelian');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranHutang::class, 'id_hutang', 'id_hutang');
    }

    public function getSisaAttribute(): float
    {
        return max(0, (float) $this->jumlah_hutang - (float) $this->jumlah_terbayar);
    }
}
