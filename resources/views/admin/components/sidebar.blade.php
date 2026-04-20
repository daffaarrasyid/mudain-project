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

            <div x-show="openMasterData" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
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
                        ['label' => 'Data Sales', 'route' => 'admin.sales.index'],
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

            <div x-show="openTransaksi" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
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

            <div x-show="openProduksi" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
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
                
                <div class="pl-[3.5rem] pr-3 flex-1 flex justify-between items-center transition-opacity duration-300 opacity-0 md:group-hover:opacity-100" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    <span class="font-medium whitespace-nowrap">Keuangan</span>
                    <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300" :class="(openKeuangan ? 'rotate-90 ' : '')"></i>
                </div>
            </button>

            <div x-show="openKeuangan" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-2 space-y-1 overflow-hidden transition-all duration-300"
                 :class="sidebarOpen ? 'block' : 'hidden md:group-hover:block'">
                
                @php
                    $subKeuangan = [
                        ['label' => 'Kas', 'route' => 'admin.keuangan.kas'],
                        ['label' => 'Laba Rugi', 'route' => 'admin.keuangan.laba-rugi'],
                        ['label' => 'Pengeluaran Lainnya', 'route' => 'admin.keuangan.pengeluaran-lainnya'],
                    ];
                @endphp

                @foreach($subKeuangan as $sub)
                @php
                    $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
                @endphp
                <a href="{{ $sub['route'] && Route::has($sub['route']) ? route($sub['route']) : '#' }}" 
                   class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-300 pl-[3.5rem] relative group/sub
                          {{ $isActive ? 'text-[#E65C00] font-semibold bg-orange-50 shadow-sm' : 'text-gray-500 hover:text-[#E65C00] hover:bg-orange-50 hover:shadow-sm' }}">
                    <span class="absolute left-[1.5rem] w-[9px] h-[9px] rounded-full border-[2px] bg-transparent transition-all duration-300 {{ $isActive ? 'border-[#E65C00] scale-110' : 'border-gray-400 group-hover/sub:border-[#E65C00] group-hover/sub:scale-110' }}"></span>
                    <span class="whitespace-nowrap opacity-0 md:group-hover:opacity-100 transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $sub['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        @php
            $menus = [
                ['icon' => 'fa-file-alt', 'label' => 'Laporan'],
                ['icon' => 'fa-users-cog', 'label' => 'Management User'],
                ['icon' => 'fa-chart-line', 'label' => 'Grafik'],
                ['icon' => 'fa-tools', 'label' => 'Tools'],
            ];
        @endphp

        @foreach ($menus as $menu)
            <a href="#"
                class="relative flex items-center h-12 text-gray-500 hover:bg-orange-50 hover:text-[#E65C00] rounded-xl transition-all duration-300 overflow-hidden group/item">
                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i
                        class="fa-solid {{ $menu['icon'] }} text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>
                <span
                    class="pl-[3.5rem] font-medium whitespace-nowrap transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">{{ $menu['label'] }}</span>
            </a>
        @endforeach

    </nav>
</aside>
