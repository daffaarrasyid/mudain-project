@extends('admin.layouts.app')

@section('content')
    <div x-data="produksiApp()"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span></div>
                <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Update Produksi</h2>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Tampilkan</span>
                    <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
                <div class="relative flex-1 md:w-64">
                    <input type="text" id="searchInput" placeholder="Cari Invoice / Barang..."
                        class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
                    <button
                        class="absolute right-0 top-0 h-full w-10 text-white bg-[#E65C00] rounded-r-xl flex items-center justify-center hover:bg-[#cc5200] transition-colors">
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
                        <th class="px-6 py-4">Nama Barang/Jasa</th>
                        <th class="px-6 py-4 text-center">Qty</th>
                        <th class="px-6 py-4">Waktu Update</th>
                        <th class="px-6 py-4">Tahap Produksi</th>
                        <th class="px-6 py-4">Update by</th>
                        <th class="px-6 py-4 text-center">Persentase</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <template x-for="(prod, index) in produksis" :key="prod.id">
                        <tr
                            class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up">
                            <td class="px-6 py-4 font-medium" x-text="index + 1"></td>
                            <td class="px-6 py-4 font-bold text-[#E65C00]" x-text="prod.penjualan?.invoice"></td>
                            <td class="px-6 py-4 font-bold text-gray-800"
                                x-text="prod.produk?.nama_item || prod.servis?.nama_servis || 'Item Terhapus'"></td>
                            <td class="px-6 py-4 text-center font-bold" x-text="prod.qty"></td>
                            <td class="px-6 py-4" x-text="formatTanggalJam(prod.updated_at)"></td>
                            <td class="px-6 py-4 font-semibold text-gray-700" x-text="prod.tahap_produksi"></td>
                            <td class="px-6 py-4 italic" x-text="prod.operator?.name || '-'"></td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-md text-xs font-bold"
                                    :class="{
                                        'bg-green-100 text-green-700': prod.progress == 100,
                                        'bg-blue-100 text-blue-700': prod.progress > 0 && prod.progress < 100,
                                        'bg-gray-100 text-gray-500': prod.progress == 0
                                    }"
                                    x-text="prod.progress + '%'"></span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-1.5 items-center justify-center w-[80px] mx-auto">
                                    <button x-show="prod.progress < 100" @click="openUpdate(index)"
                                        class="w-full bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                        Update
                                    </button>
                                    <button x-show="prod.progress > 0" @click="openHapus(index)"
                                        class="w-full bg-[#EF4444] hover:bg-[#B91C1C] text-white px-2 py-1.5 rounded text-[11px] font-semibold shadow-sm transition-colors flex items-center justify-center gap-1"
                                        title="Reset ke 0%">
                                        Hapus
                                    </button>
                                    <span x-show="prod.progress == 100" class="text-xs font-bold text-green-600"><i
                                            class="fa-solid fa-check"></i> Selesai</span>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="produksis.length === 0">
                        <td colspan="9" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data antrean
                            produksi.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>Menampilkan <span class="font-bold text-gray-700">{{ $produksis->firstItem() ?? 0 }}</span> sampai <span
                    class="font-bold text-gray-700">{{ $produksis->lastItem() ?? 0 }}</span> dari <span
                    class="font-bold text-[#E65C00]">{{ $produksis->total() }}</span> antrean</div>
            <div class="flex gap-1">
                @if($produksis->onFirstPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                @else
                    <a href="{{ $produksis->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
                @endif

                @foreach ($produksis->getUrlRange(1, $produksis->lastPage()) as $page => $url)
                    @if ($page == $produksis->currentPage())
                        <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                    @endif
                @endforeach

                @if($produksis->hasMorePages())
                    <a href="{{ $produksis->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
                @else
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                @endif
            </div>
        </div>

        <div x-show="modalUpdate" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto"
                @click.away="modalUpdate = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Update Status Produksi</h3>
                    <button @click="modalUpdate = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <form :action="`/admin/produksi/${activeData.id}/update-progress`" method="POST" class="space-y-4">
                    @csrf @method('PUT')

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4">
                        <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Invoice:</span><span
                                class="font-bold text-gray-800" x-text="activeData.penjualan?.invoice"></span></div>
                        <div class="flex justify-between text-sm mb-1"><span class="text-gray-500">Barang/Jasa:</span><span
                                class="font-bold text-gray-800"
                                x-text="(activeData.produk?.nama_item || activeData.servis?.nama_servis || '') + ' (' + activeData.qty + ' Qty)'"></span>
                        </div>
                        <div class="flex justify-between text-sm border-t border-blue-200 pt-2 mt-2"><span
                                class="text-gray-500">Progress Saat Ini:</span><span
                                class="font-bold text-[#38BDF8] text-lg" x-text="activeData.progress + '%'"></span></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tahap Produksi <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="tahap_produksi" x-model="inputTahap" required
                            placeholder="Contoh: Potong Bahan, Jahit, Sablon, dll..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] font-medium text-gray-800">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Progress Produksi (%) <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="progress" x-model="inputProgress" min="0" max="100"
                                required
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-12 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00] text-lg font-bold text-gray-800">
                            <div
                                class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 pointer-events-none font-bold text-lg border-l border-gray-200 bg-gray-100 rounded-r-lg">
                                %
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fa-solid fa-circle-info text-[#38BDF8]"></i> Ubah ke 100 untuk menandai produksi ini
                            SELESAI.
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan_produksi" x-model="inputCatatan" rows="2"
                            placeholder="Cth: Benang warna merah habis, diganti maroon..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-[#E65C00] focus:ring-1 focus:ring-[#E65C00]"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" @click="modalUpdate = false"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-[#38BDF8] hover:bg-[#0284C7] text-white font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Simpan
                            Update</button>
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
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Reset Catatan Produksi?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin mereset log produksi <span
                        class="font-bold text-gray-800" x-text="activeData.produk?.nama_item || activeData.servis?.nama_servis"></span> kembali ke <span
                        class="text-red-500 font-bold">0% (Belum Diproses)</span>?</p>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button @click="modalHapus = false"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <form :action="`/admin/produksi/${activeData.id}/reset-progress`" method="POST"
                        class="w-full sm:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya,
                            Reset ke 0%</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function produksiApp() {
            return {
                modalUpdate: false,
                modalHapus: false,

                produksis: @json($produksis->items()),
                activeData: {},

                // Input Form State
                inputTahap: '',
                inputProgress: 0,
                inputCatatan: '',

                openUpdate(index) {
                    this.activeData = {
                        ...this.produksis[index]
                    };
                    this.inputTahap = this.activeData.tahap_produksi || '';
                    this.inputProgress = this.activeData.progress;
                    this.inputCatatan = this.activeData.catatan_produksi || '';

                    this.modalUpdate = true;
                },

                openHapus(index) {
                    this.activeData = {
                        ...this.produksis[index]
                    };
                    this.modalHapus = true;
                },

                formatTanggalJam(tgl) {
                    if (!tgl) return '-';
                    const d = new Date(tgl);
                    return d.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        }) + ' ' +
                        d.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                }
            }
        }

        // Client-side search tabel
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.data-row');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const keyword = e.target.value.toLowerCase();
                    tableRows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        row.style.display = rowText.includes(keyword) ? '' : 'none';
                    });
                });
            }

            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', this.value);
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                });
            }
        });
    </script>
@endsection
