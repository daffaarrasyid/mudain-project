@extends('admin.layouts.app')

@section('content')
<div x-data="{ 
        modalTambah: false, 
        modalEdit: false, 
        modalHapus: false,
        editId: '',
        editNama: '',
        editHarga: '',
        hapusId: ''
    }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    <!-- Flash Message untuk feedback sukses -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Servis</h2>
            <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                Tambah Servis
            </button>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto">
                <span>Tampilkan</span>
                <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" placeholder="Cari..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200]">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4 w-2/4">Nama Layanan</th>
                    <th class="px-6 py-4 w-1/4">Harga Dasar</th>
                    <th class="px-6 py-4 text-center w-1/4">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600" id="tableBody">
                @forelse($servis as $index => $s)
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $s->nama_servis }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($s->harga_dasar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center">
                            <button @click="modalEdit = true; editId = '{{ $s->id }}'; editNama = '{{ $s->nama_servis }}'; editHarga = '{{ $s->harga_dasar }}'" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Edit
                            </button>
                            <button @click="modalHapus = true; hapusId = '{{ $s->id }}'" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data servis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (Persis Kategori) -->
    <div class="flex flex-col sm:flex-row items-center justify-between mt-8 text-sm text-gray-500 gap-4">
        <div>
            Menampilkan <span class="font-bold text-gray-700">{{ $servis->firstItem() ?? 0 }}</span> 
            sampai <span class="font-bold text-gray-700">{{ $servis->lastItem() ?? 0 }}</span> 
            dari <span class="font-bold text-[#E65C00]">{{ $servis->total() }}</span> data
        </div>
        <div class="flex items-center gap-1 text-sm">
            @if($servis->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $servis->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($servis->getUrlRange(1, $servis->lastPage()) as $page => $url)
                @if ($page == $servis->currentPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                @endif
            @endforeach

            @if($servis->hasMorePages())
                <a href="{{ $servis->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalTambah = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Data Servis</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.servis.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Hidden input untuk kode otomatis -->
                <input type="hidden" name="kode_servis" value="{{ $newCode }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan (Servis) <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_servis" placeholder="Contoh: Fotografer, Editing..." required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_dasar" placeholder="500000" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalEdit = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Servis</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`{{ url('admin/master-data/servis') }}/${editId}`" method="POST" class="space-y-4">
                @csrf @method('PUT') 
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_servis" x-model="editNama" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_dasar" x-model="editHarga" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Servis?</h3>
            <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus data ini? Data tidak dapat dikembalikan.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`{{ url('admin/master-data/servis') }}/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE') 
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT UNTUK REAL-TIME SEARCH PADA TABEL -->
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