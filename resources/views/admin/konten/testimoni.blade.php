@extends('admin.layouts.app')

@section('content')

    <div x-data="{ modalTambah: false, modalEdit: false, modalHapus: false }"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Testimoni </h2>
                <button @click="modalTambah = true"
                    class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Tambah Testimoni
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
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4 w-20">Profil</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Status/Jabatan</th>
                        <th class="px-6 py-4 text-center">Rating</th>
                        <th class="px-6 py-4">Testimoni</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr class="border-b border-gray-50 hover:bg-orange-50/40 transition-colors">
                        <td class="px-6 py-4">
                            <div
                                class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xl border-2 border-white shadow-sm">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">Budi Santoso</td>
                        <td class="px-6 py-4 text-gray-500">Ketua OSIS SMAN 1</td>
                        <td class="px-6 py-4 text-center text-gray-500 text-s">
                            <i class="fa-solid fa-star text-yellow-400"></i> 5
                        </td>
                        <td class="px-6 py-4">
                            <p class="truncate max-w-[250px] italic text-gray-500">"Hasil jahitan rapi banget, mantap
                                deh pokoknya!"</p>
                        </td>
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
                    <h3 class="text-xl font-bold text-gray-800">Tambah Testimoni</h3><button @click="modalTambah = false"
                        class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gray-100 rounded-full flex shrink-0 items-center justify-center text-gray-400 text-2xl border border-gray-200">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil (Opsional)</label>
                            <input type="file" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                        </div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label><input
                            type="text" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Status / Jabatan</label><input
                            type="text" placeholder="Cth: Mahasiswa, CEO..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div x-data="{ rating: 5, hoverRating: 0 }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating Kepuasan</label>
                        <div class="flex gap-2">
                            <template x-for="i in 5">
                                <button type="button" @click="rating = i" @mouseenter="hoverRating = i"
                                    @mouseleave="hoverRating = 0"
                                    class="text-3xl transition-colors duration-150 focus:outline-none"
                                    :class="(hoverRating >= i || (!hoverRating && rating >= i)) ?
                                    'text-yellow-400 scale-110' : 'text-gray-300'">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="rating" :value="rating">
                    </div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Isi Testimoni</label>
                        <textarea rows="3" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
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
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 m-auto"
                @click.away="modalEdit = false" x-transition>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Edit Testimoni</h3><button @click="modalEdit = false"
                        class="text-gray-400"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gray-100 rounded-full flex shrink-0 items-center justify-center text-gray-400 text-2xl border border-gray-200">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Profil
                                (Opsional)</label>
                            <input type="file" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#E65C00] hover:file:bg-orange-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50 outline-none">
                        </div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label><input
                            type="text" value="Budi Santoso"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Status / Jabatan</label><input
                            type="text" value="Ketua OSIS SMAN 1"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>

                    <div x-data="{ rating: 5, hoverRating: 0 }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating Kepuasan</label>
                        <div class="flex gap-2">
                            <template x-for="i in 5">
                                <button type="button" @click="rating = i" @mouseenter="hoverRating = i"
                                    @mouseleave="hoverRating = 0"
                                    class="text-3xl transition-colors duration-150 focus:outline-none"
                                    :class="(hoverRating >= i || (!hoverRating && rating >= i)) ?
                                    'text-yellow-400 scale-110' : 'text-gray-300'"><i
                                        class="fa-solid fa-star"></i></button>
                            </template>
                        </div>
                        <input type="hidden" name="rating" :value="rating">
                    </div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Isi Testimoni</label>
                        <textarea rows="3"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">"Hasil jahitan rapi banget, mantap deh pokoknya!"</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t"><button type="button" @click="modalEdit = false"
                            class="px-5 py-2.5 bg-gray-100 font-medium rounded-xl">Batal</button><button type="submit"
                            class="px-5 py-2.5 bg-[#38BDF8] font-medium text-white shadow-lg shadow-blue-500/30 rounded-xl">Simpan
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
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Testimoni?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus testimoni dari Budi Santoso?</p>
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
