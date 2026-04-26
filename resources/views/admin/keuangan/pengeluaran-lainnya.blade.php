@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
</style>

<div class="animate-[fadeIn_0.5s_ease-in-out] w-full max-w-4xl mx-auto min-w-0">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
        
        <h2 class="text-2xl font-bold text-gray-800">Pengeluaran Lainnya</h2>
        
        <hr class="border-gray-100 my-6">

        <form action="#" method="POST" class="space-y-6">
            @csrf
            
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Jenis</label>
                <div class="w-full md:w-3/4">
                    <input type="text" name="jenis" required 
                           class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300">
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Nominal</label>
                <div class="w-full md:w-3/4">
                    <input type="number" min="0" name="nominal" required 
                           class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300">
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Status</label>
                <div class="w-full md:w-3/4">
                    <select name="status" required 
                            class="w-full bg-gray-100 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300 appearance-none cursor-pointer">
                        <option value="" disabled selected></option>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <button type="button" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-xl font-bold shadow-md shadow-red-500/20 transition-all transform hover:-translate-y-0.5">
                    Batal
                </button>
                <button type="submit" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-8 py-2.5 rounded-xl font-bold shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection