<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari ID Kategori & Satuan berdasarkan namanya dari Excel
        $kategori = Kategori::where('nama_kategori', $row['kategori'])->first();
        $satuan = Satuan::where('nama_satuan', $row['satuan'])->first();

        return new Produk([
            'kode_barang' => $row['kode_barang'],
            'nama_item'   => $row['nama_item'],
            'kategori_id' => $kategori ? $kategori->id : null,
            'satuan_id'   => $satuan ? $satuan->id : null,
            'harga_beli'  => $row['harga_beli'],
            'harga_jual'  => $row['harga_jual'],
            'stok'        => $row['stok'] ?? 0,
        ]);
    }
}