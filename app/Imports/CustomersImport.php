<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'kode_customer'  => $row['kode_customer'],
            'nama_customer'  => $row['nama_customer'],
            'no_telp'        => $row['no_telp'],
            'email'          => $row['email'] ?? null,
            'alamat'         => $row['alamat'] ?? null,
            'jenis_customer' => $row['jenis_customer'] ?? 'Umum',
        ]);
    }
}