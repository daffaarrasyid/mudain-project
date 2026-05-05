<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi massal lewat form
    protected $fillable = ['nama_kategori'];
}