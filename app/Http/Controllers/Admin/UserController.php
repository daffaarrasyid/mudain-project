<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Role;
use App\Services\PenggunaService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function role(Request $request, PenggunaService $penggunaService)
    {
        return view('admin.resource.index', [
            'title' => 'Manajemen Role',
            'description' => 'Atur role dan hak akses utama pengguna aplikasi.',
            'items' => $penggunaService->getAllRole([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Role::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama Role', 'key' => 'nama_role'],
                ['label' => 'Deskripsi', 'key' => 'deskripsi_role'],
                ['label' => 'Jumlah Pengguna', 'key' => 'pengguna_count'],
            ],
            'fields' => [
                ['name' => 'nama_role', 'label' => 'Nama Role', 'type' => 'text', 'required' => true],
                ['name' => 'deskripsi_role', 'label' => 'Deskripsi', 'type' => 'text'],
                ['name' => 'hak_akses_text', 'label' => 'Hak Akses', 'type' => 'textarea', 'value_key' => 'hak_akses', 'placeholder' => 'Pisahkan hak akses dengan koma, contoh: dashboard,produk,laporan'],
            ],
            'storeRoute' => 'admin.user.role.store',
            'updateRoute' => 'admin.user.role.update',
            'destroyRoute' => 'admin.user.role.destroy',
            'searchPlaceholder' => 'Cari role',
            'createLabel' => 'Simpan Role',
        ]);
    }

    public function storeRole(Request $request, PenggunaService $penggunaService)
    {
        $data = $request->validate([
            'nama_role' => ['required', 'string', 'max:255'],
            'deskripsi_role' => ['nullable', 'string', 'max:255'],
            'hak_akses_text' => ['nullable', 'string'],
        ]);

        $data['hak_akses'] = collect(explode(',', $data['hak_akses_text'] ?? ''))
            ->map(fn (string $hakAkses) => trim($hakAkses))
            ->filter()
            ->values()
            ->all();
        unset($data['hak_akses_text']);

        $penggunaService->createRole($data, $request->user());

        return redirect()->route('admin.user.role')->with('success', 'Role berhasil ditambahkan.');
    }

    public function updateRole(Request $request, Role $role, PenggunaService $penggunaService)
    {
        $data = $request->validate([
            'nama_role' => ['required', 'string', 'max:255'],
            'deskripsi_role' => ['nullable', 'string', 'max:255'],
            'hak_akses_text' => ['nullable', 'string'],
        ]);

        $data['hak_akses'] = collect(explode(',', $data['hak_akses_text'] ?? ''))
            ->map(fn (string $hakAkses) => trim($hakAkses))
            ->filter()
            ->values()
            ->all();
        unset($data['hak_akses_text']);

        $penggunaService->updateRole($role, $data, $request->user());

        return redirect()->route('admin.user.role')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole(Request $request, Role $role, PenggunaService $penggunaService)
    {
        $penggunaService->deleteRole($role, $request->user());

        return redirect()->route('admin.user.role')->with('success', 'Role berhasil dihapus.');
    }

    public function histori(Request $request, PenggunaService $penggunaService)
    {
        return view('admin.user.histori', [
            'items' => $penggunaService->getAktivitas([
                'id_pengguna' => $request->input('id_pengguna'),
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'per_page' => $request->integer('per_page', 12),
            ]),
            'penggunaOptions' => Pengguna::orderBy('nama_user')->get(),
        ]);
    }

    public function pengguna(Request $request, PenggunaService $penggunaService)
    {
        $roles = Role::orderBy('nama_role')->withCount('pengguna')->get();

        return view('admin.resource.index', [
            'title' => 'Manajemen Pengguna',
            'description' => 'Kelola akun pengguna berdasarkan role yang dimiliki.',
            'items' => $penggunaService->getAllPengguna([
                'search' => $request->string('search')->toString(),
                'per_page' => $request->integer('per_page', 10),
            ]),
            'editItem' => $request->filled('edit') ? Pengguna::findOrFail($request->integer('edit')) : null,
            'columns' => [
                ['label' => 'Nama User', 'key' => 'nama_user'],
                ['label' => 'Username', 'key' => 'username'],
                ['label' => 'Role', 'key' => 'role.nama_role'],
                ['label' => 'Dibuat', 'key' => 'created_at', 'format' => 'datetime'],
            ],
            'fields' => [
                ['name' => 'nama_user', 'label' => 'Nama User', 'type' => 'text', 'required' => true],
                ['name' => 'username', 'label' => 'Username', 'type' => 'text', 'required' => true],
                ['name' => 'id_role', 'label' => 'Role', 'type' => 'select', 'required' => true, 'options' => $roles->pluck('nama_role', 'id_role')->all()],
                ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'placeholder' => 'Isi untuk user baru atau ganti password'],
            ],
            'storeRoute' => 'admin.user.pengguna.store',
            'updateRoute' => 'admin.user.pengguna.update',
            'destroyRoute' => 'admin.user.pengguna.destroy',
            'searchPlaceholder' => 'Cari nama atau username',
            'createLabel' => 'Simpan Pengguna',
        ]);
    }

    public function storePengguna(Request $request, PenggunaService $penggunaService)
    {
        $data = $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:pengguna,username'],
            'id_role' => ['required', 'exists:role,id_role'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $penggunaService->createPengguna($data, $request->user());

        return redirect()->route('admin.user.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updatePengguna(Request $request, Pengguna $pengguna, PenggunaService $penggunaService)
    {
        $data = $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:pengguna,username,' . $pengguna->id_pengguna . ',id_pengguna'],
            'id_role' => ['required', 'exists:role,id_role'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $penggunaService->updatePengguna($pengguna, $data, $request->user());

        return redirect()->route('admin.user.pengguna')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroyPengguna(Request $request, Pengguna $pengguna, PenggunaService $penggunaService)
    {
        if ($request->user()->id_pengguna === $pengguna->id_pengguna) {
            return redirect()->route('admin.user.pengguna')->with('error', 'Akun yang sedang login tidak bisa dihapus.');
        }

        $penggunaService->deletePengguna($pengguna, $request->user());

        return redirect()->route('admin.user.pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}
