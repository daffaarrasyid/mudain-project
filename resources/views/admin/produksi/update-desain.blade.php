@extends('admin.layouts.app')

@section('content')

    <div x-data="desainApp()"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span></div>
                <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
                <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Gagal
                    Menyimpan!</div>
                <ul class="list-disc list-inside text-sm ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Desain Pesanan</h2>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" id="searchInput" placeholder="Cari Invoice / Nama..."
                        class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-[#E65C00] transition-colors">
                    <button
                        class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200]">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Telp/WA</th>
                        <th class="px-6 py-4">Nama Desainer</th>
                        <th class="px-6 py-4">Judul Desain</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Gambar Desain</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <template x-for="(des, index) in desains" :key="des.id">
                        <tr
                            class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up">
                            <td class="px-6 py-6 font-bold text-[#E65C00] align-middle" x-text="des.invoice"></td>
                            <td class="px-6 py-6 font-bold align-middle" x-text="des.customer?.nama_customer || 'Umum'">
                            </td>
                            <td class="px-6 py-6 align-middle" x-text="des.customer?.no_telp || '-'"></td>
                            <td class="px-6 py-6 align-middle font-medium" x-text="des.nama_desainer || 'Belum Diatur'">
                            </td>
                            <td class="px-6 py-6 align-middle font-medium text-gray-800" x-text="des.judul_desain || '-'">
                            </td>
                            <td class="px-6 py-6 align-middle italic text-xs" x-text="des.keterangan_desain || '-'"></td>

                            <td class="px-6 py-6 align-middle text-center">
                                <div x-show="des.gambar_desain"
                                    class="w-24 h-24 mx-auto rounded-xl overflow-hidden shadow-sm border border-gray-200 cursor-pointer group relative">
                                    <img :src="'/storage/desain/' + des.gambar_desain" alt="Desain"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <a :href="'/storage/desain/' + des.gambar_desain" target="_blank"
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <i class="fa-solid fa-expand text-white text-xl"></i>
                                    </a>
                                </div>
                                <div x-show="!des.gambar_desain"
                                    class="text-xs font-bold text-red-500 bg-red-50 py-2 rounded-lg border border-red-100">
                                    Belum Upload
                                </div>
                            </td>

                            <td class="px-6 py-6 align-middle text-center">
                                <div class="flex flex-col gap-2 items-center justify-center">
                                    <button @click="openUpdate(index)"
                                        class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                        <span x-text="des.gambar_desain ? 'Edit' : 'Upload'"></span>
                                    </button>
                                    <button x-show="des.gambar_desain" @click="openHapus(index)"
                                        class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-4 py-1.5 rounded w-20 text-xs font-semibold shadow-sm transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="desains.length === 0">
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data pesanan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan <span class="font-bold text-gray-700">{{ $desains->firstItem() ?? 0 }}</span> sampai <span
                    class="font-bold text-gray-700">{{ $desains->lastItem() ?? 0 }}</span> dari <span
                    class="font-bold text-[#E65C00]">{{ $desains->total() }}</span> invoice</div>
            <div class="flex items-center gap-2 text-sm">
                {{ $desains->links('pagination::tailwind') }}
            </div>
        </div>

        <div x-show="modalUpdate" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition.opacity>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto"
                @click.away="modalUpdate = false" x-transition>

                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Update Informasi Desain</h3>
                    <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-xs mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form :action="`/admin/produksi/${activeData.id}/simpan-desain`" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4">
                        <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Customer:</span><span
                                class="font-bold text-gray-800"
                                x-text="activeData.customer?.nama_customer || 'Umum'"></span></div>
                        <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Invoice:</span><span
                                class="font-bold text-gray-800" x-text="activeData.invoice"></span></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Desain / Pesanan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="judul_desain" x-model="inputJudul" required
                            placeholder="Cth: Baju Angkatan 2026"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Desainer <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_desainer" x-model="inputDesainer" required
                            placeholder="Cth: Mas Yusup"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Khusus</label>
                        <textarea name="keterangan_desain" x-model="inputKeterangan" rows="2"
                            placeholder="Cth: Warna sablon agak digelapin dikit"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Desain
                            (Opsional/Jpg/Png)</label>
                        <input type="file" name="gambar_desain" accept="image/*"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#E65C00]/10 file:text-[#E65C00] hover:file:bg-[#E65C00]/20">
                        <p x-show="activeData.gambar_desain" class="text-xs text-red-500 mt-1">*Abaikan jika tidak ingin
                            mengganti gambar lama.</p>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" @click="modalUpdate = false"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Simpan
                            Desain</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalHapus" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition.opacity>
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center m-auto"
                @click.away="modalHapus = false" x-transition>

                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus File Desain?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus gambar dan data desainer untuk invoice <span
                        class="font-bold text-gray-800" x-text="activeData.invoice"></span>? File gambar akan dihapus
                    permanen dari server.</p>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button @click="modalHapus = false"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <form :action="`/admin/produksi/${activeData.id}/hapus-desain`" method="POST"
                        class="w-full sm:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya,
                            Hapus Gambar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function desainApp() {
            return {
                modalUpdate: false,
                modalHapus: false,

                desains: @json($desains->items()),
                activeData: {},

                // Form state
                inputJudul: '',
                inputDesainer: '',
                inputKeterangan: '',

                openUpdate(index) {
                    this.activeData = {
                        ...this.desains[index]
                    };
                    this.inputJudul = this.activeData.judul_desain || '';
                    this.inputDesainer = this.activeData.nama_desainer || '';
                    this.inputKeterangan = this.activeData.keterangan_desain || '';
                    this.modalUpdate = true;
                },

                openHapus(index) {
                    this.activeData = {
                        ...this.desains[index]
                    };
                    this.modalHapus = true;
                }
            }
        }

        // Client-side search tabel
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.data-row');

            searchInput.addEventListener('input', function(e) {
                const keyword = e.target.value.toLowerCase();
                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(keyword) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
