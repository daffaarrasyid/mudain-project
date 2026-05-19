@extends('admin.layouts.app')

@section('content')

    <style>
        @keyframes slideUpFade {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-animasi-1 {
            animation: slideUpFade 0.8s ease-out 0.1s both;
        }
    </style>

    <div class="animate-[fadeIn_0.5s_ease-in-out] w-full max-w-4xl mx-auto min-w-0">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span></div>
                <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
                <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Gagal
                    Menyimpan!</div>
                <ul class="list-disc list-inside text-sm ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">

            <h2 class="text-2xl font-bold text-gray-800">Pengeluaran Lainnya</h2>
            <p class="text-sm text-gray-500 mt-1">Catat biaya operasional seperti tagihan listrik, internet, gaji, dll.</p>

            <hr class="border-gray-100 my-6">

            <form action="{{ route('admin.keuangan.pengeluaran-lainnya.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                    <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Jenis Pengeluaran <span
                            class="text-red-500">*</span></label>
                    <div class="w-full md:w-3/4">
                        <input type="text" name="jenis" placeholder="Contoh: Tagihan Listrik, Internet..." required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                    <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Nominal (Rp) <span
                            class="text-red-500">*</span></label>
                    <div class="w-full md:w-3/4 relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-bold">Rp</span>
                        <input type="number" min="1" name="nominal" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                    <label class="w-full md:w-1/4 text-sm font-bold text-gray-700 md:text-right">Status Bayar <span
                            class="text-red-500">*</span></label>
                    <div class="w-full md:w-3/4">
                        <select name="status" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl px-4 py-3 focus:bg-white focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20 focus:outline-none transition-all duration-300 cursor-pointer">
                            <option value="Lunas" selected>Lunas (Sudah Dibayar)</option>
                            <option value="Belum Lunas">Belum Lunas (Masih Hutang)</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-10 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.keuangan.kas') }}"
                        class="inline-flex items-center justify-center bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-xl font-bold shadow-md shadow-red-500/20 transition-all transform hover:-translate-y-0.5">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-8 py-2.5 rounded-xl font-bold shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                        Simpan Pengeluaran
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
