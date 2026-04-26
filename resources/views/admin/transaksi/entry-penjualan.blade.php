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
    .card-animasi-5 { animation: slideUpFade 0.8s ease-out 0.9s both; }
</style>

<div class="space-y-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Penjualan</h2>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800">Invoice <span class="font-normal text-gray-500">BLP000000000</span></p>
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-end mt-10">
            <h3 class="text-3xl font-bold text-gray-700 mb-2 md:mb-0">Total (Rp)</h3>
            <h1 class="text-5xl md:text-6xl font-black text-gray-800">3.400.000</h1>
        </div>
    </div>

    <div class="card-animasi-2 grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Operator</label>
                <input type="text" value="Administrator" readonly class="w-2/3 bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg px-3 py-2 cursor-not-allowed outline-none">
            </div>
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Customer</label>
                <select class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                    <option value="">Pilih Customer</option>
                    <option value="1">Family HM</option>
                </select>
            </div>
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Layanan</label>
                <select class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                    <option value="">Pilih Layanan</option>
                    <option value="1">Produk</option>
                    <option value="2">Service</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Barcode</label>
                <div class="w-3/4 flex">
                    <input type="text" class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-l-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none border-r-0">
                    <button class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-4 rounded-r-lg transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Qty</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4 relative">
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Nama</label>
                <input type="text" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Harga</label>
                <input type="number" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
            <div class="flex items-center mb-10">
                <label class="w-1/4 text-sm font-bold text-gray-700">Total</label>
                <input type="text" value="Rp 0" readonly class="w-3/4 bg-gray-100 border border-gray-200 text-gray-400 text-sm font-bold rounded-lg px-3 py-2 outline-none cursor-not-allowed">
            </div>
            <div class="flex items-end justify-end right-6">
                <button class="bg-[#10B981] hover:bg-[#059669] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-colors">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="card-animasi-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Produk</h3>
        <div class="w-full overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-3 px-2">Barcode</th>
                        <th class="py-3 px-2">Nama Item</th>
                        <th class="py-3 px-2">Harga Umum</th>
                        <th class="py-3 px-2">Harga Pelanggan</th>
                        <th class="py-3 px-2">Qty</th>
                        <th class="py-3 px-2">Disc/Item</th>
                        <th class="py-3 px-2">Total</th>
                        <th class="py-3 px-2 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-100 h-12">
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-animasi-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Service</h3>
        <div class="w-full overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-3 px-2">Kode</th>
                        <th class="py-3 px-2">Nama Service</th>
                        <th class="py-3 px-2 text-center">Pegawai</th>
                        <th class="py-3 px-2">Harga</th>
                        <th class="py-3 px-2">Total</th>
                        <th class="py-3 px-2 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-100 h-12">
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-animasi-5 flex justify-end gap-4 pb-8">
        <button class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
            Cancel
        </button>
        <button class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
            Payment
        </button>
    </div>

</div>
@endsection