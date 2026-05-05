<style>
    /* CSS untuk menyembunyikan scrollbar secara visual di semua browser */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Opera */
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        /* IE & Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    /* Memastikan sidebar transisinya mulus di semua state */
    .sidebar-transition {
        transition: width 0.3s ease, transform 0.3s ease;
    }
</style>

<div x-show="sidebarOpen" class="fixed inset-0 bg-black/50 z-40 md:hidden" @click="sidebarOpen = false"></div>

<aside
    :class="(sidebarOpen || sidebarHover) ? 'translate-x-0 w-72' : '-translate-x-full md:translate-x-0 w-72 md:w-[5.5rem]'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-[10px_0_20px_rgba(0,0,0,0.05)] rounded-r-[2rem] sidebar-transition flex flex-col md:hover:w-72 group overflow-hidden"
    @mouseenter="sidebarHover = true" @mouseleave="sidebarHover = false">

    <div class="relative flex items-center justify-center h-24 border-b border-gray-100 w-full shrink-0">
        <img src="{{ asset('assets/images/logo-mudain-orange.png') }}" alt="Logo Full"
            class="absolute w-36 h-auto object-contain transition-all duration-300 md:opacity-0 md:group-hover:opacity-100 transform md:scale-90 md:group-hover:scale-100"
            :class="sidebarOpen ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">

        <img src="{{ asset('assets/images/logo-mudain-icon.png') }}" alt="Logo Kecil"
            class="absolute w-6 h-auto object-contain hidden md:block transition-all duration-300 md:opacity-100 md:group-hover:opacity-0 transform md:scale-100 md:group-hover:scale-50">
    </div>

    <div class="px-4 py-5 shrink-0 flex justify-center md:group-hover:justify-start transition-all duration-300">
        <div class="relative flex items-center h-12 md:group-hover:bg-gray-100 rounded-xl transition-all duration-300 overflow-hidden w-12 md:group-hover:w-full cursor-pointer md:group-hover:cursor-text group/search"
            :class="sidebarOpen ? 'w-full bg-gray-100 cursor-text' : 'w-12'">

            <div class="absolute left-0 top-0 h-full w-12 flex items-center justify-center text-gray-500 md:group-hover:text-[#E65C00] transition-colors z-10"
                :class="sidebarOpen ? 'text-[#E65C00]' : ''">
                <i class="fa-solid fa-search"></i>
            </div>

            <input type="text" placeholder="Cari Menu ..."
                class="absolute left-0 top-0 h-full w-full pl-12 pr-4 bg-transparent text-sm focus:outline-none opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 pointer-events-none md:group-hover:pointer-events-auto"
                :class="sidebarOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'">
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-2 px-4 space-y-2 hide-scrollbar pb-6">

        {{-- DASHBOARD --}}
        @php
            // Cek apakah route saat ini adalah 'admin.dashboard'
            $isDashboard = request()->routeIs('admin.dashboard');
        @endphp
        <a href="{{ route('admin.dashboard') }}"
            class="relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                  {{ $isDashboard ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">
            <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                <i class="fa-solid fa-home text-lg group-hover/item:scale-110 transition-transform"></i>
            </div>
            <span
                class="pl-[3.5rem] font-medium whitespace-nowrap transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Dashboard</span>
        </a>

        {{-- MASTER DATA --}}
        @php
            // Cek apakah URL saat ini mengandung 'admin/master-data' atau sub-menu aktif
            $isMasterDataGroup =
                request()->is('admin/master-data*') ||
                request()->routeIs('admin.produk.index') ||
                request()->routeIs('admin.kategori.index') ||
                request()->routeIs('admin.satuan.index') ||
                request()->routeIs('admin.supplier.index') ||
                request()->routeIs('admin.customer.index') ||
                request()->routeIs('admin.sales.index') ||
                request()->routeIs('admin.stok.index') ||
                request()->is('admin/data-produk*') ||
                request()->is('admin/kategori-produk*') ||
                request()->is('admin/satuan-produk*') ||
                request()->is('admin/supplier*') ||
                request()->is('admin/customer*') ||
                request()->is('admin/sales*') ||
                request()->is('admin/stok*');

        @endphp <div x-data="{ openMasterData: {{ $isMasterDataGroup ? 'true' : 'false' }} }" class="relative">

            <button @click="openMasterData = !openMasterData"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isMasterDataGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-chart-pie text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Master Data</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openMasterData ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openMasterData" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="(sidebarOpen || sidebarHover) ? 'block' : 'hidden md:group-hover:block'">

                @php
                    // 1. Definisikan array sub-menu di sini sebelum di-looping
                    $subMenuItems = [
                        ['label' => 'Data Produk', 'route' => 'admin.data-produk.index'], // Pastikan nama routenya sesuai dengan web.php kamu ya
                        ['label' => 'Data Kategori Produk', 'route' => 'admin.kategori.index'],
                        ['label' => 'Data Satuan Produk', 'route' => 'admin.satuan.index'],
                        ['label' => 'Data Supplier', 'route' => 'admin.supplier.index'],
                        ['label' => 'Data Customer', 'route' => 'admin.customer.index'],
                        ['label' => 'Stok In/Out', 'route' => 'admin.stok.index'],
                    ];
                @endphp

                @foreach ($subMenuItems as $subItem)
                    @php
                        // 2. Cek apakah route ada, lalu cek apakah sedang aktif
                        $isActive = Route::has($subItem['route']) ? request()->routeIs($subItem['route']) : false;
                    @endphp

                    <a href="{{ Route::has($subItem['route']) ? route($subItem['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
           {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">

                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 
                 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}">
                        </span>

                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                            {{ $subItem['label'] }}
                        </span>
                    </a>
                @endforeach

            </div>
        </div>

        {{-- TRANSAKSI --}}
        @php
            // Cek apakah URL saat ini berawalan 'admin/transaksi'
            $isTransaksiGroup = request()->is('admin/transaksi*');
        @endphp

        <div x-data="{ openTransaksi: {{ $isTransaksiGroup ? 'true' : 'false' }} }" class="relative">

            <button @click="openTransaksi = !openTransaksi"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isTransaksiGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-shopping-bag text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Transaksi</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openTransaksi ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openTransaksi" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subTransaksi = [
                        ['label' => 'Entry Penjualan', 'route' => 'admin.transaksi.entry-penjualan'],
                        ['label' => 'Daftar Penjualan', 'route' => 'admin.transaksi.daftar-penjualan'],
                        ['label' => 'Entry Pembelian', 'route' => 'admin.transaksi.entry-pembelian'],
                        ['label' => 'Daftar Pembelian', 'route' => 'admin.transaksi.daftar-pembelian'],
                        ['label' => 'Hutang', 'route' => 'admin.transaksi.hutang'],
                        ['label' => 'Piutang', 'route' => 'admin.transaksi.piutang'],
                    ];
                @endphp

                @foreach ($subTransaksi as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- PRODUKSI --}}
        @php
            $isProduksiGroup = request()->is('admin/produksi*');
        @endphp

        <div x-data="{ openProduksi: {{ $isProduksiGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openProduksi = !openProduksi"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isProduksiGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-scissors text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Produksi</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openProduksi ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openProduksi" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subProduksi = [
                        ['label' => 'Update Produksi', 'route' => 'admin.produksi.update-produksi'],
                        ['label' => 'Update Desain', 'route' => 'admin.produksi.update-desain'],
                    ];
                @endphp

                @foreach ($subProduksi as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- KEUANGAN --}}
        @php
            $isKeuanganGroup = request()->is('admin/keuangan*');
        @endphp

        <div x-data="{ openKeuangan: {{ $isKeuanganGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openKeuangan = !openKeuangan"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isKeuanganGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Keuangan</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openKeuangan ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openKeuangan" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subKeuangan = [
                        ['label' => 'Kas', 'route' => 'admin.keuangan.kas'],
                        ['label' => 'Laba Rugi', 'route' => 'admin.keuangan.laba-rugi'],
                        ['label' => 'Pengeluaran Lainnya', 'route' => 'admin.keuangan.pengeluaran-lainnya'],
                    ];
                @endphp

                @foreach ($subKeuangan as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- KONTEN --}}
        @php
            $isKontenGroup = request()->is('admin/konten*');
        @endphp

        <div x-data="{ openKonten: {{ $isKontenGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openKonten = !openKonten"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isKontenGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-pen-ruler text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Konten</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openKonten ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openKonten" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subKonten = [
                        ['label' => 'Mitra', 'route' => 'admin.konten.mitra'],
                        ['label' => 'Produk', 'route' => 'admin.konten.produk'],
                        ['label' => 'Portofolio', 'route' => 'admin.konten.portofolio'],
                        ['label' => 'Testimoni', 'route' => 'admin.konten.testimoni'],
                    ];
                @endphp

                @foreach ($subKonten as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- LAPORAN --}}
        @php
            $isLaporanGroup = request()->is('admin/laporan*');
        @endphp

        <div x-data="{ openLaporan: {{ $isLaporanGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openLaporan = !openLaporan"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isLaporanGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-file-alt text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Laporan</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openLaporan ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openLaporan" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subLaporan = [
                        ['label' => 'Laporan Barang', 'route' => 'admin.laporan.barang'],
                        ['label' => 'Laporan Penjualan', 'route' => 'admin.laporan.penjualan'],
                        ['label' => 'Laporan Pembelian', 'route' => 'admin.laporan.pembelian'],
                        ['label' => 'Laporan Keuangan', 'route' => 'admin.laporan.keuangan'],
                        ['label' => 'Laporan Stok', 'route' => 'admin.laporan.stok'],
                        ['label' => 'Laporan Hutang', 'route' => 'admin.laporan.hutang'],
                        ['label' => 'Laporan Piutang', 'route' => 'admin.laporan.piutang'],
                    ];
                @endphp

                @foreach ($subLaporan as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- USER --}}
        @php
            $isUserGroup = request()->is('admin/user*');
        @endphp

        <div x-data="{ openUser: {{ $isUserGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openUser = !openUser"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isUserGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-users-cog text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">User</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openUser ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openUser" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subUser = [
                        ['label' => 'Manajemen Role', 'route' => 'admin.user.role'],
                        ['label' => 'Histori Pengguna', 'route' => 'admin.user.histori'],
                        ['label' => 'Manajemen Pengguna', 'route' => 'admin.user.pengguna'],
                    ];
                @endphp

                @foreach ($subUser as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- GRAFIK --}}
        @php
            $isGrafik = request()->routeIs('admin.grafik.index');
        @endphp

        <a href="{{ route('admin.grafik.index') }}"
            class="relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                  {{ $isGrafik ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

            <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                <i class="fa-solid fa-chart-line text-lg group-hover/item:scale-110 transition-transform"></i>
            </div>

            <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                <span class="font-medium whitespace-nowrap">Grafik</span>
            </div>
        </a>

        {{-- TOOLS --}}
        @php
            $isToolsGroup = request()->is('admin/tools*');
        @endphp

        <div x-data="{ openTools: {{ $isToolsGroup ? 'true' : 'false' }} }" class="relative">
            <button @click="openTools = !openTools"
                class="w-full relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                           {{ $isToolsGroup ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">

                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-tools text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>

                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Tools</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                        :class="(openTools ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openTools" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">

                @php
                    $subTools = [
                        ['label' => 'Generate Barcode', 'route' => 'admin.tools.generate-barcode'],
                        ['label' => 'Backup Data', 'route' => 'admin.tools.backup-data'],
                    ];
                @endphp

                @foreach ($subTools as $sub)
                    @php
                        $isActive =
                            $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                    @endphp
                    <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                        <span
                            class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                        <span
                            class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

    </nav>
