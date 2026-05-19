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
    .card-animasi-5 { animation: slideUpFade 0.8s ease-out 0.9s both; }
</style>

<div x-data="posApp()" class="space-y-6 animate-[fadeIn_0.5s_ease-in-out]">
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span></div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
        <div class="flex items-center gap-2 font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Transaksi Gagal!</div>
        <ul class="list-disc list-inside text-sm ml-5">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Penjualan</h2>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800">Invoice <span class="font-normal text-[#E65C00]">{{ $invoice }}</span></p>
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-end mt-10">
            <h3 class="text-3xl font-bold text-gray-700 mb-2 md:mb-0">Total (Rp)</h3>
            <h1 class="text-5xl md:text-6xl font-black text-[#E65C00]" x-text="formatRupiah(grandTotal)">0</h1>
        </div>
    </div>

    <div class="card-animasi-2 grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Operator</label>
                <input type="text" value="{{ Auth::user()->name ?? 'Administrator' }}" readonly class="w-2/3 bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg px-3 py-2 cursor-not-allowed outline-none">
            </div>
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Customer</label>
                <select x-model="selectedCustomer" @change="updateCustomerType()" class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                    <option value="">Pilih Customer</option>
                    @foreach($customers as $cus)
                        <option value="{{ $cus->id }}" data-jenis="{{ $cus->jenis_customer }}">{{ $cus->nama_customer }} ({{ $cus->jenis_customer }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center">
                <label class="w-1/3 text-sm font-bold text-gray-700">Layanan</label>
                <select x-model="selectedLayanan" @change="handleLayananChange()" class="w-2/3 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
                    <option value="Produk">Produk Fisik</option>
                    <option value="Servis">Servis / Jasa</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="flex items-center relative">
                <label class="w-1/4 text-sm font-bold text-gray-700" x-text="selectedLayanan"></label>
                <div class="w-3/4 flex relative" @click.away="searchOpen = false">
                    <input type="text" x-model="searchKeyword" @input="searchOpen = true; findItem()" @focus="searchOpen = true" placeholder="Ketik Kode/Nama..." class="w-full bg-white border border-gray-200 text-gray-700 text-sm rounded-l-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none border-r-0">
                    <button class="bg-[#E65C00] text-white px-4 rounded-r-lg transition-colors cursor-default">
                        <i class="fa-solid fa-search"></i>
                    </button>
                    
                    <ul x-show="searchOpen && searchKeyword.length > 0" x-transition.opacity class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-100 shadow-xl rounded-xl max-h-48 overflow-y-auto z-50 py-1" style="display: none;">
                        <template x-for="item in searchResults" :key="item.id">
                            <li @click="selectItem(item)" class="px-4 py-2 hover:bg-orange-50 cursor-pointer text-sm border-b border-gray-50 last:border-0 transition-colors">
                                <span class="font-bold text-[#E65C00]" x-text="item.kode"></span> - <span class="text-gray-700" x-text="item.nama"></span>
                            </li>
                        </template>
                        <li x-show="searchResults.length === 0" class="px-4 py-2 text-sm text-gray-500 italic text-center">Tidak ditemukan...</li>
                    </ul>
                </div>
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Qty</label>
                <input type="number" x-model="inputQty" @input="calculateSubtotal()" min="1" 
                       :readonly="selectedLayanan === 'Servis'" 
                       :class="selectedLayanan === 'Servis' ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'"
                       class="w-3/4 border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#E65C00] focus:border-[#E65C00] outline-none">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4 relative">
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Nama</label>
                <input type="text" x-model="inputNama" readonly class="w-3/4 bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-lg px-3 py-2 outline-none cursor-not-allowed">
            </div>
            <div class="flex items-center">
                <label class="w-1/4 text-sm font-bold text-gray-700">Harga</label>
                <div class="w-3/4 flex relative">
                    <span class="absolute left-3 top-2 text-gray-500 text-sm font-bold">Rp</span>
                    <input type="number" x-model="inputHarga" @input="calculateSubtotal()" 
                           :readonly="selectedLayanan === 'Produk'" 
                           :class="selectedLayanan === 'Produk' ? 'bg-gray-50 cursor-not-allowed' : 'bg-white'"
                           class="w-full border border-gray-200 text-gray-700 text-sm rounded-lg pl-10 pr-3 py-2 focus:ring-1 focus:ring-[#E65C00] outline-none">
                </div>
            </div>
            <div class="flex items-center mb-10">
                <label class="w-1/4 text-sm font-bold text-gray-700">Total</label>
                <input type="text" :value="'Rp ' + formatRupiah(inputSubtotal)" readonly class="w-3/4 bg-gray-100 border border-gray-200 text-[#E65C00] text-sm font-bold rounded-lg px-3 py-2 outline-none cursor-not-allowed">
            </div>
            <div class="flex items-end justify-end right-6">
                <button @click="addToCart()" :disabled="!inputId" class="bg-[#10B981] hover:bg-[#059669] disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-colors">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="card-animasi-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Produk</h3>
        <div class="w-full overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-3 px-2">Barcode</th>
                        <th class="py-3 px-2">Nama Item</th>
                        <th class="py-3 px-2 text-right">Harga Umum</th>
                        <th class="py-3 px-2 text-right">Harga Pelanggan</th>
                        <th class="py-3 px-2 text-center">Qty</th>
                        <th class="py-3 px-2 text-right">Total</th>
                        <th class="py-3 px-2 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <template x-for="(item, index) in cartProduk" :key="index">
                        <tr class="border-b border-gray-100 h-12 hover:bg-gray-50">
                            <td class="py-3 px-2 font-semibold text-[#E65C00]" x-text="item.kode"></td>
                            <td class="py-3 px-2 font-medium" x-text="item.nama"></td>
                            <td class="py-3 px-2 text-right" x-text="'Rp ' + formatRupiah(item.hargaUmum)"></td>
                            <td class="py-3 px-2 text-right text-blue-600 font-medium" x-text="'Rp ' + formatRupiah(item.hargaPelanggan)"></td>
                            <td class="py-3 px-2 text-center font-bold" x-text="item.qty"></td>
                            <td class="py-3 px-2 text-right font-bold text-gray-800" x-text="'Rp ' + formatRupiah(item.total)"></td>
                            <td class="py-3 px-2 text-center">
                                <button @click="removeFromCart('Produk', index)" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition-colors"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="cartProduk.length === 0" class="border-b border-gray-100 h-12">
                        <td colspan="7" class="text-center text-gray-400 italic">Belum ada produk ditambahkan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-animasi-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-w-0">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Servis</h3>
        <div class="w-full overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="py-3 px-2">Kode</th>
                        <th class="py-3 px-2">Nama Servis</th>
                        <th class="py-3 px-2 text-right">Harga Deal</th>
                        <th class="py-3 px-2 text-right">Total</th>
                        <th class="py-3 px-2 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <template x-for="(item, index) in cartService" :key="index">
                        <tr class="border-b border-gray-100 h-12 hover:bg-gray-50">
                            <td class="py-3 px-2 font-semibold text-[#E65C00]" x-text="item.kode"></td>
                            <td class="py-3 px-2 font-medium" x-text="item.nama"></td>
                            <td class="py-3 px-2 text-right" x-text="'Rp ' + formatRupiah(item.harga)"></td>
                            <td class="py-3 px-2 text-right font-bold text-gray-800" x-text="'Rp ' + formatRupiah(item.total)"></td>
                            <td class="py-3 px-2 text-center">
                                <button @click="removeFromCart('Servis', index)" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition-colors"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="cartService.length === 0" class="border-b border-gray-100 h-12">
                        <td colspan="5" class="text-center text-gray-400 italic">Belum ada servis ditambahkan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-animasi-5 flex justify-end gap-4 pb-8">
        <button @click="cartProduk = []; cartService = []" class="bg-[#EF4444] hover:bg-[#B91C1C] text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
            Cancel
        </button>
        <button @click="modalPayment = true" :disabled="grandTotal === 0" class="bg-[#38BDF8] hover:bg-[#0284C7] disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition-colors transform hover:-translate-y-0.5">
            Payment
        </button>
    </div>

    <div x-show="modalPayment" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-auto" @click.away="modalPayment = false" x-transition>
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-xl font-bold text-gray-800">Pembayaran</h3>
                <button @click="modalPayment = false" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <form action="{{ route('admin.penjualan.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="invoice" value="{{ $invoice }}">
                <input type="hidden" name="customer_id" :value="selectedCustomer">
                
                <input type="hidden" name="cart_produk" :value="JSON.stringify(cartProduk)">
                <input type="hidden" name="cart_service" :value="JSON.stringify(cartService)">
                
                <input type="hidden" name="total_harga" :value="grandTotal">
                <input type="hidden" name="kembalian" :value="kembalian">
                <input type="hidden" name="status_pembayaran" :value="statusPembayaran">

                <div class="bg-orange-50 p-4 rounded-xl text-center mb-6">
                    <p class="text-sm text-orange-600 font-semibold mb-1">Total Tagihan</p>
                    <h1 class="text-3xl font-black text-[#E65C00]" x-text="'Rp ' + formatRupiah(grandTotal)"></h1>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Bayar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="bayar" x-model="inputBayar" @input="kalkulasiKembalian()" required class="w-full bg-white border border-gray-300 text-2xl font-bold rounded-xl px-4 py-3 focus:outline-none focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/50 transition-colors text-right">
                </div>

                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Kembalian</span>
                    <span class="font-bold text-lg" :class="kembalian < 0 ? 'text-red-500' : 'text-green-600'" x-text="kembalian < 0 ? 'KREDIT' : 'Rp ' + formatRupiah(kembalian)"></span>
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

<script>
    function posApp() {
        return {
            databaseProduk: @json($produks),
            databaseService: @json($servis), 
            
            selectedCustomer: '',
            jenisCustomer: 'Umum',
            selectedLayanan: 'Produk', 
            
            searchKeyword: '',
            searchOpen: false,
            searchResults: [],
            
            inputId: '',
            inputKode: '',
            inputNama: '',
            inputHargaUmum: 0,
            inputHargaPelanggan: 0,
            inputHarga: 0, 
            inputQty: 1,
            inputSubtotal: 0,

            cartProduk: [],
            cartService: [],
            
            modalPayment: false,
            inputBayar: '',
            kembalian: 0,
            statusPembayaran: 'Lunas',

            updateCustomerType() {
                if(this.selectedCustomer === '') {
                    this.jenisCustomer = 'Umum';
                } else {
                    const select = document.querySelector('select[x-model="selectedCustomer"]');
                    const option = select.options[select.selectedIndex];
                    this.jenisCustomer = option.getAttribute('data-jenis') || 'Umum';
                }
                
                if(this.inputId && this.selectedLayanan === 'Produk') {
                    this.inputHarga = this.jenisCustomer === 'Umum' ? this.inputHargaUmum : this.inputHargaPelanggan;
                    this.calculateSubtotal();
                }
            },

            // Fungsi reset saat ganti Layanan
            handleLayananChange() {
                this.resetInput();
                if(this.selectedLayanan === 'Servis') {
                    this.inputQty = 1; // Paksa Qty 1
                }
            },

            findItem() {
                const keyword = this.searchKeyword.toLowerCase();
                if(keyword.length < 1) {
                    this.searchResults = [];
                    return;
                }

                if(this.selectedLayanan === 'Produk') {
                    this.searchResults = this.databaseProduk.filter(p => 
                        p.kode_barang.toLowerCase().includes(keyword) || 
                        p.nama_item.toLowerCase().includes(keyword)
                    ).map(p => ({
                        id: p.id,
                        kode: p.kode_barang,
                        nama: p.nama_item,
                        hargaUmum: p.harga_jual_umum,
                        hargaPelanggan: p.harga_pelanggan
                    }));
                } else {
                    // Logic Servis: Ngambil harga dari harga_dasar
                    this.searchResults = this.databaseService.filter(p => 
                        p.kode_servis.toLowerCase().includes(keyword) || 
                        p.nama_servis.toLowerCase().includes(keyword)
                    ).map(p => ({
                        id: p.id,
                        kode: p.kode_servis,
                        nama: p.nama_servis,
                        hargaUmum: p.harga_dasar, 
                        hargaPelanggan: p.harga_dasar
                    }));
                }
            },

            selectItem(item) {
                this.inputId = item.id;
                this.inputKode = item.kode;
                this.inputNama = item.nama;
                this.searchKeyword = item.kode + ' - ' + item.nama;
                this.searchOpen = false;

                if(this.selectedLayanan === 'Produk') {
                    this.inputHargaUmum = item.hargaUmum;
                    this.inputHargaPelanggan = item.hargaPelanggan;
                    this.inputHarga = this.jenisCustomer === 'Umum' ? item.hargaUmum : item.hargaPelanggan;
                } else {
                    this.inputHarga = item.hargaUmum; // Harga dasar Servis langsung masuk
                    this.inputQty = 1; // Pastikan Qty 1
                }
                
                this.calculateSubtotal();
            },

            calculateSubtotal() {
                this.inputSubtotal = this.inputHarga * this.inputQty;
            },

            addToCart() {
                if(!this.inputId) return;

                if(this.selectedLayanan === 'Produk') {
                    const existingIndex = this.cartProduk.findIndex(item => item.id === this.inputId);
                    if(existingIndex !== -1) {
                        const newQty = parseInt(this.cartProduk[existingIndex].qty) + parseInt(this.inputQty);
                        this.cartProduk[existingIndex].qty = newQty;
                        this.cartProduk[existingIndex].total = this.cartProduk[existingIndex].qty * this.cartProduk[existingIndex].harga;
                    } else {
                        this.cartProduk.push({
                            id: this.inputId, kode: this.inputKode, nama: this.inputNama,
                            hargaUmum: this.inputHargaUmum, hargaPelanggan: this.inputHargaPelanggan,
                            harga: this.inputHarga, qty: this.inputQty, total: this.inputSubtotal
                        });
                    }
                } else {
                    // INI YANG SEBELUMNYA KOSONG: Push Servis ke Keranjang
                    const existingIndex = this.cartService.findIndex(item => item.id === this.inputId);
                    if(existingIndex !== -1) {
                        // Kalau servis udah ada di list, update harganya aja (karena Qty fix 1)
                        this.cartService[existingIndex].harga = this.inputHarga;
                        this.cartService[existingIndex].total = this.inputHarga;
                    } else {
                        this.cartService.push({
                            id: this.inputId, kode: this.inputKode, nama: this.inputNama,
                            harga: this.inputHarga, qty: 1, total: this.inputSubtotal
                        });
                    }
                }

                this.resetInput();
            },

            removeFromCart(tipe, index) {
                if(tipe === 'Produk') this.cartProduk.splice(index, 1);
                else this.cartService.splice(index, 1);
            },

            resetInput() {
                this.searchKeyword = '';
                this.searchOpen = false;
                this.inputId = '';
                this.inputKode = '';
                this.inputNama = '';
                this.inputHargaUmum = 0;
                this.inputHargaPelanggan = 0;
                this.inputHarga = 0;
                // Kalau lagi di mode Servis, otomatis 1. Kalau produk, balik 1.
                this.inputQty = 1; 
                this.inputSubtotal = 0;
                this.searchResults = [];
            },

            get grandTotal() {
                const totalProduk = this.cartProduk.reduce((sum, item) => parseInt(sum) + parseInt(item.total), 0);
                const totalService = this.cartService.reduce((sum, item) => parseInt(sum) + parseInt(item.total), 0);
                return totalProduk + totalService;
            },

            kalkulasiKembalian() {
                const bayar = parseInt(this.inputBayar) || 0;
                this.kembalian = bayar - this.grandTotal;
                this.statusPembayaran = this.kembalian < 0 ? 'Kredit' : 'Lunas';
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }
        }
    }
</script>
@endsection