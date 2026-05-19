@extends('admin.layouts.app')

@section('content')

@php
$modules = [
    'Master Data' => ['Data Produk', 'Data Supplier', 'Data Kategori', 'Data Satuan'],
    'Transaksi'   => ['Entry Penjualan', 'Daftar Penjualan', 'Entry Pembelian', 'Daftar Pembelian', 'Hutang', 'Piutang'],
    'Produksi'    => ['Update Produksi', 'Update Desain', 'Daftar Produksi'],
    'Keuangan'    => ['Kas', 'Laba Rugi'],
    'Konten'      => ['Mitra', 'Produk (Konten)', 'Portofolio', 'Testimoni'],
    'Laporan'     => ['Laporan Penjualan', 'Laporan Pembelian', 'Laporan Keuangan', 'Laporan Produksi'],
];
@endphp

<div x-data="{
        modalTambah: false,
        modalEdit: false,
        modalHapus: false,
        editId: null,
        editNama: '',
        editPerms: [],
        hapusId: null,
        hapusNama: '',
        openEdit(id, nama, perms) {
            this.editId   = id;
            this.editNama = nama;
            this.editPerms = perms;
            this.modalEdit = true;
        },
        openHapus(id, nama) {
            this.hapusId   = id;
            this.hapusNama = nama;
            this.modalHapus = true;
        },
        hasPermission(perm) {
            return this.editPerms.includes('*') || this.editPerms.includes(perm);
        },
        toggleAll(checked) {
            document.querySelectorAll('.perm-edit-cb').forEach(cb => cb.checked = checked);
        }
     }"
    class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

    {{-- Flash Messages --}}
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

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Manajemen Role</h2>
            <button @click="modalTambah = true"
                class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Role
            </button>
        </div>
        <div class="relative w-full sm:w-64">
            <input type="text" placeholder="Cari role..."
                class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00]">
            <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl">
                <i class="fa-solid fa-search"></i>
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-100">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 w-10">#</th>
                    <th class="px-6 py-4">Nama Role</th>
                    <th class="px-6 py-4">Izin Akses Modul</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse ($roles as $i => $role)
                <tr class="border-b border-gray-50 even:bg-gray-50/50 hover:bg-orange-50/40 transition-colors align-top">
                    <td class="px-6 py-4 text-gray-400 font-medium">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 border border-gray-200 px-3 py-1.5 rounded-md font-semibold text-xs">
                            <i class="fa-solid fa-user-shield text-[#E65C00] text-[10px]"></i>
                            {{ $role->nama }}
                        </span>
                        @if(strtolower($role->nama) === 'owner / super admin')
                        <div class="mt-1">
                            <span class="text-[10px] text-amber-500 font-semibold"><i class="fa-solid fa-lock"></i> Protected</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-normal max-w-xs">
                        @if(in_array('*', $role->permissions ?? []))
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-md border border-amber-200">
                                <i class="fa-solid fa-star text-[10px]"></i> Semua Modul (Full Access)
                            </span>
                        @else
                            <div class="flex flex-col gap-1">
                                @foreach(($role->permissions ?? []) as $perm)
                                    @php
                                        [$mod, $sub] = array_pad(explode('_', $perm, 2), 2, '');
                                    @endphp
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                        <i class="fa-solid fa-check text-green-500 text-[10px]"></i>
                                        <span class="font-medium text-gray-500">{{ $mod }}</span>
                                        @if($sub) → {{ $sub }} @endif
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center">
                            <button @click="openEdit({{ $role->id }}, '{{ addslashes($role->nama) }}', {{ json_encode($role->permissions ?? []) }})"
                                class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1 rounded w-20 text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
                            </button>
                            @if(strtolower($role->nama) !== 'owner / super admin')
                            <button @click="openHapus({{ $role->id }}, '{{ addslashes($role->nama) }}')"
                                class="bg-[#EF4444] hover:bg-red-600 text-white px-4 py-1 rounded w-20 text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-trash mr-1"></i>Hapus
                            </button>
                            @else
                            <span class="text-[10px] text-gray-400 italic">Terlindungi</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-shield-halved text-4xl mb-3 block opacity-30"></i>
                        Belum ada role. Klik "Tambah Role" untuk mulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-sm text-gray-400">Total {{ $roles->count() }} role terdaftar</div>

    {{-- ============================================================ --}}
    {{-- MODAL TAMBAH ROLE --}}
    {{-- ============================================================ --}}
    <div x-show="modalTambah" style="display: none;"
        class="fixed inset-0 z-[100] flex items-start justify-center p-4 pt-8 bg-black/50 backdrop-blur-sm overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto my-6"
            @click.away="modalTambah = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Role Baru</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Tentukan nama role dan centang izin akses modul secara spesifik</p>
                </div>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors ml-4 mt-1">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.user.role.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_role" placeholder="Contoh: Sales, Finance, Purchasing..." required
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fa-solid fa-shield-halved text-[#E65C00] mr-1"></i> Izin Akses Modul
                    </label>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 max-h-72 overflow-y-auto space-y-4 custom-scrollbar">
                        @foreach($modules as $modul => $submoduls)
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2 border-b border-gray-200 pb-1">
                                {{ $modul }}
                            </p>
                            <div class="space-y-1 pl-2">
                                @foreach($submoduls as $sub)
                                <label class="flex items-center gap-2.5 cursor-pointer px-2 py-1.5 hover:bg-white rounded-lg transition-colors group">
                                    <input type="checkbox" name="permissions[]" value="{{ $modul }}_{{ $sub }}"
                                        class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded border-gray-300 flex-shrink-0">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-800">{{ $sub }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Biarkan kosong jika role belum memiliki izin akses.</p>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL EDIT ROLE --}}
    {{-- ============================================================ --}}
    <div x-show="modalEdit" style="display: none;"
        class="fixed inset-0 z-[100] flex items-start justify-center p-4 pt-8 bg-black/50 backdrop-blur-sm overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto my-6"
            @click.away="modalEdit = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Role & Izin Akses</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Mengedit: <span class="font-semibold text-[#E65C00]" x-text="editNama"></span></p>
                </div>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors ml-4 mt-1">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form :action="`{{ url('admin/user/role') }}/${editId}`" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_role" :value="editNama" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-semibold text-gray-700">
                            <i class="fa-solid fa-shield-halved text-[#E65C00] mr-1"></i> Izin Akses Modul
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-gray-500 font-medium select-none">
                            <input type="checkbox" @change="toggleAll($event.target.checked)"
                                class="w-3.5 h-3.5 text-[#E65C00] focus:ring-[#E65C00] rounded border-gray-300">
                            Centang Semua
                        </label>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 max-h-72 overflow-y-auto space-y-4 custom-scrollbar">
                        @foreach($modules as $modul => $submoduls)
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2 border-b border-gray-200 pb-1">
                                {{ $modul }}
                            </p>
                            <div class="space-y-1 pl-2">
                                @foreach($submoduls as $sub)
                                <label class="flex items-center gap-2.5 cursor-pointer px-2 py-1.5 hover:bg-white rounded-lg transition-colors group">
                                    <input type="checkbox" name="permissions[]"
                                        value="{{ $modul }}_{{ $sub }}"
                                        x-bind:checked="hasPermission('{{ $modul }}_{{ $sub }}')"
                                        class="perm-edit-cb w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded border-gray-300 flex-shrink-0">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-800">{{ $sub }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Centang modul yang boleh diakses oleh role ini.</p>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
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

    {{-- ============================================================ --}}
    {{-- MODAL HAPUS ROLE --}}
    {{-- ============================================================ --}}
    <div x-show="modalHapus" style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
            @click.away="modalHapus = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Role?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus role <b class="text-gray-700" x-text="hapusNama"></b>? Pengguna yang menggunakan role ini mungkin akan kehilangan akses sistem.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false"
                    class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`{{ url('admin/user/role') }}/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">
                        <i class="fa-solid fa-trash mr-1"></i> Ya, Hapus Role
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
