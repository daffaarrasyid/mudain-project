<?php

namespace App\Models;

class Produk extends MudainModel
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $appends = [
        'stok_aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function stok()
    {
        return $this->hasMany(Stok::class, 'id_produk', 'id_produk');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk', 'id_produk');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_produk', 'id_produk');
    }

    public function getStokAktifAttribute(): int
    {
        if ($this->relationLoaded('stok')) {
            return (int) $this->stok->sum('jumlah_masuk') - (int) $this->stok->sum('jumlah_keluar');
        }

        return (int) $this->stok()->sum('jumlah_masuk') - (int) $this->stok()->sum('jumlah_keluar');
    }
}
