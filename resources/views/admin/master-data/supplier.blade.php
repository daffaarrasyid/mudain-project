@extends('admin.layouts.app')

@section('content')

<!-- State Alpine.js mencakup data untuk Edit dan Modal Import -->
<div x-data="{ 
        modalTambah: false, 
        modalEdit: false, 
        modalHapus: false,
        modalImport: false,
        editId: '', editKode: '', editNama: '', editTelp: '', editEmail: '', editBank: '', editRek: '', editAlamat: '',
        hapusId: ''
    }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    <!-- Flash Message -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Supplier</h2>
            <div class="flex flex-wrap gap-2">
                <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Tambah Data
                </button>
                <!-- Tombol Export PDF mengarah langsung ke Route -->
                <a href="{{ route('admin.supplier.export-pdf') }}" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    Export PDF
                </a>
                <!-- Tombol Import Memicu Modal Baru -->
                <button @click="modalImport = true" class="bg-[#10B981] hover:bg-[#059669] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5">
                    Import Data
                </button>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto mt-4 xl:mt-0">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                <span>Tampilkan</span>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-2 px-3">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" placeholder="Cari..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200]">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Supplier</th>
                    <th class="px-6 py-4">Telp</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Bank</th>
                    <th class="px-6 py-4">Rekening</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600" id="tableBody">
                @forelse($suppliers as $index => $sup)
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                    <td class="px-6 py-4 font-bold text-[#E65C00]">{{ $sup->kode_supplier }}</td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $sup->nama_supplier }}</td>
                    <td class="px-6 py-4">{{ $sup->no_telp }}</td>
                    <td class="px-6 py-4">{{ $sup->email ?? '-' }}</td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $sup->nama_bank ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $sup->no_rekening ?? '-' }}</td>
                    <td class="px-6 py-4 truncate max-w-[150px]">{{ $sup->alamat ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center">
                            <!-- Injecting semua field ke Alpine State -->
                            <button @click="modalEdit = true; editId = '{{ $sup->id }}'; editKode = '{{ $sup->kode_supplier }}'; editNama = '{{ $sup->nama_supplier }}'; editTelp = '{{ $sup->no_telp }}'; editEmail = '{{ $sup->email }}'; editBank = '{{ $sup->nama_bank }}'; editRek = '{{ $sup->no_rekening }}'; editAlamat = '{{ $sup->alamat }}'" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1 rounded w-16 text-xs font-semibold shadow-sm transition-colors">
                                Edit
                            </button>
                            <button @click="modalHapus = true; hapusId = '{{ $sup->id }}'" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1 rounded w-16 text-xs font-semibold shadow-sm transition-colors">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">Belum ada data supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between mt-8 text-sm text-gray-500 gap-4">
        <div>
            Menampilkan <span class="font-bold text-gray-700">{{ $suppliers->firstItem() ?? 0 }}</span> 
            sampai <span class="font-bold text-gray-700">{{ $suppliers->lastItem() ?? 0 }}</span> 
            dari <span class="font-bold text-[#E65C00]">{{ $suppliers->total() }}</span> data
        </div>
        <div class="flex items-center gap-2 text-sm">
            @if($suppliers->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $suppliers->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $suppliers->currentPage() }}</button>

            @if($suppliers->hasMorePages())
                <a href="{{ $suppliers->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalTambah = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Data Supplier</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.supplier.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Supplier</label>
                        <!-- Value diisi oleh $newCode dari controller -->
                        <input type="text" name="kode_supplier" value="{{ $newCode }}" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-500 font-bold cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_supplier" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp / WA <span class="text-red-500">*</span></label>
                        <input type="text" name="no_telp" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                        <input type="text" name="nama_bank" placeholder="Contoh: BNI, BCA..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Rekening</label>
                        <input type="text" name="no_rekening" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalEdit = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Supplier</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/master-data/supplier/${editId}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Supplier</label>
                        <!-- x-model untuk menerima injeksi data -->
                        <input type="text" x-model="editKode" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-500 font-bold cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_supplier" x-model="editNama" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp / WA <span class="text-red-500">*</span></label>
                        <input type="text" name="no_telp" x-model="editTelp" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" x-model="editEmail" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                        <input type="text" name="nama_bank" x-model="editBank" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Rekening</label>
                        <input type="text" name="no_rekening" x-model="editRek" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <!-- Pada textarea di Alpine, kita tidak taruh x-model di tag input, tapi tetep pakai x-model buat textarea juga -->
                        <textarea name="alamat" x-model="editAlamat" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
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
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Supplier?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus data supplier ini? Data transaksi yang berhubungan mungkin akan terdampak.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`/admin/master-data/supplier/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT EXCEL -->
    <div x-show="modalImport" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalImport = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-5">
                <i class="fa-solid fa-file-excel text-3xl text-green-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Import Data Supplier</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih file Excel (xls/xlsx/csv) untuk mengimpor data massal.</p>
            
            <form action="{{ route('admin.supplier.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file_excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mb-6">
                
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button type="button" @click="modalImport = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="w-full px-6 py-2.5 bg-[#10B981] hover:bg-[#059669] text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">Upload Data</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- SCRIPT PENCARIAN -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.data-row');

        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection