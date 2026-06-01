@extends('admin.layouts.app')

@section('content')

<div x-data="daftarPembelianApp()" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pembelian</h2>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                <span>Tampilkan</span>
                <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" placeholder="Cari Kode PO / Supplier..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1400px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-4 py-4">Kode PO</th>
                    <th class="px-4 py-4">Ref. Penjualan</th>
                    <th class="px-4 py-4">Tgl PO</th>
                    <th class="px-4 py-4">Supplier</th>
                    <th class="px-4 py-4">Telp/WA</th>
                    <th class="px-4 py-4 text-center">Diskon</th>
                    <th class="px-4 py-4 text-center">Qty Item</th>
                    <th class="px-4 py-4 text-right">Grand Total</th>
                    <th class="px-4 py-4 text-right">Telah Dibayar</th>
                    <th class="px-4 py-4 text-right">Sisa Hutang</th>
                    <th class="px-4 py-4 text-center">Jatuh Tempo</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse($pembelians as $index => $pb)
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                    <td class="px-4 py-4 font-bold text-[#E65C00]">{{ $pb->faktur }}</td>
                    <td class="px-4 py-4 font-medium text-gray-700">{{ $pb->penjualan->invoice ?? '-' }}</td>
                    <td class="px-4 py-4 text-gray-500">{{ \Carbon\Carbon::parse($pb->tanggal_faktur)->format('d M Y') }}</td>
                    <td class="px-4 py-4 font-bold">{{ $pb->supplier->nama_supplier ?? 'Supplier Dihapus' }}</td>
                    <td class="px-4 py-4">
                        <span class="bg-[#10B981] text-white px-3 py-1 rounded-md font-semibold text-xs shadow-sm">{{ $pb->supplier->no_telp ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 text-center text-red-500">{{ number_format($pb->diskon, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-center font-bold">{{ $pb->details->sum('qty') }}</td>
                    <td class="px-4 py-4 text-right font-black text-gray-800">Rp {{ number_format($pb->grand_total, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-right font-bold text-gray-700">Rp {{ number_format($pb->bayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-right font-bold text-red-500">Rp {{ number_format($pb->sisa_hutang, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-center font-medium">
                        @if($pb->jatuh_tempo && $pb->sisa_hutang > 0)
                            <span class="text-red-500">{{ \Carbon\Carbon::parse($pb->jatuh_tempo)->format('d M Y') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $pb->status_pembayaran == 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper($pb->status_pembayaran) }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <button @click="openDetail({{ $index }})" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Detail">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                            @if ($pb->status_pembayaran == 'Hutang')
                            <button @click="openEdit({{ $index }})" class="bg-[#10B981] hover:bg-[#059669] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Bayar Cicilan">
                                <i class="fa-solid fa-money-bill-wave text-xs"></i>
                            </button>
                            @endif
                            <button @click="openHapus({{ $index }})" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat pembelian barang ke supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
        <div>
            Menampilkan <span class="font-bold text-gray-700">{{ $pembelians->firstItem() ?? 0 }}</span> 
            sampai <span class="font-bold text-gray-700">{{ $pembelians->lastItem() ?? 0 }}</span> 
            dari <span class="font-bold text-[#E65C00]">{{ $pembelians->total() }}</span> data
        </div>
        <div class="flex items-center gap-1 text-sm">
            @if($pembelians->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $pembelians->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($pembelians->getUrlRange(1, $pembelians->lastPage()) as $page => $url)
                @if ($page == $pembelians->currentPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                @endif
            @endforeach

            @if($pembelians->hasMorePages())
                <a href="{{ $pembelians->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalDetail = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Detail PO: <span class="text-[#E65C00]" x-text="detailData.faktur"></span></h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div><p class="text-gray-500 mb-1">Supplier</p><p class="font-bold text-gray-800" x-text="detailData.supplier?.nama_supplier || 'Umum'"></p></div>
                    <div><p class="text-gray-500 mb-1">Ref. Penjualan</p><p class="font-bold text-gray-800" x-text="detailData.penjualan?.invoice || '-'"></p></div>
                    <div><p class="text-gray-500 mb-1">Tgl Faktur</p><p class="font-bold text-gray-800" x-text="formatTanggal(detailData.tanggal_faktur)"></p></div>
                    <div><p class="text-gray-500 mb-1">Status Pembayaran</p><p class="font-bold" :class="detailData.status_pembayaran === 'Lunas' ? 'text-green-600' : 'text-red-500'" x-text="detailData.status_pembayaran"></p></div>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr><th class="p-3">Item Dibeli</th><th class="p-3 text-center">Qty</th><th class="p-3 text-right">Harga Modal</th><th class="p-3 text-right">Subtotal</th></tr>
                        </thead>
                        <tbody>
                            <template x-for="item in detailData.details" :key="item.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3 font-medium" x-text="item.produk?.nama_item || 'Produk Dihapus'"></td>
                                    <td class="p-3 text-center" x-text="item.qty"></td>
                                    <td class="p-3 text-right" x-text="formatRupiah(item.harga_beli)"></td>
                                    <td class="p-3 text-right font-medium" x-text="formatRupiah(item.subtotal)"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center bg-orange-50 p-4 rounded-xl border border-orange-100">
                    <span class="text-gray-600 font-bold">Grand Total Modal:</span>
                    <span class="text-2xl font-black text-[#E65C00]" x-text="'Rp ' + formatRupiah(detailData.grand_total)"></span>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button @click="modalDetail = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalEdit = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Bayar Hutang Supplier</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/pembelian/${editData.id}/update-pembayaran`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-4 text-sm">
                    <div class="flex justify-between mb-1"><span class="text-gray-500">No PO:</span><span class="font-bold text-gray-800" x-text="editData.faktur"></span></div>
                    <div class="flex justify-between mb-1"><span class="text-gray-500">Supplier:</span><span class="font-bold text-gray-800" x-text="editData.supplier?.nama_supplier"></span></div>
                    <div class="flex justify-between mb-1"><span class="text-gray-500">Grand Total:</span><span class="font-bold text-gray-800" x-text="'Rp ' + formatRupiah(editData.grand_total)"></span></div>
                    <div class="flex justify-between mb-1"><span class="text-gray-500">Sudah Dibayar:</span><span class="font-bold text-green-600" x-text="'Rp ' + formatRupiah(editData.bayar)"></span></div>
                    <div class="flex justify-between pt-2 mt-2 border-t border-gray-200">
                        <span class="text-red-500 font-bold">SISA HUTANG:</span>
                        <span class="font-black text-red-500 text-lg" x-text="'Rp ' + formatRupiah(editData.sisa_hutang)"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nominal Transfer / Bayar Baru (Rp)</label>
                    <input type="number" name="nominal_tambah" x-model="nominalTambah" required min="1" placeholder="Cth: 500000" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-lg font-bold text-gray-800">
                    <p x-show="nominalTambah && parseInt(nominalTambah) > editData.sisa_hutang" x-transition class="text-xs text-red-500 mt-1 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation text-xs"></i> Nominal pembayaran melebihi sisa hutang!
                    </p>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" :disabled="!nominalTambah || parseInt(nominalTambah) > editData.sisa_hutang || parseInt(nominalTambah) <= 0"
                        class="px-5 py-2.5 bg-[#10B981] hover:bg-[#059669] disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30 disabled:shadow-none">Proses Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Batalkan Pembelian?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus arsip PO ini? (Stok barang tidak akan terpengaruh karena ini sistem Make-to-Order).</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form :action="`/admin/pembelian/${hapusId}`" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function daftarPembelianApp() {
        return {
            modalDetail: false,
            modalEdit: false,
            modalHapus: false,
            
            // Inject data dari PHP
            pembelians: @json($pembelians->items()),
            
            detailData: {},
            editData: {},
            nominalTambah: '',
            hapusId: '',

            openDetail(index) {
                this.detailData = this.pembelians[index];
                this.modalDetail = true;
            },

            openEdit(index) {
                this.editData = this.pembelians[index];
                this.nominalTambah = '';
                this.modalEdit = true;
            },

            openHapus(index) {
                this.hapusId = this.pembelians[index].id;
                this.modalHapus = true;
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka || 0);
            },
            
            formatTanggal(tgl) {
                if(!tgl) return '-';
                const d = new Date(tgl);
                return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        }
    }

    // Client-side search logic untuk tabel
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