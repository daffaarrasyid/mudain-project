<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relasi ke User (optional, user bisa sudah dihapus).
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Pengguna Dihapus',
        ]);
    }

    /**
     * Helper: catat aktivitas secara statis dari mana saja.
     */
    public static function record(string $action, string $description, string $module = null, $request = null): void
    {
        $user = auth()->user();
        $req  = $request ?? request();

        static::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'System',
            'user_role'   => $user?->role?->nama ?? '-',
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'ip_address'  => $req->ip(),
            'user_agent'  => $req->userAgent(),
        ]);
    }

    /**
     * Label warna berdasarkan action.
     */
    public function getActionColorAttribute(): array
    {
        return match($this->action) {
            'login'  => ['bg' => 'bg-blue-50',   'text' => 'text-blue-600',  'border' => 'border-blue-200',  'icon' => 'fa-right-to-bracket'],
            'logout' => ['bg' => 'bg-slate-50',   'text' => 'text-slate-500', 'border' => 'border-slate-200', 'icon' => 'fa-right-from-bracket'],
            'create' => ['bg' => 'bg-green-50',   'text' => 'text-green-600', 'border' => 'border-green-200', 'icon' => 'fa-plus'],
            'update' => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600', 'border' => 'border-amber-200', 'icon' => 'fa-pen'],
            'delete' => ['bg' => 'bg-red-50',     'text' => 'text-red-600',   'border' => 'border-red-200',   'icon' => 'fa-trash'],
            'export' => ['bg' => 'bg-purple-50',  'text' => 'text-purple-600','border' => 'border-purple-200','icon' => 'fa-file-export'],
            default  => ['bg' => 'bg-gray-50',    'text' => 'text-gray-500',  'border' => 'border-gray-200',  'icon' => 'fa-circle-dot'],
        };
    }

    /**
     * Label teks action dalam Bahasa Indonesia.
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'login'  => 'Login',
            'logout' => 'Logout',
            'create' => 'Tambah Data',
            'update' => 'Ubah Data',
            'delete' => 'Hapus Data',
            'export' => 'Ekspor',
            default  => ucfirst($this->action),
        };
    }
}
