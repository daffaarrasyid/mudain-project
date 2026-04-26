@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
</style>
<div x-data="{ modalUpdate: false, modalHapus: false }" 
     class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Desain Bisnis</h2>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                <span>Tampilkan</span>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] outline-none py-2 px-3 cursor-pointer">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari" class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
            <thead>
                <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                    <th class="px-6 py-4">No.</th>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Nama Customer</th>
                    <th class="px-6 py-4">Telp/WA Customer</th>
                    <th class="px-6 py-4">Nama Desainer</th>
                    <th class="px-6 py-4">Judul Desain</th>
                    <th class="px-6 py-4">Keterangan Desain</th>
                    <th class="px-6 py-4 text-center">Gambar Desain</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @for($i=1; $i<=2; $i++)
                <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $i * 100 }}">
                    <td class="px-6 py-6 font-medium align-middle">{{ $i }}</td>
                    <td class="px-6 py-6 align-middle">BLP-938593859</td>
                    <td class="px-6 py-6 align-middle">Asep</td>
                    <td class="px-6 py-6 align-middle">08746353750</td>
                    <td class="px-6 py-6 align-middle">Yusup</td>
                    <td class="px-6 py-6 align-middle font-medium text-gray-800">Baju Wearpack</td>
                    <td class="px-6 py-6 align-middle">Jahit</td>
                    <td class="px-6 py-6 align-middle text-center">
                        <div class="w-32 h-40 md:w-40 md:h-48 mx-auto rounded-xl overflow-hidden shadow-sm border border-gray-200 cursor-pointer group relative">
                            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=300&auto=format&fit=crop" alt="Desain Baju" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <i class="fa-solid fa-expand text-white text-xl"></i>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6 align-middle text-center">
                        <div class="flex flex-col gap-2 items-center justify-center">
                            <button @click="modalUpdate = true" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Update
                            </button>
                            <button @click="modalHapus = true" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                Hapus
                            </button>
                        </div>
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

    <div x-show="modalUpdate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalUpdate = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Update Informasi Desain</h3>
                <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4">
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Customer:</span><span class="font-bold text-gray-800">Asep</span></div>
                    <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Invoice:</span><span class="font-bold text-gray-800">BLP-938593859</span></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Desain</label>
                    <input type="text" value="Baju Wearpack" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Desainer</label>
                    <input type="text" value="Yusup" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Progress</label>
                    <textarea rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">Jahit</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ulang File Desain (Opsional)</label>
                    <input type="file" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#E65C00]/10 file:text-[#E65C00] hover:file:bg-[#E65C00]/20">
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="modalUpdate = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Simpan Update</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modalHapus" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalHapus = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus File Desain?</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus desain pesanan ini? File gambar tidak akan dapat dikembalikan.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalHapus = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                <form action="#" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection