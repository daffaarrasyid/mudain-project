<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    // ============================================================
    // MANAJEMEN ROLE
    // ============================================================

    public function role()
    {
        $roles = Role::latest()->get();
        return view('admin.user.role', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama',
        ]);

        Role::create([
            'nama'        => $request->nama_role,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.user.role')->with('success', 'Role berhasil ditambahkan.');
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama,' . $id,
        ]);

        $role->update([
            'nama'        => $request->nama_role,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.user.role')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);

        if (strtolower($role->nama) === 'owner / super admin') {
            return redirect()->route('admin.user.role')->with('error', 'Role Owner/Super Admin tidak bisa dihapus.');
        }

        $role->delete();
        return redirect()->route('admin.user.role')->with('success', 'Role berhasil dihapus.');
    }

    // ============================================================
    // MANAJEMEN PENGGUNA
    // ============================================================

    public function pengguna()
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::orderBy('nama')->get();
        return view('admin.user.pengguna', compact('users', 'roles'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
            'email'    => 'nullable|email|unique:users,email',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        User::create([
            'name'     => $request->nama,
            'username' => $request->username,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
            'email'    => $request->email,
            'telepon'  => $request->telepon,
            'alamat'   => $request->alamat,
            'status'   => 'Aktif',
        ]);

        return redirect()->route('admin.user.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'role_id'  => 'required|exists:roles,id',
            'email'    => 'nullable|email|unique:users,email,' . $id,
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'status'   => 'required|in:Aktif,Nonaktif',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'     => $request->nama,
            'username' => $request->username,
            'role_id'  => $request->role_id,
            'email'    => $request->email,
            'telepon'  => $request->telepon,
            'alamat'   => $request->alamat,
            'status'   => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyPengguna($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus akun yang sedang login
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.user.pengguna')->with('error', 'Tidak bisa menghapus akun yang sedang aktif.');
        }

        $user->delete();
        return redirect()->route('admin.user.pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function histori()
    {
        $query = ActivityLog::with('user')->latest();
        
        // Filter berdasarkan pencarian
        if (request('search')) {
            $q = request('search');
            $query->where(function($q2) use ($q) {
                $q2->where('user_name', 'like', "%$q%")
                   ->orWhere('user_role', 'like', "%$q%")
                   ->orWhere('description', 'like', "%$q%")
                   ->orWhere('module', 'like', "%$q%");
            });
        }

        // Filter berdasarkan action
        if (request('action') && request('action') !== 'all') {
            $query->where('action', request('action'));
        }

        // Filter berdasarkan modul
        if (request('module') && request('module') !== 'all') {
            $query->where('module', request('module'));
        }

        $logs    = $query->paginate(20)->withQueryString();
        $modules = ActivityLog::select('module')->distinct()->whereNotNull('module')->pluck('module');
    
        return view('admin.user.histori', compact('logs', 'modules'));
    }

    public function clearHistori()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.user.histori')->with('success', 'Semua log aktivitas berhasil dihapus.');
    }

    public function exportHistori()
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan pencarian
        if (request('search')) {
            $q = request('search');
            $query->where(function($q2) use ($q) {
                $q2->where('user_name', 'like', "%$q%")
                   ->orWhere('user_role', 'like', "%$q%")
                   ->orWhere('description', 'like', "%$q%")
                   ->orWhere('module', 'like', "%$q%");
            });
        }

        // Filter berdasarkan action
        if (request('action') && request('action') !== 'all') {
            $query->where('action', request('action'));
        }

        // Filter berdasarkan modul
        if (request('module') && request('module') !== 'all') {
            $query->where('module', request('module'));
        }

        $logs = $query->get();

        $pdf = Pdf::loadView('admin.user.pdf-histori', compact('logs'));
        
        ob_clean();
        
        return $pdf->stream('Laporan_Histori_Aktivitas_' . date('Y-m-d') . '.pdf');
    }
}