@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
    .card-animasi-2 { animation: slideUpFade 0.8s ease-out 0.3s both; }
    .card-animasi-3 { animation: slideUpFade 0.8s ease-out 0.5s both; }
    .card-animasi-4 { animation: slideUpFade 0.8s ease-out 0.7s both; }
</style>

<div x-data="{ modalEdit: false, modalHapus: false }" class="space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="card-animasi-1 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pembelian</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <label class="w-1/3 text-sm font-bold text-gray-700">Tanggal Faktur</label>
                    <input type="date" class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                </div>
                <div class="flex items-center">
                    <label class="w-1/3 text-sm font-bold text-gray-700">Nomor Faktur</label>
                    <input type="text" value="Digenerate otomatis" readonly class="w-2/3 bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg px-3 py-2.5 cursor-not-allowed outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center space-y-4">
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Supplier</label>
                <div class="w-2/3 flex">
                    <input type="text" class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-l-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none border-r-0">
                    <button class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-4 rounded-r-lg transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Operator</label>
                <input type="text" value="Administrator" readonly class="w-2/3 bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg px-3 py-2.5 cursor-not-allowed outline-none">
            </div>
        </div>
    </div>

    <div class="card-animasi-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Barcode</label>
                <div class="w-3/4 flex">
                    <input type="text" class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-l-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none border-r-0">
                    <button class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-4 rounded-r-lg transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Nama</label>
                <input type="text" class="w-3/4 bg-gray-100 border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 outline-none cursor-not-allowed" readonly placeholder="Terisi otomatis">
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Qty</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4 relative pb-16">
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Harga Beli</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Harga Jual</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
            
            <div class="absolute bottom-4 right-6">
                <button class="bg-[#10B981] hover:bg-[#059669] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="card-animasi-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0">
        
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span>Tampilkan</span>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-1.5 px-3 cursor-pointer">
                    <option>10</option><option>25</option><option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari" class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2 focus:outline-none focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200]">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-4 px-4">Barcode</th>
                        <th class="py-4 px-4">Nama Item</th>
                        <th class="py-4 px-4">Harga Beli</th>
                        <th class="py-4 px-4">Harga Jual</th>
                        <th class="py-4 px-4 text-center">Qty</th>
                        <th class="py-4 px-4">Total</th>
                        <th class="py-4 px-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-50 bg-gray-50/50 hover:bg-orange-50/40 transition-colors duration-200">
                        <td class="py-4 px-4 font-medium text-gray-700">PN/BRS01</td>
                        <td class="py-4 px-4">Pin Bros</td>
                        <td class="py-4 px-4">Rp 875</td>
                        <td class="py-4 px-4">Rp 2.000</td>
                        <td class="py-4 px-4 text-center font-bold">10</td>
                        <td class="py-4 px-4 font-bold text-gray-800">Rp 8.750</td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex flex-col gap-1 items-center justify-center">
                                <button @click="modalEdit = true" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-3 py-1 rounded w-16 text-xs font-semibold shadow-sm transition-colors">Edit</button>
                                <button @click="modalHapus = true" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-3 py-1 rounded w-16 text-xs font-semibold shadow-sm transition-colors">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan 1 sampai 1 dari 1 data</div>
            <div class="flex items-center gap-1 text-sm">
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">1</button>
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100">2</button>
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100">3</button>
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            </div>
        </div>
    </div>

    <div class="card-animasi-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <div class="flex items-center mb-3">
                <label class="w-1/4 text-sm font-bold text-gray-800">Diskon</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-3 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
            <p class="text-xs text-gray-400 italic">
                Note: Diskon di sini merupakan diskon keseluruhan dari pembelian. Jika diskon di nota adalah diskon per satuan, maka harap dijumlahkan secara keseluruhan.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-3xl font-bold text-gray-700">Total (Rp)</h2>
                <h1 class="text-5xl font-black text-gray-800">8750</h1>
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
                    Batal
                </button>
                <button class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <div x-show="modalEdit" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 m-auto" @click.away="modalEdit = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800">Edit Item: Pin Bros</h3>
                <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp)</label>
                    <input type="number" value="875" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp)</label>
                    <input type="number" value="2000" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" value="10" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-[#E65C00]">
                </div>
                
                <div class="flex justify-end gap-2 mt-5 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalEdit = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#38BDF8] hover:bg-[#0284C7] text-white text-sm font-medium rounded-lg shadow-sm">Simpan Edit</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                <i class="fa-solid fa-trash text-2xl text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Hapus Item?</h3>
            <p class="text-sm text-gray-500 mb-5">Keluarkan "Pin Bros" dari daftar pembelian?</p>
            
            <div class="flex justify-center gap-2">
                <button @click="modalHapus = false" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg">Batal</button>
                <form action="#" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection