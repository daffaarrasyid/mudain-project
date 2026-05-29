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

    <div class="max-w-6xl mx-auto space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        @if ($errors->any())
        <div class="card-animasi-1 bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-2xl shadow-sm">
            <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Gagal Export!</div>
            <ul class="list-disc list-inside text-sm ml-5">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-800">Laporan Kas</h2>
        </div>

        <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

            <form action="{{ route('admin.laporan.kas.export') }}" method="POST" target="_blank" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Awal</label>
                        <div class="relative">
                            <input type="date" name="tanggal_awal" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Akhir</label>
                        <div class="relative">
                            <input type="date" name="tanggal_akhir" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#FF0000] hover:bg-[#CC0000] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </button>
            </form>

        </div>

        <div class="card-animasi-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-800">Laporan Laba Rugi</h2>
        </div>

        <div class="card-animasi-4 grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <form action="{{ route('admin.laporan.laba-kotor.export') }}" method="POST" target="_blank" class="space-y-6">
                    @csrf
                    <h3 class="text-center text-lg font-bold text-gray-700 mb-6">Laporan Laba Kotor</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-4 bg-[#FF0000] hover:bg-[#CC0000] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-500/30 transition-all flex items-center justify-center gap-2 text-base">
                        <i class="fa-solid fa-file-pdf"></i> Export PDF
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <form action="{{ route('admin.laporan.laba-bersih.export') }}" method="POST" target="_blank" class="space-y-6">
                    @csrf
                    <h3 class="text-center text-lg font-bold text-gray-700 mb-6">Laporan Laba Bersih</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" required class="w-full bg-gray-50 border border-transparent text-gray-700 text-sm rounded-xl px-4 py-3.5 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 transition-all outline-none cursor-pointer appearance-none">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-4 bg-[#FF0000] hover:bg-[#CC0000] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-500/30 transition-all flex items-center justify-center gap-2 text-base">
                        <i class="fa-solid fa-file-pdf"></i> Export PDF
                    </button>
                </form>
            </div>

        </div>

    </div>
@endsection