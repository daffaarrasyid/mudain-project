@extends('admin.layouts.app')

@section('content')

<!-- State Alpine.js diupdate dengan variabel harga_jual_umum, harga_pelanggan, dan supplier -->
<div x-data="{ 
        modalTambah: false, 
        modalEdit: false, 
        modalHapus: false,
        modalImport: false,
        editId: '', editKode: '', editNama: '', editKategori: '', editSatuan: '', editSupplier: '', editHargaBeli: '', editHargaJualUmum: '', editHargaPelanggan: '', editStok: '',
        hapusId: '' 
    }" 
    class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> <span>{{ session('error') }}</span></div>
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

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Barang</h2>
            <div class="flex flex-wrap gap-2 mt-3">
                <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
                <button @click="modalImport = true" class="bg-[#10B981] hover:bg-[#059669] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-file-excel"></i> Import Excel
                </button>
            </div>
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
                <input type="text" id="searchInput" placeholder="Cari..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl hover:bg-[#cc5200] transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4 rounded-tl-xl">Gambar</th>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Item</th>
                    <th class="px-6 py-4">Kategori / Satuan</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Harga Beli</th>
                    <th class="px-6 py-4">H. Jual (Umum)</th>
                    <th class="px-6 py-4">H. Pelanggan</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4 rounded-tr-xl text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse($produks as $index => $prod)
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                    <td class="px-6 py-3">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm flex items-center justify-center">
                            @if($prod->gambar)
                                <img src="{{ asset('storage/' . $prod->gambar) }}" alt="{{ $prod->nama_item }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <i class="fa-solid fa-box text-gray-300 text-2xl"></i>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-3 font-bold text-[#E65C00]">{{ $prod->kode_barang }}</td>
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $prod->nama_item }}</td>
                    <td class="px-6 py-3">
                        {{ $prod->kategori->nama_kategori ?? '-' }}<br>
                        <span class="text-xs text-gray-400 font-normal">{{ $prod->satuan->nama_satuan ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-3">{{ $prod->supplier->nama_supplier ?? '-' }}</td>
                    <td class="px-6 py-3">Rp {{ number_format($prod->harga_beli, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 font-semibold text-gray-800">Rp {{ number_format($prod->harga_jual_umum, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 font-semibold text-blue-600">Rp {{ number_format($prod->harga_pelanggan, 0, ',', '.') }}</td>
                    <td class="px-6 py-3">
                        <span class="{{ $prod->stok > 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1 rounded-full font-bold text-xs">{{ $prod->stok }}</span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center">
                            <!-- Binding state edit Alpine -->
                            <button @click="modalEdit = true; editId = '{{ $prod->id }}'; editKode = '{{ $prod->kode_barang }}'; editNama = '{{ $prod->nama_item }}'; editKategori = '{{ $prod->kategori_id }}'; editSatuan = '{{ $prod->satuan_id }}'; editSupplier = '{{ $prod->supplier_id }}'; editHargaBeli = '{{ $prod->harga_beli }}'; editHargaJualUmum = '{{ $prod->harga_jual_umum }}'; editHargaPelanggan = '{{ $prod->harga_pelanggan }}'; editStok = '{{ $prod->stok }}'" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Edit
                            </button>
                            <button @click="modalHapus = true; hapusId = '{{ $prod->id }}'" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-8 text-center text-gray-400">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
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

    <!-- MODAL TAMBAH -->
    <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalTambah = false" x-transition>
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Produk Baru</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.data-produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Grid diperbesar jadi 3 kolom agar rapi menampung inputan baru -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_barang" placeholder="Manual Input" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_item" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                        <select name="satuan_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="">Pilih Satuan</option>
                            @foreach($satuans as $sat)
                                <option value="{{ $sat->id }}">{{ $sat->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <select name="supplier_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_beli" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Umum) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_jual_umum" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Pelanggan <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_pelanggan" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input type="number" name="stok" value="0" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT LENGKAP -->
    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalEdit = false" x-transition>
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Produk</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/master-data/data-produk/${editId}`" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>
                        <input type="text" x-model="editKode" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-500 font-bold cursor-not-allowed" readonly>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_item" x-model="editNama" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" x-model="editKategori" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                        <select name="satuan_id" x-model="editSatuan" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            @foreach($satuans as $sat)
                                <option value="{{ $sat->id }}">{{ $sat->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <select name="supplier_id" x-model="editSupplier" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_beli" x-model="editHargaBeli" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Umum) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_jual_umum" x-model="editHargaJualUmum" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Pelanggan <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_pelanggan" x-model="editHargaPelanggan" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Real</label>
                        <input type="number" name="stok" x-model="editStok" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false" x-transition>
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Data Produk?</h3>
            <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus data ini? Gambar dan data akan hilang permanen.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`/admin/master-data/data-produk/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE') 
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT EXCEL -->
    <div x-show="modalImport" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalImport = false" x-transition>
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-5">
                <i class="fa-solid fa-file-excel text-3xl text-green-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Import Data Produk</h3>
            <form action="{{ route('admin.data-produk.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mb-6 mt-4">
                <div class="flex justify-center gap-3">
                    <button type="button" @click="modalImport = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="w-full px-6 py-2.5 bg-[#10B981] hover:bg-[#059669] text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">Upload</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- SCRIPT PENCARIAN REAL-TIME -->
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