@extends('admin.layouts.app')

@section('content')

<div x-data="{ modalTambah: false, modalEdit: false, modalHapus: false, hapusId: '' }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
        <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Gagal Menyimpan Data!</div>
        <ul class="list-disc list-inside text-sm ml-5">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Stock In/Out</h2>
            <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                Tambah Data
            </button>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto mt-4 xl:mt-0">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                <span>Tampilkan</span>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-2 px-3 cursor-pointer">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" placeholder="Cari..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">Kode Barang</th>
                    <th class="px-6 py-4">Nama Item</th>
                    <th class="px-6 py-4">Satuan</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Nilai</th>
                    <th class="px-6 py-4">Jenis</th>
                    <th class="px-6 py-4">Sumber</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse($stoks as $index => $stok)
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                    <td class="px-6 py-4 font-bold text-[#E65C00]">{{ $stok->produk->kode_barang ?? '-' }}</td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $stok->produk->nama_item ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $stok->produk->satuan->nama_satuan ?? '-' }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ number_format($stok->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($stok->nilai, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($stok->jenis == 'Keluar')
                            <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 text-xs font-bold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-arrow-up text-[10px]"></i> Stok Keluar
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 text-xs font-bold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-arrow-down text-[10px]"></i> Stok Masuk
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $ket = $stok->keterangan ?? '';
                            $isPenjualan = str_contains($ket, 'Penjualan Invoice');
                            $isPembelian = str_contains($ket, 'Pembelian Faktur');
                        @endphp
                        @if($isPenjualan)
                            <span class="inline-flex items-center gap-1.5 bg-purple-50 border border-purple-200 text-purple-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-receipt text-[10px]"></i>
                                {{ $ket }}
                            </span>
                        @elseif($isPembelian)
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-truck text-[10px]"></i>
                                {{ $ket }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-200 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                                {{ $ket ?: 'Manual' }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($stok->tanggal)->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center">
                            <!-- Edit dikunci untuk keamanan audit stok -->
                            <button @click="modalEdit = true" class="bg-gray-300 text-white px-4 py-1 rounded w-16 text-xs font-semibold shadow-sm cursor-not-allowed" title="Audit Trail Terkunci">
                                Edit
                            </button>
                            <button @click="modalHapus = true; hapusId = '{{ $stok->id }}'" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1 rounded w-16 text-xs font-semibold shadow-sm transition-colors">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat stok masuk/keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between mt-8 text-sm text-gray-500 gap-4">
        <div>Menampilkan <span class="font-bold text-gray-700">{{ $stoks->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $stoks->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $stoks->total() }}</span> data</div>
        <div class="flex items-center gap-2 text-sm">
            @if($stoks->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $stoks->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $stoks->currentPage() }}</button>

            @if($stoks->hasMorePages())
                <a href="{{ $stoks->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <!-- MODAL TAMBAH (Animasi diperbaiki jadi halus ke tengah) -->
    <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto max-h-[90vh] overflow-y-auto" @click.away="modalTambah = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Stok Baru</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.stok.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- CUSTOM DROPDOWN PENCARIAN -->
                    <div class="md:col-span-2" x-data="{ 
                            search: '', 
                            open: false, 
                            selectedKode: '',
                            selectItem(kode, nama) {
                                this.search = kode + ' - ' + nama;
                                this.selectedKode = kode;
                                this.open = false;
                            }
                        }">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk (Ketik Kode / Nama) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <!-- Input tersembunyi yang akan dikirim ke Backend -->
                            <input type="hidden" name="produk_search" x-model="selectedKode" required>
                            
                            <!-- Input visual untuk ngetik -->
                            <input type="text" x-model="search" @input="open = true; selectedKode = ''" @focus="open = true" @click.away="open = false" autocomplete="off" placeholder="Ketik kode atau nama produk..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            
                            <!-- Dropdown List Hasil Pencarian -->
                            <ul x-show="open" class="absolute z-50 w-full mt-1 bg-white border border-gray-100 shadow-xl rounded-xl max-h-48 overflow-y-auto" style="display: none;">
                                @foreach($daftarProduk as $p)
                                <li class="px-4 py-2.5 hover:bg-orange-50 cursor-pointer text-sm border-b border-gray-50 last:border-0 transition-colors"
                                    x-show="'{{ strtolower($p->kode_barang . ' ' . addslashes($p->nama_item)) }}'.includes(search.toLowerCase())"
                                    @click="selectItem('{{ $p->kode_barang }}', '{{ addslashes($p->nama_item) }}')">
                                    <span class="font-bold text-[#E65C00]">{{ $p->kode_barang }}</span> - <span class="text-gray-700">{{ $p->nama_item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- END CUSTOM DROPDOWN -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi <span class="text-red-500">*</span></label>
                        <select name="jenis" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="Masuk">Stok Masuk (In)</option>
                            <option value="Keluar">Stok Keluar (Out)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" min="1" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                        <textarea name="keterangan" rows="2" placeholder="Contoh: Barang retur, Produksi batch A, dll." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan Stok</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT (UI Lock) -->
    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalEdit = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-5">
                <i class="fa-solid fa-lock text-3xl text-yellow-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Akses Terkunci</h3>
            <p class="text-sm text-gray-500 mb-6">Riwayat stok tidak dapat diedit untuk menjaga integritas data. Silakan hapus data yang salah dan buat entri baru.</p>
            <button @click="modalEdit = false" class="w-full px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Tutup</button>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalHapus = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Hapus Riwayat Stok?</h3>
            <p class="text-sm text-gray-500 mb-6 text-center">Yakin ingin menghapus pencatatan stok ini? Stok di database akan dikembalikan seperti semula (Rollback).</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`/admin/master-data/stok/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT PENCARIAN REAL-TIME PADA TABEL UTAMA -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.data-row');

        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(keyword) ? '' : 'none';
            });
        });
    });
</script>
@endsection