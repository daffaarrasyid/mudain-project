<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;
    protected $fillable = ['kode_servis', 'nama_servis', 'harga_dasar'];

    public function stafs() {
        return $this->hasMany(Staf::class);
    }
}
