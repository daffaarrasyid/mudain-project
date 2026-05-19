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
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-2 px-3 cursor-pointer">
                    <option>10</option><option>25</option><option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" placeholder="Cari No. Faktur / Supplier..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
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
                                <button @click="openDetail(index)" class="w-full bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass"></i> Detail Histori
                                </button>
                                
                                <button x-show="htg.sisa_hutang > 0" @click="openUpdate(index)" class="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-money-bill-transfer"></i> Bayar Cicilan
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
        <div class="flex items-center gap-2 text-sm">
            {{ $hutangs->links('pagination::tailwind') }} </div>
    </div>

    <div x-show="modalUpdate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalUpdate = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Pembayaran Hutang</h3>
                <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form :action="`/admin/transaksi/hutang/${updateData.id}/bayar`" method="POST" class="space-y-4">
                @csrf 
                @method('PUT')
                
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Supplier:</span><span class="font-bold text-gray-800" x-text="updateData.supplier?.nama_supplier"></span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Sisa Hutang Saat Ini:</span><span class="font-bold text-red-600" x-text="'Rp ' + formatRupiah(updateData.sisa_hutang)"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal_bayar" min="1" :max="updateData.sisa_hutang" placeholder="Cth: 500000" required
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-xl font-bold text-right text-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Bayar <span class="text-red-500">*</span></label>
                        <select name="metode_bayar" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="Cash / Tunai">Cash / Tunai</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Pembayaran</label>
                        <input type="date" value="{{ date('Y-m-d') }}" readonly class="w-full bg-gray-100 border border-gray-200 text-gray-500 rounded-lg px-4 py-2.5 outline-none cursor-not-allowed">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                    <textarea name="keterangan" rows="2" placeholder="Contoh: Pembayaran termin 1 via BNI..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalUpdate = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium rounded-xl transition-colors shadow-lg shadow-amber-500/30">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

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
                    <span class="text-sm font-bold text-gray-700" x-text="'Faktur: ' + detailData.faktur"></span>
                    <span class="text-sm font-bold px-3 py-1 rounded" :class="detailData.sisa_hutang <= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="detailData.sisa_hutang <= 0 ? 'LUNAS' : 'BELUM LUNAS'"></span>
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
                            <template x-for="riwayat in detailData.riwayat_pembayarans" :key="riwayat.id">
                                <tr class="border-b border-gray-50">
                                    <td class="p-3 text-gray-600" x-text="formatTanggal(riwayat.tanggal_bayar)"></td>
                                    <td class="p-3 font-medium text-gray-700" x-text="riwayat.metode_bayar"></td>
                                    <td class="p-3 font-bold text-green-600" x-text="'Rp ' + formatRupiah(riwayat.nominal_bayar)"></td>
                                    <td class="p-3 text-gray-500 italic" x-text="riwayat.keterangan || '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="!detailData.riwayat_pembayarans || detailData.riwayat_pembayarans.length === 0">
                                <td colspan="4" class="p-4 text-center text-gray-400">Belum ada riwayat cicilan untuk faktur ini.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-orange-50 font-bold text-gray-800">
                            <tr>
                                <td colspan="2" class="p-3 text-right">TOTAL TELAH DIBAYAR:</td>
                                <td colspan="2" class="p-3 text-[#E65C00] text-lg" x-text="'Rp ' + formatRupiah(detailData.bayar)"></td>
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
            
            // Ambil data PHP (pagination items)
            hutangs: @json($hutangs->items()),
            
            detailData: {},
            updateData: {},

            openDetail(index) {
                this.detailData = this.hutangs[index];
                this.modalDetail = true;
            },

            openUpdate(index) {
                this.updateData = this.hutangs[index];
                this.modalUpdate = true;
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