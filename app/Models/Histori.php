<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    protected $table = 'historis';
    
    protected $fillable = [
        'user_id',
        'aktivitas',
        'waktu_logout',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'waktu_logout' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
