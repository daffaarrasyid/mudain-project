<?php

namespace App\Models;

class Penjualan extends MudainModel
{
    protected $table = 'penjualan';

    protected $primaryKey = 'id_penjualan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'total' => 'decimal:2',
        ];
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function piutang()
    {
        return $this->hasOne(Piutang::class, 'id_penjualan', 'id_penjualan');
    }

    public function produksi()
    {
        return $this->hasOne(Produksi::class, 'id_penjualan', 'id_penjualan');
    }

    public function desain()
    {
        return $this->hasOne(Desain::class, 'id_penjualan', 'id_penjualan');
    }
}
