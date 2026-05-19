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

<div class="max-w-5xl mx-auto space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Barang</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between min-h-[250px] transition-transform hover:-translate-y-1 duration-300">
            <div>
                <p class="text-gray-700 font-medium text-lg leading-relaxed">
                    Pilih menu ini jika ingin mengexport semua data produk di toko anda
                </p>
            </div>
            
            <a href="{{ route('admin.laporan.barang.export') }}" class="w-full mt-8 bg-[#10B981] hover:bg-[#059669] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all flex items-center justify-center gap-2 text-lg">
                <i class="fa-solid fa-file-export"></i> Export Semua Data
            </a>
        </div>

        <div class="card-animasi-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between min-h-[250px] transition-transform hover:-translate-y-1 duration-300">
            <form action="{{ route('admin.laporan.barang.export') }}" method="GET" class="flex flex-col h-full justify-between">
                <div class="space-y-4">
                    <p class="text-gray-700 font-medium text-lg">
                        Export data berdasarkan Supplier
                    </p>
                    
                    <div class="relative">
                        <select name="supplier_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-base rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Supplier</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full mt-8 bg-[#10B981] hover:bg-[#059669] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all flex items-center justify-center gap-2 text-lg">
                    <i class="fa-solid fa-file-export"></i> Export Data Supplier
                </button>
            </form>
        </div>

    </div>

</div>
@endsection