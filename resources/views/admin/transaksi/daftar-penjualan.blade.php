@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
</style>

<div x-data="{ modalDetail: false, modalEdit: false, modalHapus: false }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full overflow-x-hidden">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 w-full">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Penjualan</h2>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                <span>Tampilkan</span>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-2 px-3 cursor-pointer">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Kasir</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4 text-center">Diskon</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Payment<br>Method</th>
                    <th class="px-6 py-4 text-center">Qty</th>
                    <th class="px-6 py-4">Waktu</th>
                    <th class="px-6 py-4 text-center">Persentase</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @for($i=1; $i<=5; $i++)
                <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $i * 100 }}">
                    <td class="px-6 py-4 font-medium text-gray-700">BLP2026010200001</td>
                    <td class="px-6 py-4">Taufik</td>
                    <td class="px-6 py-4">Asep</td>
                    <td class="px-6 py-4 text-center">0</td>
                    <td class="px-6 py-4 font-bold text-gray-800">4.560.000</td>
                    <td class="px-6 py-4">Kredit</td>
                    <td class="px-6 py-4 text-center font-medium">45</td>
                    <td class="px-6 py-4 text-gray-500 text-xs">2026-04-02<br>19:17:00</td>
                    <td class="px-6 py-4 text-center">{{ $i % 2 == 0 ? '100%' : '60%' }}</td>
                    <td class="px-6 py-4">
                        <div class="grid grid-cols-2 gap-1.5 w-[160px] mx-auto">
                            <button @click="modalDetail = true" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-magnifying-glass"></i> Detail
                            </button>
                            <button class="bg-[#10B981] hover:bg-[#059669] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-print"></i> Cetak
                            </button>
                            @if ($i % 2 != 0)
                            <button @click="modalEdit = true" class="bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            @endif
                            <button @click="modalHapus = true" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
        <div>Menampilkan 1 sampai 10 dari 20 data</div>
        <div class="flex items-center gap-2 text-sm">
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100 transition-colors"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">1</button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">2</button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">3</button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">4</button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">5</button>
            <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100 transition-colors"><i class="fa-solid fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalDetail = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Detail Invoice: BLP2026010200001</h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div><p class="text-gray-500 mb-1">Kasir</p><p class="font-bold text-gray-800">Taufik</p></div>
                    <div><p class="text-gray-500 mb-1">Customer</p><p class="font-bold text-gray-800">Asep</p></div>
                    <div><p class="text-gray-500 mb-1">Waktu</p><p class="font-bold text-gray-800">02 Apr 2026 19:17</p></div>
                    <div><p class="text-gray-500 mb-1">Metode Bayar</p><p class="font-bold text-gray-800">Kredit</p></div>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr><th class="p-3">Item</th><th class="p-3 text-center">Qty</th><th class="p-3 text-right">Harga</th><th class="p-3 text-right">Subtotal</th></tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-50">
                                <td class="p-3">PDH 2 in 1</td><td class="p-3 text-center">20</td><td class="p-3 text-right">100.000</td><td class="p-3 text-right font-medium">2.000.000</td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="p-3">Rompi Lapangan</td><td class="p-3 text-center">25</td><td class="p-3 text-right">102.400</td><td class="p-3 text-right font-medium">2.560.000</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-gray-800">
                            <tr><td colspan="3" class="p-3 text-right">Diskon</td><td class="p-3 text-right text-red-500">- 0</td></tr>
                            <tr><td colspan="3" class="p-3 text-right text-lg">TOTAL</td><td class="p-3 text-right text-lg text-[#E65C00]">Rp 4.560.000</td></tr>
                        </tfoot>
                    </table>
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
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Update Pembayaran Kredit</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Invoice:</span>
                        <span class="font-bold text-gray-800">BLP2026010200001</span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Customer:</span>
                        <span class="font-bold text-gray-800">Asep</span>
                    </div>
                    <div class="flex justify-between text-sm border-t border-orange-200 pt-2 mt-2">
                        <span class="text-gray-600 font-medium">Total Tagihan:</span>
                        <span class="font-black text-[#E65C00]">Rp 4.560.000</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Progres Pembayaran Masuk <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" min="0" max="100" value="60" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-12 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-lg font-bold text-gray-800">
                        
                        <div class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 pointer-events-none font-bold text-lg border-l border-gray-200 bg-gray-100 rounded-r-lg">
                            %
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-[#E65C00]"></i> 
                        Ubah menjadi 100 untuk menandai transaksi ini LUNAS.
                    </p>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium rounded-xl transition-colors shadow-lg shadow-amber-500/30">Update Persentase</button>
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
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Transaksi?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin membatalkan dan menghapus data penjualan ini? Tindakan ini dapat memengaruhi laporan keuangan.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form action="#" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection