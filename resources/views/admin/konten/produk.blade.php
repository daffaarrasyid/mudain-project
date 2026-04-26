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
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Produk</h2>
                <button @click="modalTambah = true"
                    class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Tambah Produk
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
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4 w-40">Gambar</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">Range Harga</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-50 hover:bg-orange-50/40 transition-colors">
                        <td class="px-6 py-4">
                            <div
                                class="w-28 h-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex items-center justify-center">
                                <i class="fa-solid fa-shirt text-3xl text-gray-400"></i>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">PDH osis sma 1 bandung</td>
                        <td class="px-6 py-4">100.000-150.000</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-1.5 items-center justify-center">
                                <button @click="modalEdit = true"
                                    class="bg-[#38BDF8] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold">Edit</button>
                                <button @click="modalHapus = true"
                                    class="bg-[#EF4444] text-white px-4 py-1 rounded w-16 text-[11px] font-semibold">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan 1 sampai 6 dari 87 data</div>
            <div class="flex gap-1">
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
            x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto"
                @click.away="modalTambah = false" x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Produk</h3><button @click="modalTambah = false"
                        class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                        <input type="file" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label><input
                            type="text"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Minimum</label><input
                                type="number"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Maksimum</label><input
                                type="number"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t"><button type="button" @click="modalTambah = false"
                            class="px-5 py-2.5 bg-gray-100 font-medium rounded-xl">Batal</button><button type="submit"
                            class="px-5 py-2.5 bg-[#E65C00] font-medium text-white rounded-xl">Simpan</button></div>
                </form>
            </div>
        </div>

        <div x-show="modalEdit" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto" @click.away="modalEdit = false"
                x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Produk</h3><button @click="modalEdit = false"
                        class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="#" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Gambar (Opsional)</label>
                        <input type="file" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label><input
                            type="text" value="PDH osis sma 1 bandung"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Minimum</label><input
                                type="number" value="100000"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Maksimum</label><input
                                type="number" value="150000"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t"><button type="button" @click="modalEdit = false"
                            class="px-5 py-2.5 bg-gray-100 font-medium rounded-xl">Batal</button><button type="submit"
                            class="px-5 py-2.5 bg-[#38BDF8] font-medium text-white rounded-xl shadow-lg shadow-blue-500/30">Simpan
                            Update</button></div>
                </form>
            </div>
        </div>

        <div x-show="modalHapus" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
                @click.away="modalHapus = false" x-transition>
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5"><i
                        class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Produk?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus produk ini dari katalog?</p>
                <div class="flex gap-3 justify-center">
                    <button @click="modalHapus = false"
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl">Batal</button>
                    <form action="#" method="POST">@csrf @method('DELETE')<button type="submit"
                            class="px-6 py-2.5 bg-red-500 text-white font-medium rounded-xl shadow-lg shadow-red-500/30">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
