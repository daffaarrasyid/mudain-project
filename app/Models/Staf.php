<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;
    protected $fillable = ['kode_staf', 'nama_staf', 'no_telp', 'servis_id'];

    public function servis() {
        return $this->belongsTo(Servis::class);
    }
}
