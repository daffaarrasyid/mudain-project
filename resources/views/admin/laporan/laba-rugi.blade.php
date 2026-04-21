@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Laba Rugi</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
            
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <h3 class="text-center text-lg font-bold text-gray-700 mb-6">Laporan Laba Kotor</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Awal</label>
                        <input type="date" required 
                               class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Akhir</label>
                        <input type="date" required 
                               class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                    </div>
                </div>
                
                <button type="submit" class="w-full mt-4 bg-[#10B981] hover:bg-[#059669] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all flex items-center justify-center gap-2 text-base">
                    <i class="fa-solid fa-file-export"></i> Export Data
                </button>
            </form>
            
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
            
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <h3 class="text-center text-lg font-bold text-gray-700 mb-6">Laporan Laba Bersih</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Awal</label>
                        <input type="date" required 
                               class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Akhir</label>
                        <input type="date" required 
                               class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                    </div>
                </div>
                
                <button type="submit" class="w-full mt-4 bg-[#10B981] hover:bg-[#059669] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all flex items-center justify-center gap-2 text-base">
                    <i class="fa-solid fa-file-export"></i> Export Data
                </button>
            </form>

        </div>

    </div>

</div>
@endsection