<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar', 'kode_barang', 'nama_item', 'kategori_id', 
        'satuan_id', 'supplier_id', 'harga_beli', 'harga_jual_umum', 'harga_pelanggan', 'stok'
    ];

    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function satuan() { return $this->belongsTo(Satuan::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function pembelianDetails() { return $this->hasMany(PembelianDetail::class, 'produk_id'); }
}