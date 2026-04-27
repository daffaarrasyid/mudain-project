<?php

namespace App\Services;

use App\Models\Pengguna;
use App\Models\PenggunaPeran;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PenggunaService
{
    public function __construct(
        protected AktivitasService $aktivitasService
    ) {
    }

    public function getAllRole(array $filters = []): LengthAwarePaginator
    {
        return Role::query()
            ->withCount('pengguna')
            ->when($filters['search'] ?? null, fn (Builder $query, string $search) => $query->where('nama_role', 'like', '%' . $search . '%'))
            ->orderBy('nama_role')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createRole(array $data, Pengguna $pengguna): Role
    {
        $role = Role::create($data);
        $this->aktivitasService->catatAktivitas('Membuat role', 'role', $role->id_role, $pengguna->id_pengguna, json_encode($role->toArray()));

        return $role;
    }

    public function updateRole(Role $role, array $data, Pengguna $pengguna): Role
    {
        $role->update($data);
        $this->aktivitasService->catatAktivitas('Memperbarui role', 'role', $role->id_role, $pengguna->id_pengguna, json_encode($role->fresh()->toArray()));

        return $role->refresh();
    }

    public function deleteRole(Role $role, Pengguna $pengguna): void
    {
        $this->aktivitasService->catatAktivitas('Menghapus role', 'role', $role->id_role, $pengguna->id_pengguna, json_encode($role->toArray()));
        $role->delete();
    }

    public function getAllPengguna(array $filters = []): LengthAwarePaginator
    {
        return Pengguna::query()
            ->with('role')
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where('nama_user', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_user')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();
    }

    public function createPengguna(array $data, Pengguna $aktor): Pengguna
    {
        return DB::transaction(function () use ($data, $aktor) {
            $pengguna = Pengguna::create($data);

            PenggunaPeran::updateOrCreate(
                ['id_pengguna' => $pengguna->id_pengguna, 'id_role' => $pengguna->id_role],
                ['updated_at' => now()]
            );

            $this->aktivitasService->catatAktivitas('Membuat pengguna', 'pengguna', $pengguna->id_pengguna, $aktor->id_pengguna, json_encode($pengguna->toArray()));

            return $pengguna;
        });
    }

    public function updatePengguna(Pengguna $pengguna, array $data, Pengguna $aktor): Pengguna
    {
        return DB::transaction(function () use ($pengguna, $data, $aktor) {
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $pengguna->update($data);

            if ($pengguna->id_role) {
                PenggunaPeran::updateOrCreate(
                    ['id_pengguna' => $pengguna->id_pengguna, 'id_role' => $pengguna->id_role],
                    ['updated_at' => now()]
                );
            }

            $this->aktivitasService->catatAktivitas('Memperbarui pengguna', 'pengguna', $pengguna->id_pengguna, $aktor->id_pengguna, json_encode($pengguna->fresh()->toArray()));

            return $pengguna->refresh();
        });
    }

    public function deletePengguna(Pengguna $pengguna, Pengguna $aktor): void
    {
        $this->aktivitasService->catatAktivitas('Menghapus pengguna', 'pengguna', $pengguna->id_pengguna, $aktor->id_pengguna, json_encode($pengguna->toArray()));
        $pengguna->delete();
    }

    public function getAktivitas(array $filters = []): LengthAwarePaginator
    {
        return $this->aktivitasService->getLogAktivitas($filters);
    }
}
