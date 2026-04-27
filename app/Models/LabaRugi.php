<?php

namespace App\Models;

class LabaRugi extends MudainModel
{
    protected $table = 'laba_rugi';

    protected $primaryKey = 'id_laporan';

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total_penjualan' => 'decimal:2',
            'total_pembelian' => 'decimal:2',
            'total_pengeluaran' => 'decimal:2',
            'laba_rugi' => 'decimal:2',
        ];
    }
}
