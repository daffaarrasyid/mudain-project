@extends('admin.layouts.app')

@section('content')

<div x-data="piutangApp()" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 w-full">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Piutang Customer</h2>
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
                <input type="text" id="searchInput" placeholder="Cari Invoice / Customer..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1200px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Tgl Transaksi</th>
                    <th class="px-6 py-4 text-center">Jth Tempo</th>
                    <th class="px-6 py-4 text-right">Jml Tagihan</th>
                    <th class="px-6 py-4 text-right">Jml Bayar</th>
                    <th class="px-6 py-4 text-right">Sisa Piutang</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                <template x-for="(ptg, index) in piutangs" :key="ptg.id">
                    <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up">
                        <td class="px-6 py-5 font-bold text-[#E65C00]" x-text="ptg.invoice"></td>
                        <td class="px-6 py-5 font-medium text-gray-700" x-text="ptg.customer?.nama_customer || 'Umum'"></td>
                        <td class="px-6 py-5 text-gray-500" x-text="formatTanggal(ptg.created_at)"></td> 
                        <td class="px-6 py-5 text-center text-red-500 font-medium" x-text="formatTanggal(ptg.jatuh_tempo) || '-'"></td>
                        <td class="px-6 py-5 text-right font-bold text-gray-800" x-text="'Rp ' + formatRupiah(ptg.total_harga)"></td>
                        <td class="px-6 py-5 text-right font-bold text-green-600" x-text="'Rp ' + formatRupiah(ptg.bayar)"></td>
                        <td class="px-6 py-5 text-right font-black text-red-500" x-text="'Rp ' + formatRupiah(getSisa(ptg))"></td>
                        <td class="px-6 py-5 text-center font-semibold">
                            <span x-show="ptg.kembalian >= 0" class="bg-[#10B981] text-white px-3 py-1.5 rounded-md text-[11px] shadow-sm">Lunas</span>
                            <span x-show="ptg.kembalian < 0" class="bg-[#EF4444] text-white px-3 py-1.5 rounded-md text-[11px] shadow-sm">Belum Lunas</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col gap-1.5 items-center justify-center w-[140px] mx-auto">
                                <button x-show="ptg.kembalian >= 0" @click="openDetail(index)" class="w-full bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass"></i> Detail Histori
                                </button>
                                
                                <button x-show="ptg.kembalian < 0" @click="openPayment(index)" class="w-full bg-[#10B981] hover:bg-[#059669] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-credit-card"></i> Catat Cicilan
                                </button>
                                <button x-show="ptg.kembalian < 0" @click="openUpdate(index)" class="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-rotate"></i> Koreksi Data
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr x-show="piutangs.length === 0">
                    <td colspan="9" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada catatan piutang customer.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
        <div>Menampilkan <span class="font-bold text-gray-700">{{ $piutangs->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $piutangs->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $piutangs->total() }}</span> data</div>
        <div class="flex items-center gap-1 text-sm">
            @if($piutangs->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $piutangs->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($piutangs->getUrlRange(1, $piutangs->lastPage()) as $page => $url)
                @if ($page == $piutangs->currentPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                @endif
            @endforeach

            @if($piutangs->hasMorePages())
                <a href="{{ $piutangs->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <div x-show="modalPayment" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalPayment = false" x-transition>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Pembayaran Cicilan Piutang</h3>
                <button @click="modalPayment = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="mb-6 space-y-4">
                <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Customer:</span><span class="font-bold text-gray-800" x-text="activeData.customer?.nama_customer || 'Umum'"></span></div>
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Sisa Tagihan (Kekurangan):</span><span class="font-black text-red-600 text-lg" x-text="'Rp ' + formatRupiah(getSisa(activeData))"></span></div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200"><span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Histori Pembayaran Sebelumnya</span></div>
                    <table class="w-full text-left text-sm">
                        <tbody class="text-gray-600">
                            <template x-for="riwayat in activeData.riwayat_pembayarans" :key="riwayat.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3" x-text="formatTanggal(riwayat.tanggal_bayar)"></td>
                                    <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(riwayat.nominal_bayar)"></td>
                                    <td class="p-3 text-gray-500" x-text="riwayat.keterangan || '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="!activeData.riwayat_pembayarans || activeData.riwayat_pembayarans.length === 0">
                                <td colspan="3" class="p-3 text-center text-gray-400 italic">Belum ada cicilan yang dicatat.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form :action="`/admin/transaksi/piutang/${activeData.id}/bayar`" method="POST" class="space-y-4 border-t border-gray-100 pt-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran Customer (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominal_bayar" min="1" :max="getSisa(activeData)" placeholder="Masukkan jumlah yang dibayar..." required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-[#10B981] focus:ring-1 focus:ring-[#10B981] text-lg font-bold text-right">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="2" placeholder="Contoh: Cicilan ke-2 via Transfer BCA..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#10B981] focus:ring-1 focus:ring-[#10B981]"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalPayment = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#10B981] hover:bg-[#059669] text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">Simpan Payment</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalUpdate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalUpdate = false" x-transition>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Koreksi Data Piutang</h3>
                <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/transaksi/piutang/${activeData.id}/update`" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="bg-orange-50 text-orange-700 text-xs p-3 rounded-lg flex items-start gap-2 mb-4">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <p>Hanya gunakan form ini jika ada kesalahan input nominal saat pembuatan nota awal atau untuk merevisi Jatuh Tempo.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Tagihan Piutang (Rp)</label>
                    <input type="number" name="total_harga" x-model="activeData.total_harga" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Telah Dibayar Keseluruhan (Rp)</label>
                    <input type="number" name="bayar" x-model="activeData.bayar" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" x-model="activeData.jatuh_tempo" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalUpdate = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium rounded-xl transition-colors shadow-lg shadow-amber-500/30">Simpan Koreksi</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalDetail = false" x-transition>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Detail Riwayat Pembayaran Customer</h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-bold text-gray-700" x-text="'Invoice: ' + activeData.invoice"></span>
                    <span class="text-sm font-bold px-3 py-1 rounded" :class="activeData.kembalian >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="activeData.kembalian >= 0 ? 'LUNAS' : 'BELUM LUNAS'"></span>
                </div>
                
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-3">Tanggal Bayar</th>
                                <th class="p-3 text-right">Nominal</th>
                                <th class="p-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="riwayat in activeData.riwayat_pembayarans" :key="riwayat.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3 text-gray-600" x-text="formatTanggal(riwayat.tanggal_bayar)"></td>
                                    <td class="p-3 text-right font-bold text-green-600" x-text="'Rp ' + formatRupiah(riwayat.nominal_bayar)"></td>
                                    <td class="p-3 text-gray-500 italic" x-text="riwayat.keterangan || '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="!activeData.riwayat_pembayarans || activeData.riwayat_pembayarans.length === 0">
                                <td colspan="3" class="p-3 text-center text-gray-400">Belum ada riwayat cicilan untuk faktur ini.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-gray-800">
                            <tr>
                                <td class="p-3 text-right">TOTAL TELAH DIBAYAR:</td>
                                <td class="p-3 text-right text-[#E65C00] text-lg" x-text="'Rp ' + formatRupiah(activeData.bayar)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button @click="modalDetail = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Tutup</button>
            </div>
        </div>
    </div>

</div>

<script>
    function piutangApp() {
        return {
            modalPayment: false,
            modalUpdate: false,
            modalDetail: false,
            
            piutangs: @json($piutangs->items()),
            activeData: {},

            openPayment(index) {
                this.activeData = { ...this.piutangs[index] };
                this.modalPayment = true;
            },
            openUpdate(index) {
                this.activeData = { ...this.piutangs[index] };
                this.modalUpdate = true;
            },
            openDetail(index) {
                this.activeData = { ...this.piutangs[index] };
                this.modalDetail = true;
            },

            // Fungsi ambil Sisa Piutang (Kekurangan)
            getSisa(data) {
                if(!data) return 0;
                let sisa = data.total_harga - data.bayar;
                return sisa > 0 ? sisa : 0;
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka || 0);
            },
            formatTanggal(tgl) {
                if(!tgl) return '';
                return new Date(tgl).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        }
    }

    // Client-side search tabel
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