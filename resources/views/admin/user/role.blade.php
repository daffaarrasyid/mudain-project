@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
</style>

    <div x-data="{ modalTambah: false, modalEdit: false, modalHapus: false }"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Manajemen Role</h2>
                <button @click="modalTambah = true"
                    class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Tambah Role
                </button>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Tampilkan</span>
                    <select class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg px-3 py-2 outline-none">
                        <option>10</option>
                    </select>
                </div>
                <div class="relative w-full sm:w-64">
                    <input type="text" placeholder="Cari..."
                        class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00]">
                    <button class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl"><i
                            class="fa-solid fa-search"></i></button>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4 w-10"></th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Izin Akses</th>
                        <th class="px-6 py-4">Updated at</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-50 bg-gray-50/50 hover:bg-orange-50/40 transition-colors">
                        <td class="px-6 py-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox"
                                    class="form-checkbox h-4 w-4 text-[#E65C00] border-gray-300 rounded focus:ring-[#E65C00]" />
                            </label>
                        </td>
                        <td class="px-6 py-5">
                            <span class="bg-[#F59E0B] text-white px-3 py-1.5 rounded-md font-bold text-xs shadow-sm">Super
                                Admin</span>
                        </td>
                        <td class="px-6 py-5 font-medium">78</td>
                        <td class="px-6 py-5 text-gray-500">Apr 21, 2026 11:25</td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col gap-1.5 items-center justify-center">
                                <button @click="modalEdit = true"
                                    class="bg-[#38BDF8] text-white px-4 py-1 rounded w-16 text-xs font-semibold">Edit</button>
                                <button @click="modalHapus = true"
                                    class="bg-[#EF4444] text-white px-4 py-1 rounded w-16 text-xs font-semibold">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan 1 sampai 10 dari 20 data</div>
            <div class="flex items-center gap-2 text-sm">
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100 transition-colors"><i
                        class="fa-solid fa-chevron-left text-xs"></i></button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">1</button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">2</button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">3</button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">4</button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">5</button>
                <button
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 hover:bg-gray-100 transition-colors"><i
                        class="fa-solid fa-chevron-right text-xs"></i></button>
            </div>
        </div>

        <div x-show="modalTambah" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto"
                @click.away="modalTambah = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Role Baru</h3>
                    <button @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role <span
                                class="text-red-500">*</span></label>
                        <input type="text" placeholder="Contoh: Kasir, Staff Produksi..." required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Izin Akses Modul</label>
                        <div
                            class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-48 overflow-y-auto space-y-2 custom-scrollbar">
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Dashboard Utama</span></label>
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Master Data (Barang, Kategori, dll)</span></label>
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Transaksi (Kasir POS)</span></label>
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Produksi & Desain</span></label>
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Laporan Keuangan & Kas</span></label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button type="button" @click="modalTambah = false"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-[#E65C00] hover:bg-[#cc5200] text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/30">Simpan
                            Role</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalEdit" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto"
                @click.away="modalEdit = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Edit Role & Izin Akses</h3>
                    <button @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role <span
                                class="text-red-500">*</span></label>
                        <input type="text" value="Super Admin" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Izin Akses Modul</label>
                        <div
                            class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-48 overflow-y-auto space-y-2 custom-scrollbar">
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" checked
                                    class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm font-semibold text-gray-800">Semua Akses (Full Access)</span></label>
                            <hr class="border-gray-200 my-2">
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" checked
                                    class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Transaksi (Kasir POS)</span></label>
                            <label
                                class="flex items-center gap-3 cursor-pointer p-2 hover:bg-white rounded transition-colors"><input
                                    type="checkbox" checked
                                    class="w-4 h-4 text-[#E65C00] focus:ring-[#E65C00] rounded"><span
                                    class="text-sm text-gray-700">Laporan Keuangan</span></label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button type="button" @click="modalEdit = false"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalHapus" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
                @click.away="modalHapus = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Role?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus role <b>Super Admin</b>? Akun yang menggunakan
                    role ini mungkin akan kehilangan akses sistem.</p>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button @click="modalHapus = false"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <form action="#" method="POST" class="w-full sm:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya,
                            Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
