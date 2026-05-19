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

<div x-data="{ modalTambah: false }" class="animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 md:mb-10">Kas</h2>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <h3 class="text-3xl font-medium text-gray-500">Saldo</h3>
            <h1 class="text-4xl md:text-5xl font-black {{ $saldo < 0 ? 'text-red-500' : 'text-[#10B981]' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </h1>
        </div>
    </div>

    <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 w-full min-w-0">
        
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6 pb-6 border-b border-gray-100">
            <button @click="modalTambah = true" class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Kas
            </button>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" placeholder="Cari Riwayat..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                    <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4">Kode Ref</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Kategori / Jenis</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Tipe</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4 text-center">User</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($kas as $index => $item)
                    <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors animate-fade-in-up delay-{{ $index * 100 }}">
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $item->kode_kas }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->jenis }}</td>
                        <td class="px-6 py-4">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->tipe == 'Masuk')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold"><i class="fa-solid fa-arrow-down mr-1"></i>IN</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold"><i class="fa-solid fa-arrow-up mr-1"></i>OUT</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold {{ $item->tipe == 'Masuk' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $item->tipe == 'Masuk' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center italic">{{ $item->user->name ?? 'Sistem' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">Belum ada riwayat arus kas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan <span class="font-bold text-gray-700">{{ $kas->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-gray-700">{{ $kas->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#E65C00]">{{ $kas->total() }}</span> mutasi</div>
            <div class="flex items-center gap-2 text-sm">
                {{ $kas->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div x-show="modalTambah" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalTambah = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Catat Mutasi Kas Manual</h3>
                <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.keuangan.kas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-4">
                    <p class="text-xs text-gray-500 italic">
                        <i class="fa-solid fa-circle-info text-[#E65C00] mr-1"></i> Catatan kas dari modul Penjualan/Pembelian akan masuk ke sini secara otomatis (kalau disinkron). Form ini digunakan untuk penyesuaian kas manual.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Mutasi <span class="text-red-500">*</span></label>
                        <select name="tipe" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                            <option value="Masuk">Pemasukan (In)</option>
                            <option value="Keluar">Pengeluaran (Out)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Jenis <span class="text-red-500">*</span></label>
                        <input type="text" name="jenis" placeholder="Contoh: Modal, Hibah..." required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" min="1" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-lg font-bold">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="2" placeholder="Tulis alasan pencatatan manual..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan Kas</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection