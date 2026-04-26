@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
    .card-animasi-2 { animation: slideUpFade 0.8s ease-out 0.3s both; }
</style>

<div class="space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Generate Barcode</h2>
        
        <div class="space-y-4 w-full mx-auto mb-8">
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/6 text-sm font-bold text-gray-700 md:text-right">Kode</label>
                <div class="w-full md:w-5/6">
                    <input type="text" class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 outline-none transition-all">
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/6 text-sm font-bold text-gray-700 md:text-right leading-tight">BarcodeID<br>(EAN13)</label>
                <div class="w-full md:w-5/6">
                    <input type="text" class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 outline-none transition-all">
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/6 text-sm font-bold text-gray-700 md:text-right">Nama Item</label>
                <div class="w-full md:w-5/6">
                    <input type="text" class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full mx-auto">
            <button class="bg-[#10B981] hover:bg-[#059669] text-white py-3.5 rounded-xl font-bold shadow-md shadow-green-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
            <button class="bg-[#38BDF8] hover:bg-[#0284C7] text-white py-3.5 rounded-xl font-bold shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <i class="fa-solid fa-barcode"></i> Generate
            </button>
            <button class="bg-[#F59E0B] hover:bg-[#D97706] text-white py-3.5 rounded-xl font-bold shadow-md shadow-amber-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <i class="fa-solid fa-rotate"></i> Update Barcode
            </button>
        </div>
    </div>

    <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full min-w-0">
        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4">Kode Item</th>
                        <th class="px-6 py-4">Barcode</th>
                        <th class="px-6 py-4">Nama Item</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @for($i=1; $i<=5; $i++)
                    <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors animate-fade-in-up delay-{{ $i * 100 }}">
                        <td class="px-6 py-5 font-medium text-gray-700">BRG-00003</td>
                        <td class="px-6 py-5">B98t693iag</td>
                        <td class="px-6 py-5">PDH 2 in 1</td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-[#10B981] hover:text-[#059669] transition-colors text-xl">
                                <i class="fa-solid fa-square-check"></i>
                            </button>
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
    </div>

</div>
@endsection