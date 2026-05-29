@extends('admin.layouts.app')

@section('content')

<div x-data="hutangApp()" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 w-full">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Hutang</h2>
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
                <input type="text" id="searchInput" placeholder="Cari No. Faktur / Supplier..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
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
                    <th class="px-6 py-4">Faktur PO</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Tgl PO</th>
                    <th class="px-6 py-4">Jth Tempo</th>
                    <th class="px-6 py-4 text-right">Grand Total</th>
                    <th class="px-6 py-4 text-right">Jml Bayar</th>
                    <th class="px-6 py-4 text-right">Sisa Hutang</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                <template x-for="(htg, index) in hutangs" :key="htg.id">
                    <tr class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up">
                        <td class="px-6 py-5 font-bold text-[#E65C00]" x-text="htg.faktur"></td>
                        <td class="px-6 py-5 font-medium text-gray-700" x-text="htg.supplier?.nama_supplier || 'Umum'"></td>
                        <td class="px-6 py-5 text-gray-500" x-text="formatTanggal(htg.tanggal_faktur)"></td>
                        <td class="px-6 py-5 text-red-500 font-medium" x-text="formatTanggal(htg.jatuh_tempo) || '-'"></td>
                        <td class="px-6 py-5 text-right font-bold text-gray-800" x-text="'Rp ' + formatRupiah(htg.grand_total)"></td>
                        <td class="px-6 py-5 text-right font-bold text-green-600" x-text="'Rp ' + formatRupiah(htg.bayar)"></td>
                        <td class="px-6 py-5 text-right font-black text-red-500" x-text="'Rp ' + formatRupiah(htg.sisa_hutang)"></td>
                        <td class="px-6 py-5 text-center font-semibold">
                            <span x-show="htg.sisa_hutang <= 0" class="bg-[#10B981] text-white px-3 py-1.5 rounded-md text-xs shadow-sm">Lunas</span>
                            <span x-show="htg.sisa_hutang > 0" class="bg-[#EF4444] text-white px-3 py-1.5 rounded-md text-xs shadow-sm">Belum Lunas</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col gap-1.5 items-center justify-center w-[140px] mx-auto">
                                <!-- Selalu Tampilkan Detail Histori -->
                                <button @click="openDetail(index)" class="w-full bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass"></i> Detail Histori
                                </button>
                                
                                <!-- Hanya Tampilkan Bayar Cicilan & Koreksi jika Belum Lunas -->
                                <button x-show="htg.sisa_hutang > 0" @click="openUpdate(index)" class="w-full bg-[#10B981] hover:bg-[#059669] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-money-bill-wave"></i> Bayar Cicilan
                                </button>
                                <button x-show="htg.sisa_hutang > 0" @click="openKoreksi(index)" class="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-rotate"></i> Koreksi Data
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr x-show="hutangs.length === 0">
                    <td colspan="9" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada tagihan hutang ke supplier saat ini.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
        <div>Menampilkan <span class="font-bold text-gray-700">{{ $hutangs->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $hutangs->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $hutangs->total() }}</span> data</div>
        <div class="flex items-center gap-1 text-sm">
            @if($hutangs->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $hutangs->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($hutangs->getUrlRange(1, $hutangs->lastPage()) as $page => $url)
                @if ($page == $hutangs->currentPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                @endif
            @endforeach

            @if($hutangs->hasMorePages())
                <a href="{{ $hutangs->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    <!-- MODAL BAYAR CICILAN (DIALIRKAN DENGAN PIUTANG) -->
    <div x-show="modalUpdate" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto" x-transition.opacity>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalUpdate = false" x-transition>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Pembayaran Cicilan Hutang</h3>
                <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="mb-6 space-y-4">
                <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Supplier:</span><span class="font-bold text-gray-800" x-text="activeData.supplier?.nama_supplier || 'Umum'"></span></div>
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Sisa Hutang:</span><span class="font-black text-red-600 text-lg" x-text="'Rp ' + formatRupiah(activeData.sisa_hutang)"></span></div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200"><span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Histori Pembayaran Sebelumnya</span></div>
                    <table class="w-full text-left text-sm">
                        <tbody class="text-gray-600">
                            <!-- Pembayaran Awal / DP (Diambil dari: total bayar - total cicilan) -->
                            <tr x-show="(activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0)) > 0" class="border-b border-gray-50 bg-gray-50/50">
                                <td class="p-3" x-text="formatTanggal(activeData.tanggal_faktur)"></td>
                                <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0))"></td>
                                <td class="p-3 text-gray-500 italic">Uang Muka (DP)</td>
                            </tr>
                            <template x-for="riwayat in activeData.riwayat_pembayarans" :key="riwayat.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3" x-text="formatTanggal(riwayat.tanggal_bayar)"></td>
                                    <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(riwayat.nominal_bayar)"></td>
                                    <td class="p-3 text-gray-500" x-text="riwayat.keterangan || '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="(!activeData.riwayat_pembayarans || activeData.riwayat_pembayarans.length === 0) && (activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0)) <= 0">
                                <td colspan="3" class="p-3 text-center text-gray-400 italic">Belum ada cicilan yang dicatat.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form :action="`/admin/transaksi/hutang/${activeData.id}/bayar`" method="POST" class="space-y-4 border-t border-gray-100 pt-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominal_bayar" x-model="nominalBayar" min="1" :max="activeData.sisa_hutang" placeholder="Masukkan jumlah yang dibayar..." required
                           class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-lg font-bold text-right text-gray-800">
                    <p x-show="nominalBayar && parseInt(nominalBayar) > activeData.sisa_hutang" x-transition class="text-xs text-red-500 mt-1 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation text-xs"></i> Nominal pembayaran melebihi sisa hutang!
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                    <textarea name="keterangan" rows="2" placeholder="Contoh: Pembayaran termin 1 via BNI..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalUpdate = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" :disabled="!nominalBayar || parseInt(nominalBayar) > activeData.sisa_hutang || parseInt(nominalBayar) <= 0"
                            class="px-5 py-2.5 bg-[#10B981] hover:bg-[#059669] disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30 disabled:shadow-none">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KOREKSI DATA HUTANG -->
    <div x-show="modalKoreksi" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalKoreksi = false" x-transition>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Koreksi Data Hutang</h3>
                <button @click="modalKoreksi = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/transaksi/hutang/${activeData.id}/update`" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="bg-orange-50 text-orange-700 text-xs p-3 rounded-lg flex items-start gap-2 mb-4">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <p>Hanya gunakan form ini jika ada kesalahan input nominal saat pembuatan nota awal atau untuk merevisi Jatuh Tempo.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Tagihan Hutang (Rp)</label>
                    <input type="number" name="grand_total" x-model="activeData.grand_total" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
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
                    <button type="button" @click="modalKoreksi = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium rounded-xl transition-colors shadow-lg shadow-amber-500/30">Simpan Koreksi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DETAIL HISTORI MODAL (DIALIRKAN DENGAN PIUTANG) -->
    <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalDetail = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Riwayat Pembayaran Hutang</h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-bold text-gray-700" x-text="'Faktur: ' + activeData.faktur"></span>
                    <span class="text-sm font-bold px-3 py-1 rounded" :class="activeData.sisa_hutang <= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="activeData.sisa_hutang <= 0 ? 'LUNAS' : 'BELUM LUNAS'"></span>
                </div>
                
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-3">Tanggal Bayar</th>
                                <th class="p-3">Metode</th>
                                <th class="p-3">Nominal</th>
                                <th class="p-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Pembayaran Awal / DP (Diambil dari: total bayar - total cicilan) -->
                            <tr x-show="(activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0)) > 0" class="border-b border-gray-50 bg-gray-50/50">
                                <td class="p-3" x-text="formatTanggal(activeData.tanggal_faktur)"></td>
                                <td class="p-3 font-semibold text-gray-700">-</td>
                                <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0))"></td>
                                <td class="p-3 text-gray-500 italic">Uang Muka (DP)</td>
                            </tr>
                            <template x-for="riwayat in activeData.riwayat_pembayarans" :key="riwayat.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3 text-gray-600" x-text="formatTanggal(riwayat.tanggal_bayar)"></td>
                                    <td class="p-3 font-medium text-gray-700" x-text="riwayat.metode_bayar"></td>
                                    <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(riwayat.nominal_bayar)"></td>
                                    <td class="p-3 text-gray-500 italic" x-text="riwayat.keterangan || '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="(!activeData.riwayat_pembayarans || activeData.riwayat_pembayarans.length === 0) && (activeData.bayar - (activeData.riwayat_pembayarans?.reduce((sum, r) => sum + parseInt(r.nominal_bayar), 0) || 0)) <= 0">
                                <td colspan="4" class="p-4 text-center text-gray-400">Belum ada riwayat cicilan untuk faktur ini.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-orange-50 font-bold text-gray-800">
                            <tr>
                                <td colspan="2" class="p-3 text-right">TOTAL TELAH DIBAYAR:</td>
                                <td colspan="2" class="p-3 text-[#E65C00] text-lg" x-text="'Rp ' + formatRupiah(activeData.bayar)"></td>
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
    function hutangApp() {
        return {
            modalDetail: false,
            modalUpdate: false,
            modalKoreksi: false,
            
            // Ambil data PHP (pagination items)
            hutangs: @json($hutangs->items()),
            
            activeData: {},
            nominalBayar: '',

            openDetail(index) {
                this.activeData = { ...this.hutangs[index] };
                this.modalDetail = true;
            },

            openUpdate(index) {
                this.activeData = { ...this.hutangs[index] };
                this.nominalBayar = '';
                this.modalUpdate = true;
            },
            
            openKoreksi(index) {
                this.activeData = { ...this.hutangs[index] };
                this.modalKoreksi = true;
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka || 0);
            },
            
            formatTanggal(tgl) {
                if(!tgl) return '';
                const d = new Date(tgl);
                return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        }
    }

    // Client-side search untuk tabel
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