@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
</style>
<div x-data="{ modalPayment: false, modalUpdate: false, modalDetail: false }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 w-full">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Piutang</h2>
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
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1200px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Tgl Piutang</th>
                    <th class="px-6 py-4 text-center">Jth Tempo</th>
                    <th class="px-6 py-4">Jml Piutang</th>
                    <th class="px-6 py-4">Jml Bayar</th>
                    <th class="px-6 py-4 text-center">Sisa</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @for($i=1; $i<=5; $i++)
                @php
                    // Logika dummy: Baris ganjil = Belum Lunas, Baris genap = Lunas
                    $isLunas = ($i % 2 == 0);
                @endphp
                <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $i * 100 }}">
                    <td class="px-6 py-5 font-medium text-gray-700">BLP-0909439853</td>
                    <td class="px-6 py-5 font-medium text-gray-700">HSM Family</td>
                    <td class="px-6 py-5 text-gray-500">Asep</td> <td class="px-6 py-5 text-center text-gray-500">0</td>
                    <td class="px-6 py-5 font-bold">4.560.000</td>
                    <td class="px-6 py-5 font-bold">7.000.000</td>
                    <td class="px-6 py-5 text-center text-gray-800">45</td>
                    <td class="px-6 py-5 text-center font-semibold">
                        @if($isLunas)
                            <span class="bg-[#10B981] text-white px-3 py-1.5 rounded-md text-[11px] shadow-sm">Lunas</span>
                        @else
                            <span class="bg-[#EF4444] text-white px-3 py-1.5 rounded-md text-[11px] shadow-sm">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex flex-col gap-1.5 items-center justify-center w-[140px] mx-auto">
                            @if($isLunas)
                                <button @click="modalDetail = true" class="w-full bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass"></i> Detail Pembayaran
                                </button>
                            @else
                                <button @click="modalPayment = true" class="w-full bg-[#10B981] hover:bg-[#059669] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-credit-card"></i> Payment
                                </button>
                                <button @click="modalUpdate = true" class="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-rotate"></i> Update
                                </button>
                            @endif
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

    <div x-show="modalPayment" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalPayment = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Pembayaran Piutang</h3>
                <button @click="modalPayment = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="mb-6 space-y-4">
                <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Customer:</span><span class="font-bold text-gray-800">HSM Family</span></div>
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-600">Sisa Piutang:</span><span class="font-bold text-red-600">Rp 4.560.000</span></div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200"><span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Histori Pembayaran Sebelumnya</span></div>
                    <table class="w-full text-left text-sm">
                        <tbody class="text-gray-600">
                            <tr class="border-b border-gray-50">
                                <td class="p-3">01 Nov 2026</td><td class="p-3 font-bold text-gray-800">Rp 1.000.000</td><td class="p-3 text-gray-500">DP Awal Cash</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="#" method="POST" class="space-y-4 border-t border-gray-100 pt-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" min="1" placeholder="Masukkan jumlah yang dibayar customer..." required
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-[#10B981] focus:ring-1 focus:ring-[#10B981] text-lg font-bold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                    <textarea rows="2" placeholder="Contoh: Cicilan ke-2 via Transfer BCA..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#10B981] focus:ring-1 focus:ring-[#10B981]"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalPayment = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#10B981] hover:bg-[#059669] text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">Simpan Payment</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalUpdate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalUpdate = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Update Data Piutang</h3>
                <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Piutang (Rp)</label>
                    <input type="number" value="4560000" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Telah Dibayar (Rp)</label>
                    <input type="number" value="7000000" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jatuh Tempo</label>
                    <input type="text" value="0" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#F59E0B] focus:ring-1 focus:ring-[#F59E0B]">
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalUpdate = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium rounded-xl transition-colors shadow-lg shadow-amber-500/30">Simpan Update</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalDetail" style="display: none;" class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8" @click.away="modalDetail = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Detail Riwayat Pembayaran</h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-bold text-gray-700">Invoice: BLP-0909439853</span>
                    <span class="text-sm font-bold text-[#10B981]">Status: Lunas</span>
                </div>
                
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-3">Tanggal Bayar</th>
                                <th class="p-3">Nominal</th>
                                <th class="p-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-50">
                                <td class="p-3 text-gray-600">01 Nov 2026</td>
                                <td class="p-3 font-bold text-gray-800">Rp 1.000.000</td>
                                <td class="p-3 text-gray-500">DP Awal Cash</td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="p-3 text-gray-600">15 Nov 2026</td>
                                <td class="p-3 font-bold text-gray-800">Rp 3.560.000</td>
                                <td class="p-3 text-gray-500">Pelunasan via Transfer</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-gray-800">
                            <tr>
                                <td class="p-3 text-right">TOTAL TERBAYAR:</td>
                                <td colspan="2" class="p-3 text-[#E65C00]">Rp 4.560.000</td>
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
@endsection