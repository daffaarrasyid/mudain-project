@extends('admin.layouts.app')

@section('content')

<div x-data="{
        modalTambah: false,
        modalEdit: false,
        modalHapus: false,
        editId: null, editNama: '', editUsername: '', editRoleId: '', editStatus: '',
        editEmail: '', editTelepon: '', editAlamat: '',
        hapusId: null, hapusNama: '',
        openEdit(u) {
            this.editId       = u.id;
            this.editNama     = u.nama;
            this.editUsername = u.username;
            this.editRoleId   = u.role_id;
            this.editStatus   = u.status;
            this.editEmail    = u.email;
            this.editTelepon  = u.telepon;
            this.editAlamat   = u.alamat;
            this.modalEdit    = true;
        },
        openHapus(id, nama) { this.hapusId = id; this.hapusNama = nama; this.modalHapus = true; }
     }"
    class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-xmark text-red-500"></i> {{ session('error') }}
    </div>
    @endif
    @if($errors->any())
    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Manajemen Pengguna</h2>
            <button @click="modalTambah = true"
                class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Pengguna
            </button>
        </div>
        <form method="GET" action="{{ route('admin.user.pengguna') }}" class="flex items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / username..."
                    class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00]">
                <button type="submit" class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-100">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100 bg-gray-50">
                    <th class="px-5 py-4">#</th>
                    <th class="px-5 py-4">Nama Lengkap</th>
                    <th class="px-5 py-4">Username</th>
                    <th class="px-5 py-4">Role</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Telepon</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse($users as $i => $user)
                <tr class="border-b border-gray-50 even:bg-gray-50/50 hover:bg-orange-50/40 transition-colors">
                    <td class="px-5 py-4 text-gray-400">{{ $users->firstItem() + $i }}</td>
                    <td class="px-5 py-4 font-medium text-gray-700">{{ $user->name }}</td>
                    <td class="px-5 py-4 text-gray-500">{{ $user->username ?? '-' }}</td>
                    <td class="px-5 py-4">
                        @if($user->role)
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 border border-gray-200 px-2.5 py-1 rounded-md text-xs font-semibold">
                            <i class="fa-solid fa-user-shield text-[#E65C00] text-[9px]"></i>
                            {{ $user->role->nama }}
                        </span>
                        @else
                        <span class="text-gray-400 text-xs italic">Belum diset</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-500">{{ $user->email ?? '-' }}</td>
                    <td class="px-5 py-4 text-gray-500">{{ $user->telepon ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        @if($user->status === 'Aktif')
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-full text-[11px] font-semibold border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-500 px-3 py-1.5 rounded-full text-[11px] font-semibold border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex flex-col gap-1.5 items-center">
                            <button @click="openEdit({
                                id: {{ $user->id }},
                                nama: '{{ addslashes($user->name) }}',
                                username: '{{ addslashes($user->username ?? '') }}',
                                role_id: '{{ $user->role_id }}',
                                status: '{{ $user->status }}',
                                email: '{{ addslashes($user->email ?? '') }}',
                                telepon: '{{ addslashes($user->telepon ?? '') }}',
                                alamat: '{{ addslashes($user->alamat ?? '') }}'
                            })"
                                class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold transition-colors">
                                <i class="fa-solid fa-pen-to-square mr-0.5"></i>Edit
                            </button>
                            <button @click="openHapus({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                class="bg-[#EF4444] hover:bg-red-600 text-white px-4 py-1 rounded w-16 text-[11px] font-semibold transition-colors">
                                <i class="fa-solid fa-trash mr-0.5"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-14 text-center text-gray-400">
                        <i class="fa-solid fa-users text-4xl mb-3 block opacity-30"></i>
                        Belum ada pengguna. Klik "Tambah Pengguna" untuk mulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between mt-5 text-sm text-gray-500 gap-3">
        <div>Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna</div>
        <div>{{ $users->links('vendor.pagination.simple-tailwind') }}</div>
    </div>

    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div x-show="modalTambah" style="display:none;"
        class="fixed inset-0 z-[100] flex items-start justify-center p-4 pt-8 bg-black/50 backdrop-blur-sm overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto my-6"
            @click.away="modalTambah = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Pengguna Baru</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.user.pengguna.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Role / Akses <span class="text-red-500">*</span></label>
                        <select name="role_id" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] appearance-none">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Awal <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="6"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WA</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">{{ old('alamat') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL EDIT ===================== --}}
    <div x-show="modalEdit" style="display:none;"
        class="fixed inset-0 z-[100] flex items-start justify-center p-4 pt-8 bg-black/50 backdrop-blur-sm overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto my-6"
            @click.away="modalEdit = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Akun Pengguna</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Mengedit: <span class="font-semibold text-[#E65C00]" x-text="editNama"></span></p>
                </div>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`{{ url('admin/user/pengguna') }}/${editId}`" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" :value="editNama" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                        <input type="text" name="username" :value="editUsername" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Role / Akses <span class="text-red-500">*</span></label>
                        <select name="role_id" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] appearance-none">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" x-bind:selected="editRoleId == {{ $role->id }}">{{ $role->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Akun <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] appearance-none">
                            <option value="Aktif" x-bind:selected="editStatus === 'Aktif'">Aktif</option>
                            <option value="Nonaktif" x-bind:selected="editStatus === 'Nonaktif'">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" :value="editEmail"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WA</label>
                        <input type="text" name="telepon" :value="editTelepon"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" x-model="editAlamat"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
                    <div class="md:col-span-2 bg-blue-50 border border-blue-100 p-4 rounded-xl">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reset Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                            class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                        <p class="text-xs text-blue-500 mt-1"><i class="fa-solid fa-info-circle mr-1"></i>Isi hanya jika perlu mereset password.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL HAPUS ===================== --}}
    <div x-show="modalHapus" style="display:none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
            @click.away="modalHapus = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Pengguna?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus akun <b class="text-gray-700" x-text="hapusNama"></b>? Pengguna ini tidak akan bisa login ke sistem.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false"
                    class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`{{ url('admin/user/pengguna') }}/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">
                        <i class="fa-solid fa-trash mr-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
