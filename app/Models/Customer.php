<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // WAJIB ADA INI BIAR BISA DI-STORE:
    protected $fillable = [
        'kode_customer', 
        'nama_customer', 
        'no_telp', 
        'email', 
        'alamat', 
        'jenis_customer'
    ];
}