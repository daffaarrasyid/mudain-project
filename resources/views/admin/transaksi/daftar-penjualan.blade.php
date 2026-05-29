@extends('admin.layouts.app')

@section('content')
    <div x-data="daftarPenjualanApp()"
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full overflow-x-hidden">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 w-full">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Penjualan</h2>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto justify-start sm:justify-end">
                    <span>Tampilkan</span>
                    <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
                <div class="relative w-full sm:w-64">
                    <input type="text" id="searchInput" placeholder="Cari Invoice/Customer..."
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
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4 text-center">Diskon</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Payment<br>Method</th>
                        <th class="px-6 py-4 text-center">Qty</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Progress Produksi</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($penjualans as $index => $trx)
                        @php
                            $persen = $trx->total_harga > 0 ? round(($trx->bayar / $trx->total_harga) * 100) : 0;
                        @endphp
                        <tr
                            class="data-row border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors duration-200 animate-fade-in-up delay-{{ $index * 100 }}">
                            <td class="px-6 py-4 font-bold text-[#E65C00]">{{ $trx->invoice }}</td>
                            <td class="px-6 py-4">{{ $trx->user->name ?? 'Admin' }}</td>
                            <td class="px-6 py-4">{{ $trx->customer->nama_customer ?? 'Umum' }}</td>
                            <td class="px-6 py-4 text-center">0</td>
                            <td class="px-6 py-4 font-bold text-gray-800">Rp
                                {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td
                                class="px-6 py-4 font-semibold {{ $trx->status_pembayaran == 'Lunas' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $trx->status_pembayaran }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-bold leading-tight">
                                @php
                                    $qtyProduk = $trx->details->whereNotNull('produk_id')->sum('qty');
                                    $qtyServis = $trx->details->whereNotNull('servis_id')->sum('qty');
                                @endphp

                                @if ($qtyProduk > 0)
                                    <div class="text-blue-600 bg-blue-50 rounded px-2 py-1 inline-block mb-1">
                                        {{ $qtyProduk }} Brg</div>
                                @endif

                                @if ($qtyServis > 0)
                                    <div class="text-purple-600 bg-purple-50 rounded px-2 py-1 inline-block">
                                        {{ $qtyServis }} Jasa</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}<br>
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($trx->average_progress == 100)
                                    <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-md text-xs">100%
                                        Selesai</span>
                                @elseif($trx->average_progress > 0)
                                    <span
                                        class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-md text-xs">{{ $trx->average_progress }}%
                                        Diproses</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-500 font-bold px-3 py-1 rounded-md text-xs">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-1.5 w-[160px] mx-auto">
                                    <button @click="openDetail({{ $index }})"
                                        class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-magnifying-glass"></i> Detail
                                    </button>
                                    <a href="{{ route('admin.penjualan.cetak', $trx->id) }}"
                                        class="bg-[#10B981] hover:bg-[#059669] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-print"></i> Cetak
                                    </a>

                                    @if (($trx->average_progress ?? 0) < 100)
                                        <a href="{{ route('admin.penjualan.entry', ['edit_id' => $trx->id]) }}"
                                            class="bg-[#F59E0B] hover:bg-[#D97706] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                    @else
                                        <div></div>
                                    @endif

                                    <button @click="modalHapus = true; hapusId = '{{ $trx->id }}'"
                                        class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-2 py-1.5 rounded text-[10px] sm:text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-sm text-gray-500 gap-4">
            <div>
                Menampilkan <span class="font-bold text-gray-700">{{ $penjualans->firstItem() ?? 0 }}</span>
                sampai <span class="font-bold text-gray-700">{{ $penjualans->lastItem() ?? 0 }}</span>
                dari <span class="font-bold text-[#E65C00]">{{ $penjualans->total() }}</span> data
            </div>
            <div class="flex items-center gap-1 text-sm">
                @if ($penjualans->onFirstPage())
                    <button
                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i
                            class="fa-solid fa-chevron-left text-xs"></i></button>
                @else
                    <a href="{{ $penjualans->previousPageUrl() }}"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i
                            class="fa-solid fa-chevron-left text-xs"></i></a>
                @endif

                @foreach ($penjualans->getUrlRange(1, $penjualans->lastPage()) as $page => $url)
                    @if ($page == $penjualans->currentPage())
                        <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($penjualans->hasMorePages())
                    <a href="{{ $penjualans->nextPageUrl() }}"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i
                            class="fa-solid fa-chevron-right text-xs"></i></a>
                @else
                    <button
                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i
                            class="fa-solid fa-chevron-right text-xs"></i></button>
                @endif
            </div>
        </div>

        <div x-show="modalDetail" style="display: none;"
            class="fixed inset-0 z-[100] flex items-start justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 mt-8 mb-8"
                @click.away="modalDetail = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Detail Invoice: <span class="text-[#E65C00]"
                            x-text="detailData.invoice"></span></h3>
                    <button @click="modalDetail = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>

                <div class="space-y-6">
                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-gray-500 mb-1">Kasir</p>
                            <p class="font-bold text-gray-800" x-text="detailData.user?.name || 'Admin'"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Customer</p>
                            <p class="font-bold text-gray-800" x-text="detailData.customer?.nama_customer || 'Umum'"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Waktu</p>
                            <p class="font-bold text-gray-800" x-text="formatTanggal(detailData.created_at)"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Metode Bayar</p>
                            <p class="font-bold"
                                :class="detailData.status_pembayaran === 'Lunas' ? 'text-green-600' : 'text-red-500'"
                                x-text="detailData.status_pembayaran"></p>
                        </div>
                    </div>

                    <div class="overflow-x-auto border border-gray-100 rounded-lg">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="p-3">Kategori</th>
                                    <th class="p-3">Nama Item / Servis</th>
                                    <th class="p-3 text-center">Qty</th>
                                    <th class="p-3 text-right">Harga</th>
                                    <th class="p-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="item in detailData.details" :key="item.id">
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3">
                                            <span x-show="item.produk_id"
                                                class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded">Produk</span>
                                            <span x-show="item.servis_id"
                                                class="px-2 py-1 bg-purple-50 text-purple-600 text-xs font-bold rounded">Servis</span>
                                        </td>
                                        <td class="p-3 font-medium text-gray-800"
                                            x-text="item.produk_id ? item.produk?.nama_item : (item.servis?.nama_servis || 'Item Dihapus')">
                                        </td>
                                        <td class="p-3 text-center" x-text="item.qty"></td>
                                        <td class="p-3 text-right" x-text="formatRupiah(item.harga_satuan)"></td>
                                        <td class="p-3 text-right font-medium" x-text="formatRupiah(item.subtotal)"></td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold text-gray-800">
                                <tr>
                                    <td colspan="4" class="p-3 text-right text-lg">TOTAL</td>
                                    <td class="p-3 text-right text-lg text-[#E65C00]"
                                        x-text="'Rp ' + formatRupiah(detailData.total_harga)"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                    <button @click="modalDetail = false"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Tutup</button>
                </div>
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
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Transaksi?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin membatalkan dan menghapus data penjualan ini?</p>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button @click="modalHapus = false"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                    <form :action="`/admin/penjualan/${hapusId}`" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">Ya,
                            Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function daftarPenjualanApp() {
            return {
                modalDetail: false,
                modalHapus: false,

                penjualans: @json($penjualans->items()),

                detailData: {},
                hapusId: '',

                openDetail(index) {
                    this.detailData = this.penjualans[index];
                    this.modalDetail = true;
                },

                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID').format(angka || 0);
                },

                formatTanggal(tgl) {
                    if (!tgl) return '-';
                    const d = new Date(tgl);
                    const options = {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    };
                    return d.toLocaleDateString('id-ID', options).replace(',', '');
                }
            }
        }

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
