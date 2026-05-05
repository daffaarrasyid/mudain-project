@extends('admin.layouts.app')

@section('content')

<div x-data="{ modalDetail: false, modalEdit: false, modalHapus: false }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pembelian</h2>
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
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1400px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-4 py-4">Kode</th>
                    <th class="px-4 py-4">No. Faktur</th>
                    <th class="px-4 py-4">Tgl Faktur</th>
                    <th class="px-4 py-4">Supplier</th>
                    <th class="px-4 py-4">Telp/WA</th>
                    <th class="px-4 py-4">Bank</th>
                    <th class="px-4 py-4">NoRek</th>
                    <th class="px-4 py-4 text-center">Diskon</th>
                    <th class="px-4 py-4 text-center">Qty</th>
                    <th class="px-4 py-4 text-right">Total</th>
                    <th class="px-4 py-4 text-right">DP</th>
                    <th class="px-4 py-4">Pembayaran</th>
                    <th class="px-4 py-4">Jatuh Tempo</th>
                    <th class="px-4 py-4">Update</th>
                    <th class="px-4 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @for($i=1; $i<=5; $i++)
                <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $i * 100 }}">
                    <td class="px-4 py-4 font-medium text-gray-700">PB-0000001</td>
                    <td class="px-4 py-4">BLP000000000</td>
                    <td class="px-4 py-4">2026-01-01</td>
                    <td class="px-4 py-4 font-medium">Valoza Store</td>
                    <td class="px-4 py-4">
                        <span class="bg-[#10B981] text-white px-3 py-1 rounded-md font-semibold text-xs shadow-sm">0800000000</span>
                    </td>
                    <td class="px-4 py-4">BNI</td>
                    <td class="px-4 py-4">00009090909</td>
                    <td class="px-4 py-4 text-center">0</td>
                    <td class="px-4 py-4 text-center font-medium">98</td>
                    <td class="px-4 py-4 text-right font-bold text-gray-800">17500</td>
                    <td class="px-4 py-4 text-right font-bold text-gray-800">17500</td>
                    <td class="px-4 py-4">Cash</td>
                    <td class="px-4 py-4 text-gray-500">2026-01-01</td>
                    <td class="px-4 py-4 text-gray-500">Sudah Transfer</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <button @click="modalDetail = true" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Detail">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                            <button @click="modalEdit = true" class="bg-[#10B981] hover:bg-[#059669] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <button @click="modalHapus = true" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white w-7 h-7 rounded flex items-center justify-center shadow-sm transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash-can text-xs"></i>
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
                <h3 class="text-xl font-bold text-gray-800">Detail Faktur: BLP000000000</h3>
                <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div><p class="text-gray-500 mb-1">Supplier</p><p class="font-bold text-gray-800">Valoza Store</p></div>
                    <div><p class="text-gray-500 mb-1">Kode Pembelian</p><p class="font-bold text-gray-800">PB-0000001</p></div>
                    <div><p class="text-gray-500 mb-1">Tgl Faktur</p><p class="font-bold text-gray-800">01 Jan 2026</p></div>
                    <div><p class="text-gray-500 mb-1">Status Pembayaran</p><p class="font-bold text-[#10B981]">Cash (Lunas)</p></div>
                </div>

                <div class="flex justify-between items-center bg-orange-50 p-4 rounded-xl border border-orange-100">
                    <span class="text-gray-600 font-bold">Total Nilai Pembelian:</span>
                    <span class="text-2xl font-black text-[#E65C00]">Rp 17.500</span>
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
                <h3 class="text-xl font-bold text-gray-800">Update Status Pembelian</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Bayar</label>
                        <select class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="Cash" selected>Cash</option>
                            <option value="Kredit">Kredit (Hutang)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telah Dibayar (DP)</label>
                        <input type="number" value="17500" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jatuh Tempo</label>
                        <input type="date" value="2026-01-01" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Update</label>
                        <select class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="Sudah Transfer" selected>Sudah Transfer</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#10B981] hover:bg-[#059669] text-white font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">Simpan Update</button>
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
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus riwayat pembelian ini? Stok barang yang sudah masuk dari faktur ini akan dikurangi secara otomatis.</p>
            
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