<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class MudainModel extends Model
{
    use HasFactory;

    protected $guarded = [];
}
