<?php

namespace App\Models;

class Pembelian extends MudainModel
{
    protected $table = 'pembelian';

    protected $primaryKey = 'id_pembelian';

    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'total' => 'decimal:2',
        ];
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian', 'id_pembelian');
    }

    public function hutang()
    {
        return $this->hasOne(Hutang::class, 'id_pembelian', 'id_pembelian');
    }
}
