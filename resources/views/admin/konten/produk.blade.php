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
            form: { nama: '' }
        }"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Katalog Produk</h2>
                <button @click="modalTambah = true"
                    class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Tambah Produk
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
                    <input type="text" id="searchInput" placeholder="Cari..."
                        class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                    <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors"><i
                            class="fa-solid fa-search"></i></button>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4 w-40">Gambar</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($produks as $item)
                    <tr class="data-row border-b border-gray-50 hover:bg-orange-50/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-28 h-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $item->nama_produk }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-1.5 items-center justify-center">
                                <button @click="modalEdit = true; editAction = '{{ route('admin.konten.produk.update', $item->id) }}'; form.nama = '{{ $item->nama_produk }}'"
                                    class="bg-[#38BDF8] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold hover:bg-[#0284C7] transition-colors">Edit</button>
                                <button @click="modalHapus = true; hapusAction = '{{ route('admin.konten.produk.destroy', $item->id) }}'"
                                    class="bg-[#EF4444] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold hover:bg-[#B91C1C] transition-colors">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada katalog produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan <span class="font-bold text-gray-700">{{ $produks->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $produks->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $produks->total() }}</span> data</div>
            <div class="flex gap-1">
                @if($produks->onFirstPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                @else
                    <a href="{{ $produks->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
                @endif

                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                    @if ($page == $produks->currentPage())
                        <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                    @endif
                @endforeach

                @if($produks->hasMorePages())
                    <a href="{{ $produks->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
                @else
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                @endif
            </div>
        </div>

        <div x-show="modalTambah" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto"
                @click.away="modalTambah = false" x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Produk</h3>
                    <button @click="modalTambah = false" class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="{{ route('admin.konten.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                        <input type="file" name="gambar" accept="image/*" required
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama / Kategori Produk</label>
                        <input type="text" name="nama_produk" placeholder="Cth: Kaos Custom, Jaket Custom..." required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 font-medium rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#E65C00] font-medium text-white rounded-xl">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalEdit" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto" @click.away="modalEdit = false"
                x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Produk</h3>
                    <button @click="modalEdit = false" class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form :action="editAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Gambar (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="nama_produk" x-model="form.nama" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 font-medium rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#38BDF8] font-medium text-white rounded-xl shadow-lg shadow-blue-500/30">Simpan Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalHapus" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
                @click.away="modalHapus = false" x-transition>
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5"><i
                        class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Produk?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus produk ini dari katalog?</p>
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