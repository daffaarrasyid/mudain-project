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
            // Ambil array izin akses dari role user yang sedang login
            $userPerms = optional(auth()->user()->role)->permissions ?? [];
            $hasFullAccess = in_array('*', $userPerms);
        @endphp

        {{-- DASHBOARD (Hanya untuk Full Access / Admin) --}}
        @if($hasFullAccess)
            @php
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
        @endif

        {{-- MASTER DATA --}}
        @php
            $isMasterDataGroup = request()->is('admin/master-data*') || request()->routeIs('admin.produk.index') || request()->routeIs('admin.kategori.index') || request()->routeIs('admin.satuan.index') || request()->routeIs('admin.servis.index') || request()->routeIs('admin.staf.index') || request()->routeIs('admin.supplier.index') || request()->routeIs('admin.customer.index') || request()->routeIs('admin.sales.index') || request()->routeIs('admin.stok.index') || request()->is('admin/data-produk*') || request()->is('admin/kategori-produk*') || request()->is('admin/satuan-produk*') || request()->is('admin/servis*') || request()->is('admin/staf*') || request()->is('admin/supplier*') || request()->is('admin/customer*') || request()->is('admin/sales*') || request()->is('admin/stok*');

            $subMenuItems = [
                ['label' => 'Data Produk', 'route' => 'admin.data-produk.index', 'perm' => 'Master Data_Data Produk'],
                ['label' => 'Data Kategori Produk', 'route' => 'admin.kategori.index', 'perm' => 'Master Data_Data Kategori'],
                ['label' => 'Data Satuan Produk', 'route' => 'admin.satuan.index', 'perm' => 'Master Data_Data Satuan'],
                ['label' => 'Data Servis', 'route' => 'admin.servis.index', 'perm' => 'Master Data_Data Servis'],
                ['label' => 'Data Staf', 'route' => 'admin.staf.index', 'perm' => 'Master Data_Data Staf'],
                ['label' => 'Data Supplier', 'route' => 'admin.supplier.index', 'perm' => 'Master Data_Data Supplier'],
                ['label' => 'Data Customer', 'route' => 'admin.customer.index', 'perm' => 'Master Data_Data Customer'],
                ['label' => 'Stok In/Out', 'route' => 'admin.stok.index', 'perm' => 'Master Data_Stok In/Out'],
            ];

            // Saring menu berdasarkan permission
            $allowedMasterData = array_filter($subMenuItems, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedMasterData) > 0)
        <div x-data="{ openMasterData: {{ $isMasterDataGroup ? 'true' : 'false' }} }" class="relative">
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

                @foreach ($allowedMasterData as $subItem)
                    @php
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
        @endif

        {{-- TRANSAKSI --}}
        @php
            $isTransaksiGroup = request()->is('admin/transaksi*');
            
            $subTransaksi = [
                ['label' => 'Entry Penjualan', 'route' => 'admin.penjualan.entry', 'perm' => 'Transaksi_Entry Penjualan'],
                ['label' => 'Daftar Penjualan', 'route' => 'admin.penjualan.daftar', 'perm' => 'Transaksi_Daftar Penjualan'],
                ['label' => 'Entry Pembelian', 'route' => 'admin.pembelian.entry', 'perm' => 'Transaksi_Entry Pembelian'],
                ['label' => 'Daftar Pembelian', 'route' => 'admin.pembelian.daftar', 'perm' => 'Transaksi_Daftar Pembelian'],
                ['label' => 'Hutang', 'route' => 'admin.transaksi.hutang', 'perm' => 'Transaksi_Hutang'],
                ['label' => 'Piutang', 'route' => 'admin.transaksi.piutang', 'perm' => 'Transaksi_Piutang'],
            ];

            $allowedTransaksi = array_filter($subTransaksi, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedTransaksi) > 0)
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

                @foreach ($allowedTransaksi as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- PRODUKSI --}}
        @php
            $isProduksiGroup = request()->is('admin/produksi*');
            $subProduksi = [
                ['label' => 'Update Produksi', 'route' => 'admin.produksi.update-produksi', 'perm' => 'Produksi_Update Produksi'],
                ['label' => 'Update Desain', 'route' => 'admin.produksi.update-desain', 'perm' => 'Produksi_Update Desain'],
            ];
            $allowedProduksi = array_filter($subProduksi, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedProduksi) > 0)
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

                @foreach ($allowedProduksi as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- KEUANGAN --}}
        @php
            $isKeuanganGroup = request()->is('admin/keuangan*');
            $subKeuangan = [
                ['label' => 'Kas', 'route' => 'admin.keuangan.kas', 'perm' => 'Keuangan_Kas'],
                ['label' => 'Laba Rugi', 'route' => 'admin.keuangan.laba-rugi', 'perm' => 'Keuangan_Laba Rugi'],
                ['label' => 'Pengeluaran Lainnya', 'route' => 'admin.keuangan.pengeluaran-lainnya', 'perm' => 'Keuangan_Pengeluaran Lainnya'],
            ];
            $allowedKeuangan = array_filter($subKeuangan, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedKeuangan) > 0)
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

                @foreach ($allowedKeuangan as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- KONTEN --}}
        @php
            $isKontenGroup = request()->is('admin/konten*');
            $subKonten = [
                ['label' => 'Mitra', 'route' => 'admin.konten.mitra', 'perm' => 'Konten_Mitra'],
                ['label' => 'Produk', 'route' => 'admin.konten.produk', 'perm' => 'Konten_Produk (Konten)'],
                ['label' => 'Portofolio', 'route' => 'admin.konten.portofolio', 'perm' => 'Konten_Portofolio'],
                ['label' => 'Testimoni', 'route' => 'admin.konten.testimoni', 'perm' => 'Konten_Testimoni'],
            ];
            $allowedKonten = array_filter($subKonten, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedKonten) > 0)
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

                @foreach ($allowedKonten as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- LAPORAN --}}
        @php
            $isLaporanGroup = request()->is('admin/laporan*');
            $subLaporan = [
                ['label' => 'Laporan Barang', 'route' => 'admin.laporan.barang', 'perm' => 'Laporan_Laporan Barang'],
                ['label' => 'Laporan Penjualan', 'route' => 'admin.laporan.penjualan', 'perm' => 'Laporan_Laporan Penjualan'],
                ['label' => 'Laporan Pembelian', 'route' => 'admin.laporan.pembelian', 'perm' => 'Laporan_Laporan Pembelian'],
                ['label' => 'Laporan Keuangan', 'route' => 'admin.laporan.keuangan', 'perm' => 'Laporan_Laporan Keuangan'],
                ['label' => 'Laporan Stok', 'route' => 'admin.laporan.stok', 'perm' => 'Laporan_Laporan Stok'],
                ['label' => 'Laporan Hutang', 'route' => 'admin.laporan.hutang', 'perm' => 'Laporan_Laporan Hutang'],
                ['label' => 'Laporan Piutang', 'route' => 'admin.laporan.piutang', 'perm' => 'Laporan_Laporan Piutang'],
            ];
            $allowedLaporan = array_filter($subLaporan, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedLaporan) > 0)
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

                @foreach ($allowedLaporan as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- USER --}}
        @php
            $isUserGroup = request()->is('admin/user*');
            $subUser = [
                ['label' => 'Manajemen Role', 'route' => 'admin.user.role', 'perm' => 'User_Manajemen Role'],
                ['label' => 'Histori Pengguna', 'route' => 'admin.user.histori', 'perm' => 'User_Histori Pengguna'],
                ['label' => 'Manajemen Pengguna', 'route' => 'admin.user.pengguna', 'perm' => 'User_Manajemen Pengguna'],
            ];
            $allowedUser = array_filter($subUser, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedUser) > 0)
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

                @foreach ($allowedUser as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

        {{-- GRAFIK (Tampil kalau punya akses ke Laporan atau Full Access) --}}
        @if($hasFullAccess)
            @php
                $isGrafik = request()->routeIs('admin.grafik.index');
            @endphp
            <a href="{{ route('admin.grafik.index') }}"
                class="relative flex items-center h-12 rounded-xl transition-all duration-300 overflow-hidden group/item
                      {{ $isGrafik ? 'bg-gradient-to-r from-[#E65C00] to-[#F9D423] text-white shadow-md' : 'text-gray-500 hover:bg-orange-50 hover:text-[#E65C00]' }}">
                <div class="absolute left-0 top-0 h-full w-[3.5rem] flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-lg group-hover/item:scale-110 transition-transform"></i>
                </div>
                <span
                    class="pl-[3.5rem] font-medium whitespace-nowrap transition-opacity duration-300 opacity-0 md:group-hover:opacity-100"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Grafik</span>
            </a>
        @endif

        {{-- TOOLS --}}
        @php
            $isToolsGroup = request()->is('admin/tools*');
            $subTools = [
                ['label' => 'Backup Data', 'route' => 'admin.tools.backup-data', 'perm' => 'Tools_Backup Data'],
            ];
            $allowedTools = array_filter($subTools, function($item) use ($userPerms, $hasFullAccess) {
                return $hasFullAccess || in_array($item['perm'], $userPerms);
            });
        @endphp

        @if(count($allowedTools) > 0)
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

                @foreach ($allowedTools as $sub)
                    @php
                        $isActive = $sub['route'] && Route::has($sub['route']) ? request()->routeIs($sub['route']) : false;
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
        @endif

    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[placeholder="Cari Menu ..."]');
        const nav = document.querySelector('nav');
        const navElements = Array.from(nav.children);

        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();

            navElements.forEach(item => {
                if (item.tagName.toLowerCase() === 'a') {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(keyword)) {
                        item.style.display = ''; 
                    } else {
                        item.style.display = 'none'; 
                    }
                } 
                else if (item.tagName.toLowerCase() === 'div' && item.hasAttribute('x-data')) {
                    const parentBtn = item.querySelector('button');
                    if (!parentBtn) return;

                    const parentText = parentBtn.textContent.toLowerCase();
                    const subContainer = item.querySelector('div[x-show]');
                    if (!subContainer) return;
                    
                    const subLinks = subContainer.querySelectorAll('a');
                    let hasVisibleSub = false;

                    subLinks.forEach(sub => {
                        const subText = sub.textContent.toLowerCase();
                        if (subText.includes(keyword) || parentText.includes(keyword)) {
                            sub.style.display = ''; 
                            hasVisibleSub = true;
                        } else {
                            sub.style.display = 'none'; 
                        }
                    });

                    if (hasVisibleSub || parentText.includes(keyword)) {
                        item.style.display = ''; 
                        if (keyword !== '') {
                            subContainer.style.display = 'block';
                        } else {
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