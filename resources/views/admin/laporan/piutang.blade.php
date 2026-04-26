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

<div class="max-w-5xl mx-auto space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Piutang</h2>
    </div>

    <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        <form action="#" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Awal</label>
                    <input type="date" required 
                           class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" required 
                           class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis</label>
                <div class="relative">
                    <select required 
                            class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        <option value="Semua" selected>Semua Supplier</option>
                        <option value="Masuk">Supplier A</option>
                        <option value="Keluar">Supplier B</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-8 bg-[#FF0000] hover:bg-[#CC0000] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </button>

        </form>

    </div>

</div>
@endsection