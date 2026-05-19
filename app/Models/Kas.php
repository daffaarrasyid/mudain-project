<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';
    protected $guarded = []; // Izinkan semua kolom diisi

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}