</aside>

<!-- ======================================================== -->
<!-- SCRIPT UNTUK FITUR REAL-TIME SEARCH MENU SIDEBAR         -->
<!-- ======================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Menangkap elemen input pencarian (menggunakan placeholder karena tidak ada atribut ID)
        const searchInput = document.querySelector('input[placeholder="Cari Menu ..."]');
        
        // 2. Menangkap elemen <nav> yang membungkus semua menu
        const nav = document.querySelector('nav');
        
        // 3. Menangkap semua menu utama (anak langsung dari <nav>). 
        // <a> untuk single link (Dashboard, Grafik), <div> untuk dropdown (Master Data, dll)
        const navElements = Array.from(nav.children);

        // 4. Event Listener setiap kali user mengetik
        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();

            navElements.forEach(item => {
                
                // JIKA MENU ADALAH SINGLE LINK (Contoh: Dashboard, Grafik)
                if (item.tagName.toLowerCase() === 'a') {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(keyword)) {
                        item.style.display = ''; // Munculkan
                    } else {
                        item.style.display = 'none'; // Sembunyikan
                    }
                } 
                // JIKA MENU ADALAH DROPDOWN GROUP (Contoh: Master Data, Transaksi, dll)
                else if (item.tagName.toLowerCase() === 'div') {
                    const parentBtn = item.querySelector('button');
                    if (!parentBtn) return; // Skip jika bukan grup dropdown

                    const parentText = parentBtn.textContent.toLowerCase();
                    const subContainer = item.querySelector('div[x-show]');
                    const subLinks = subContainer.querySelectorAll('a');
                    
                    let hasVisibleSub = false;

                    // Cek satu-satu sub-menu di dalamnya
                    subLinks.forEach(sub => {
                        const subText = sub.textContent.toLowerCase();
                        // Tampilkan sub-menu jika namanya cocok dengan ketikan, 
                        // ATAU jika nama parent-nya yang dicari (maka tampilkan semua sub)
                        if (subText.includes(keyword) || parentText.includes(keyword)) {
                            sub.style.display = ''; 
                            hasVisibleSub = true;
                        } else {
                            sub.style.display = 'none'; 
                        }
                    });

                    // Tampilkan grup parent jika ada sub-menu yang cocok atau parent-nya cocok
                    if (hasVisibleSub || parentText.includes(keyword)) {
                        item.style.display = ''; 
                        
                        // BUKA PAKSA dropdown jika ada kata kunci yang diketik
                        if (keyword !== '') {
                            subContainer.style.display = 'block';
                        } else {
                            // Jika input dihapus/kosong, hapus override agar kembali diatur oleh Alpine.js
                            subContainer.style.display = ''; 
                        }
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
</script>
