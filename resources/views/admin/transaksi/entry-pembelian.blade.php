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

<div x-data="entryPembelianApp()" class="space-y-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between transition-all">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
        <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Gagal Menyimpan!</div>
        <ul class="list-disc list-inside text-sm ml-5">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
    @endif

    <div class="card-animasi-1 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pembelian</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <label class="w-1/3 text-sm font-bold text-gray-700">Tanggal Faktur</label>
                    <input type="date" x-model="tanggalFaktur" class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                </div>
                <div class="flex items-center">
                    <label class="w-1/3 text-sm font-bold text-gray-700">Nomor Faktur</label>
                    <!-- Faktur menyesuaikan pilihan Penjualan -->
                    <input type="text" :value="searchInvoice ? searchInvoice + '-POXX' : 'Pilih Penjualan Dahulu'" readonly class="w-2/3 bg-gray-100 border border-gray-200 font-bold text-gray-600 text-sm rounded-lg px-3 py-2.5 cursor-not-allowed outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center space-y-4">
            <!-- Tombol Pilih Penjualan -->
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Pilih Penjualan</label>
                <div class="w-2/3">
                    <button type="button" @click="modalInvoice = true"
                        class="w-full text-left bg-orange-50 border border-orange-200 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] outline-none flex items-center justify-between hover:bg-orange-100 transition-colors">
                        <span :class="selectedInvoiceId ? 'font-bold text-[#E65C00]' : 'text-gray-400 font-normal'" x-text="selectedInvoiceId ? searchInvoice : 'Klik untuk pilih penjualan...'"></span>
                        <i class="fa-solid fa-file-invoice text-[#E65C00]"></i>
                    </button>
                </div>
            </div>

            <!-- Dropdown Supplier (muncul saat fokus, sort asc) -->
            <div class="flex items-center relative">
                <label class="w-1/3 text-sm font-bold text-gray-700">Supplier</label>
                <div class="w-2/3 flex relative" @click.away="supOpen = false">
                    <input type="text" x-model="searchSupplier"
                        @focus="supOpen = true; findSupplier()"
                        @input="supOpen = true; findSupplier()"
                        placeholder="Ketik atau pilih supplier..."
                        class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-l-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] outline-none border-r-0">
                    <button class="bg-[#E65C00] text-white px-4 rounded-r-lg cursor-default"><i class="fa-solid fa-search"></i></button>
                    <ul x-show="supOpen && resSupplier.length > 0" x-transition.opacity
                        class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-100 shadow-xl rounded-xl max-h-48 overflow-y-auto z-50" style="display:none">
                        <template x-for="sup in resSupplier" :key="sup.id">
                            <li @click="selectSupplier(sup)" class="px-4 py-2.5 hover:bg-orange-50 cursor-pointer text-sm border-b border-gray-50 last:border-0">
                                <span class="font-medium text-gray-700" x-text="sup.nama_supplier"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PILIH PENJUALAN -->
    <div x-show="modalInvoice" style="display:none" class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl m-auto flex flex-col" style="max-height:85vh" @click.away="modalInvoice = false" x-transition>
            <!-- Header Modal -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Pilih Penjualan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Menampilkan order dengan stok bahan minus</p>
                </div>
                <button @click="modalInvoice = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <!-- Search Bar -->
            <div class="px-6 py-3 border-b border-gray-100">
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" x-model="modalSearch" @input="filterModal()"
                        placeholder="Cari nomor invoice atau nama customer..."
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#E65C00]/40 focus:border-[#E65C00]">
                </div>
            </div>
            <!-- List Penjualan (Scrollable) -->
            <div class="overflow-y-auto flex-1 px-2 py-2">
                <template x-if="modalFiltered.length === 0">
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-200"></i>
                        <p class="text-sm">Tidak ada penjualan dengan stok bahan minus.</p>
                    </div>
                </template>
                <template x-for="inv in modalFiltered" :key="inv.id">
                    <div @click="selectInvoice(inv); modalInvoice = false"
                        class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-orange-50 cursor-pointer transition-colors mb-1 border border-transparent hover:border-orange-100"
                        :class="selectedInvoiceId == inv.id ? 'bg-orange-50 border-orange-200' : ''">
                        <div>
                            <p class="font-bold text-[#E65C00] text-sm" x-text="inv.invoice"></p>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="(inv.customer ? inv.customer.nama_customer : 'Unknown') + ' · ' + formatTanggal(inv.created_at)"></p>
                            <!-- Info stok minus -->
                            <div class="flex flex-wrap gap-1 mt-1">
                                <template x-for="d in inv.details.filter(d => d.produk && d.produk.stok < 0)" :key="d.id">
                                    <span class="inline-flex items-center gap-1 bg-red-50 border border-red-200 text-red-600 text-xs px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                        <span x-text="d.produk.nama_item + ' (stok: ' + d.produk.stok + ')'"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-lg" :class="selectedInvoiceId == inv.id ? 'text-[#E65C00]' : 'text-gray-200'"></i>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- TABEL KEBUTUHAN BARANG (Menggantikan Keranjang Manual) -->
    <div class="card-animasi-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0" x-show="selectedInvoiceId">
        
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h3 class="text-lg font-bold text-gray-800">Daftar Kebutuhan Produksi</h3>
            <p class="text-xs text-gray-500 italic"><i class="fa-solid fa-info-circle text-[#E65C00]"></i> Ceklis barang yang ingin dibeli, lalu input harga modal supplier.</p>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-4 px-4 text-center w-16">Pilih</th>
                        <th class="py-4 px-4">Nama Item</th>
                        <th class="py-4 px-4 text-center">Qty Pesanan</th>
                        <th class="py-4 px-4">Harga Beli (Rp)</th>
                        <th class="py-4 px-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <template x-for="(item, index) in listPesanan" :key="index">
                        <tr class="border-b border-gray-50 transition-colors duration-200" :class="item.selected ? 'bg-orange-50/40' : 'hover:bg-gray-50'">
                            <td class="py-4 px-4 text-center">
                                <input type="checkbox" x-model="item.selected" class="w-5 h-5 accent-[#E65C00] cursor-pointer rounded">
                            </td>
                            <td class="py-4 px-4 font-bold text-gray-700" x-text="item.nama"></td>
                            <td class="py-4 px-4 text-center">
                                <!-- QTY DIKUNCI -->
                                <span class="bg-gray-100 border border-gray-200 px-4 py-1.5 rounded-lg font-bold text-gray-600" x-text="item.qty"></span>
                            </td>
                            <td class="py-4 px-4 w-48">
                                <input type="number" x-model="item.harga_beli" :disabled="!item.selected" class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-[#E65C00] outline-none disabled:bg-gray-100 disabled:cursor-not-allowed transition-colors">
                            </td>
                            <td class="py-4 px-4 text-right font-bold text-gray-800" x-text="'Rp ' + formatRupiah(item.harga_beli * item.qty)"></td>
                        </tr>
                    </template>
                    <tr x-show="listPesanan.length === 0">
                        <td colspan="5" class="py-8 text-center text-gray-400 italic">Pilih Nomor Penjualan terlebih dahulu.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOTAL -->
    <div class="card-animasi-4 grid grid-cols-1 lg:grid-cols-2 gap-6" x-show="selectedInvoiceId">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <div class="flex items-center mb-3">
                <label class="w-1/4 text-sm font-bold text-gray-800">Diskon Global</label>
                <input type="number" x-model="diskonGlobal" min="0" class="w-3/4 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-3 focus:ring-1 focus:ring-[#E65C00] outline-none">
            </div>
            <p class="text-xs text-gray-400 italic">
                Note: Masukkan diskon jika ada potongan harga total dari supplier.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-3xl font-bold text-gray-700">Total (Rp)</h2>
                <h1 class="text-5xl font-black text-[#E65C00]" x-text="formatRupiah(grandTotal)"></h1>
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button @click="resetForm()" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
                    Batal
                </button>
                <button @click="modalPayment = true" :disabled="!isAdaYangDiceklis() || !selectedSupplier" class="bg-[#38BDF8] hover:bg-[#0284C7] disabled:bg-gray-300 text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
                    Bayar ke Supplier
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL PAYMENT -->
    <div x-show="modalPayment" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalPayment = false" x-transition>
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Pembayaran Modal</h3>
                <button @click="modalPayment = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.pembelian.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="supplier_id" :value="selectedSupplier">
                <input type="hidden" name="penjualan_id" :value="selectedInvoiceId">
                <input type="hidden" name="tanggal_faktur" :value="tanggalFaktur">
                <!-- Kita lempar ke backend array HANYA yang diceklis admin -->
                <input type="hidden" name="cart_data" :value="JSON.stringify(listPesanan.filter(i => i.selected).map(i => ({id: i.id, qty: i.qty, harga_beli: i.harga_beli, total: i.harga_beli * i.qty})))">
                <input type="hidden" name="total_harga" :value="totalSemua">
                <input type="hidden" name="diskon" :value="diskonGlobal">
                <input type="hidden" name="grand_total" :value="grandTotal">
                <input type="hidden" name="sisa_hutang" :value="sisaHutang">

                <div class="bg-orange-50 p-4 rounded-xl mb-4">
                    <div class="flex justify-between text-sm mb-1 text-gray-600"><span>Supplier:</span> <span class="font-bold text-gray-800" x-text="searchSupplier"></span></div>
                    <div class="flex justify-between text-sm mb-1 text-gray-600"><span>No Penjualan:</span> <span class="font-bold text-gray-800" x-text="searchInvoice"></span></div>
                    <div class="flex justify-between text-sm border-t border-orange-200 pt-2 mt-2">
                        <span class="text-gray-600 font-medium">Grand Total:</span>
                        <span class="font-black text-[#E65C00] text-xl" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Uang Dibayarkan (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="bayar" x-model="inputBayar" @input="kalkulasiHutang()" required class="w-full bg-white border border-gray-300 text-2xl font-bold rounded-xl px-4 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/50 transition-colors text-right">
                </div>

                <div x-show="sisaHutang > 0" x-transition.opacity class="bg-red-50 border border-red-200 p-4 rounded-xl mt-4">
                    <label class="block text-sm font-bold text-red-700 mb-2">Tanggal Jatuh Tempo Hutang <span class="text-red-500">*</span></label>
                    <input type="date" name="jatuh_tempo" :required="sisaHutang > 0" class="w-full bg-white border border-red-300 text-gray-800 rounded-lg px-4 py-2.5 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                    <p class="text-xs text-red-500 mt-2 italic">Karena pembayaran belum lunas, wajib menentukan tanggal jatuh tempo.</p>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Sisa Hutang (Kredit)</span>
                    <span class="font-bold text-lg" :class="sisaHutang > 0 ? 'text-red-500' : 'text-green-600'" x-text="sisaHutang > 0 ? 'Rp ' + formatRupiah(sisaHutang) : 'LUNAS'"></span>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="modalPayment = false" class="w-1/2 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="w-1/2 py-3 bg-[#E65C00] hover:bg-[#cc5200] text-white font-bold rounded-xl transition-colors shadow-lg shadow-orange-500/30">
                        Proses <i class="fa-solid fa-check ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- SCRIPT ALPINE -->
<script>
    function entryPembelianApp() {
        return {
            dbSupplier: @json($suppliers),
            dbPenjualan: @json($penjualans),

            tanggalFaktur: '{{ date("Y-m-d") }}',

            // State Invoice Modal
            modalInvoice: false,
            modalSearch: '',
            modalFiltered: [],
            searchInvoice: '',
            selectedInvoiceId: '',
            listPesanan: [],

            // State Supplier
            searchSupplier: '',
            supOpen: false,
            resSupplier: [],
            selectedSupplier: '',

            // State Pembayaran
            diskonGlobal: 0,
            modalPayment: false,
            inputBayar: '',
            sisaHutang: 0,

            init() {
                // Saat init, siapkan semua data modal (sudah difilter di backend)
                this.modalFiltered = this.dbPenjualan;
                // Supplier: sort ascending sudah dari backend
                this.resSupplier = this.dbSupplier;
            },

            // === FUNGSI MODAL PILIH PENJUALAN ===
            filterModal() {
                const kw = this.modalSearch.toLowerCase();
                this.modalFiltered = kw.length
                    ? this.dbPenjualan.filter(p =>
                        p.invoice.toLowerCase().includes(kw) ||
                        (p.customer && p.customer.nama_customer.toLowerCase().includes(kw))
                      )
                    : this.dbPenjualan;
            },
            selectInvoice(inv) {
                this.selectedInvoiceId = inv.id;
                this.searchInvoice = inv.invoice;
                this.modalSearch = '';
                this.modalFiltered = this.dbPenjualan;
                // Load barang dari invoice ke tabel, dikunci qty-nya
                this.listPesanan = inv.details
                    .filter(d => d.produk_id !== null)
                    .map(d => ({
                        id: d.produk_id,
                        nama: d.produk ? d.produk.nama_item : 'Produk Dihapus',
                        qty: d.qty,
                        harga_beli: d.produk ? d.produk.harga_beli : 0,
                        selected: false
                    }));
            },

            // === FUNGSI SUPPLIER (muncul saat fokus, filter realtime) ===
            findSupplier() {
                const kw = this.searchSupplier.toLowerCase();
                // Jika kosong: tampilkan semua (sudah sort asc dari backend)
                // Jika ada kata kunci: filter by nama yang dimulai/mengandung kw
                this.resSupplier = kw.length
                    ? this.dbSupplier.filter(s => s.nama_supplier.toLowerCase().includes(kw))
                    : this.dbSupplier;
            },
            selectSupplier(sup) {
                this.selectedSupplier = sup.id;
                this.searchSupplier = sup.nama_supplier;
                this.supOpen = false;
            },

            // === KALKULASI & UTILITAS ===
            isAdaYangDiceklis() {
                return this.listPesanan.some(i => i.selected);
            },
            get totalSemua() {
                return this.listPesanan
                    .filter(i => i.selected)
                    .reduce((sum, item) => sum + (parseInt(item.harga_beli || 0) * parseInt(item.qty)), 0);
            },
            get grandTotal() {
                const gt = this.totalSemua - (parseInt(this.diskonGlobal) || 0);
                return gt > 0 ? gt : 0;
            },
            kalkulasiHutang() {
                const bayar = parseInt(this.inputBayar) || 0;
                this.sisaHutang = this.grandTotal - bayar;
                if (this.sisaHutang < 0) this.sisaHutang = 0;
            },
            resetForm() {
                this.searchInvoice = '';
                this.selectedInvoiceId = '';
                this.listPesanan = [];
                this.searchSupplier = '';
                this.selectedSupplier = '';
                this.diskonGlobal = 0;
                this.modalSearch = '';
                this.modalFiltered = this.dbPenjualan;
            },
            formatTanggal(tgl) {
                if (!tgl) return '';
                return new Date(tgl).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            },
            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka || 0);
            }
        }
    }
</script>
@endsection