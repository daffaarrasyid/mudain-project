@extends('admin.layouts.app')

@section('content')

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div x-data="{ 
            modalTambah: false, 
            modalEdit: false, 
            modalHapus: false,
            editAction: '',
            hapusAction: '',
            form: { nama: '', url: '', status: 'Publish' }
        }"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Mitra</h2>
                <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg transition-all transform hover:-translate-y-0.5">
                    Tambah Mitra
                </button>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Tampilkan</span>
                    <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
                <div class="relative flex-1 md:w-64">
                    <input type="text" id="searchInput" placeholder="Cari Mitra..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                    <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4 w-32">Logo / Gambar</th>
                        <th class="px-6 py-4">Nama Mitra</th>
                        <th class="px-6 py-4">URL</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse ($mitras as $item)
                        <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex items-center justify-center p-2">
                                    <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="w-full h-full object-contain">
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $item->nama_mitra }}</td>
                            <td class="px-6 py-4">
                                @if($item->url)
                                    <a href="{{ $item->url }}" target="_blank" class="text-blue-500 hover:underline"><i class="fa-solid fa-link mr-1"></i>Kunjungi</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'Publish')
                                    <span class="bg-[#10B981] text-white px-3 py-1.5 rounded-md text-[11px] font-bold shadow-sm">Publish</span>
                                @else
                                    <span class="bg-[#F59E0B] text-white px-3 py-1.5 rounded-md text-[11px] font-bold shadow-sm">Private</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-1.5 items-center justify-center">
                                    <button @click="modalEdit = true; editAction = '{{ route('admin.konten.mitra.update', $item->id) }}'; form.nama = '{{ $item->nama_mitra }}'; form.url = '{{ $item->url }}'; form.status = '{{ $item->status }}'"
                                        class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold transition-colors">Edit</button>
                                    
                                    <button @click="modalHapus = true; hapusAction = '{{ route('admin.konten.mitra.destroy', $item->id) }}'"
                                        class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold transition-colors">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data mitra.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan <span class="font-bold text-gray-700">{{ $mitras->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $mitras->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $mitras->total() }}</span> data</div>
            <div class="flex gap-1">
                @if($mitras->onFirstPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                @else
                    <a href="{{ $mitras->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
                @endif

                @foreach ($mitras->getUrlRange(1, $mitras->lastPage()) as $page => $url)
                    @if ($page == $mitras->currentPage())
                        <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                    @endif
                @endforeach

                @if($mitras->hasMorePages())
                    <a href="{{ $mitras->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
                @else
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                @endif
            </div>
        </div>

        <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto" @click.away="modalTambah = false" x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Mitra</h3>
                    <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="{{ route('admin.konten.mitra.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo Mitra <span class="text-red-500">*</span></label>
                        <input type="file" name="logo" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_mitra" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link URL (Opsional)</label>
                        <input type="url" name="url" placeholder="https://..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="relative">
                            <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 appearance-none cursor-pointer focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                                <option value="Publish">Publish</option>
                                <option value="Private">Private</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#E65C00] text-white font-medium rounded-xl">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto" @click.away="modalEdit = false" x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Mitra</h3>
                    <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form :action="editAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Logo (Opsional)</label>
                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_mitra" x-model="form.nama" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                        <input type="url" name="url" x-model="form.url" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="relative">
                            <select name="status" x-model="form.status" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 appearance-none cursor-pointer focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                                <option value="Publish">Publish</option>
                                <option value="Private">Private</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#38BDF8] text-white font-medium rounded-xl shadow-lg shadow-blue-500/30">Simpan Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
            <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false" x-transition>
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5"><i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Mitra?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus data mitra ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex gap-3 justify-center">
                    <button @click="modalHapus = false" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl">Batal</button>
                    <form :action="hapusAction" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-6 py-2.5 bg-red-500 text-white font-medium rounded-xl shadow-lg shadow-red-500/30">Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT PENCARIAN REAL-TIME & LIMIT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.data-row');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const keyword = e.target.value.toLowerCase();
                    tableRows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        row.style.display = rowText.includes(keyword) ? '' : 'none';
                    });
                });
            }

            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', this.value);
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                });
            }
        });
    </script>
@endsection