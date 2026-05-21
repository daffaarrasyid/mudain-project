<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'telepon',
        'alamat',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Check if the user has a specific permission.
     * Returns true for wildcard '*' (super admin).
     */
    public function hasPermission(string $permission): bool
    {
        $perms = $this->role?->permissions ?? [];
        if (in_array('*', $perms)) {
            return true;
        }
        return in_array($permission, $perms);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
