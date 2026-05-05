<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Mengabaikan baris pertama (judul header)

class SuppliersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Menyocokkan nama header Excel dengan kolom database
        return new Supplier([
            'kode_supplier' => $row['kode_supplier'],
            'nama_supplier' => $row['nama_supplier'],
            'no_telp'       => $row['no_telp'],
            'email'         => $row['email'] ?? null,
            'nama_bank'     => $row['nama_bank'] ?? null,
            'no_rekening'   => $row['no_rekening'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
        ]);
    }
}