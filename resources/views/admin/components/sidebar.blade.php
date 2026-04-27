@php
    $menu = [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge-high',
            'route' => 'admin.dashboard',
        ],
        [
            'label' => 'Master Data',
            'icon' => 'fa-solid fa-boxes-stacked',
            'children' => [
                ['label' => 'Data Produk', 'route' => 'admin.data-produk.index'],
                ['label' => 'Kategori', 'route' => 'admin.kategori.index'],
                ['label' => 'Satuan', 'route' => 'admin.satuan.index'],
                ['label' => 'Supplier', 'route' => 'admin.supplier.index'],
                ['label' => 'Customer', 'route' => 'admin.customer.index'],
                ['label' => 'Stok In/Out', 'route' => 'admin.stok.index'],
            ],
        ],
        [
            'label' => 'Transaksi',
            'icon' => 'fa-solid fa-cart-shopping',
            'children' => [
                ['label' => 'Entry Penjualan', 'route' => 'admin.transaksi.entry-penjualan'],
                ['label' => 'Daftar Penjualan', 'route' => 'admin.transaksi.daftar-penjualan'],
                ['label' => 'Entry Pembelian', 'route' => 'admin.transaksi.entry-pembelian'],
                ['label' => 'Daftar Pembelian', 'route' => 'admin.transaksi.daftar-pembelian'],
                ['label' => 'Hutang', 'route' => 'admin.transaksi.hutang'],
                ['label' => 'Piutang', 'route' => 'admin.transaksi.piutang'],
            ],
        ],
        [
            'label' => 'Produksi',
            'icon' => 'fa-solid fa-industry',
            'children' => [
                ['label' => 'Update Produksi', 'route' => 'admin.produksi.update-produksi'],
                ['label' => 'Update Desain', 'route' => 'admin.produksi.update-desain'],
            ],
        ],
        [
            'label' => 'Keuangan',
            'icon' => 'fa-solid fa-wallet',
            'children' => [
                ['label' => 'Arus Kas', 'route' => 'admin.keuangan.kas'],
                ['label' => 'Laba Rugi', 'route' => 'admin.keuangan.laba-rugi'],
                ['label' => 'Pengeluaran', 'route' => 'admin.keuangan.pengeluaran-lainnya'],
            ],
        ],
        [
            'label' => 'Konten',
            'icon' => 'fa-solid fa-images',
            'children' => [
                ['label' => 'Mitra', 'route' => 'admin.konten.mitra'],
                ['label' => 'Produk', 'route' => 'admin.konten.produk'],
                ['label' => 'Portofolio', 'route' => 'admin.konten.portofolio'],
                ['label' => 'Testimoni', 'route' => 'admin.konten.testimoni'],
            ],
        ],
        [
            'label' => 'Laporan',
            'icon' => 'fa-solid fa-file-lines',
            'children' => [
                ['label' => 'Laporan Barang', 'route' => 'admin.laporan.barang'],
                ['label' => 'Laporan Penjualan', 'route' => 'admin.laporan.penjualan'],
                ['label' => 'Laporan Pembelian', 'route' => 'admin.laporan.pembelian'],
                ['label' => 'Laporan Laba Rugi', 'route' => 'admin.laporan.keuangan'],
                ['label' => 'Laporan Arus Kas', 'route' => 'admin.laporan.arus-kas'],
                ['label' => 'Laporan Stok', 'route' => 'admin.laporan.stok'],
                ['label' => 'Laporan Hutang', 'route' => 'admin.laporan.hutang'],
                ['label' => 'Laporan Piutang', 'route' => 'admin.laporan.piutang'],
            ],
        ],
        [
            'label' => 'User',
            'icon' => 'fa-solid fa-users-gear',
            'children' => [
                ['label' => 'Manajemen Role', 'route' => 'admin.user.role'],
                ['label' => 'Histori Pengguna', 'route' => 'admin.user.histori'],
                ['label' => 'Manajemen Pengguna', 'route' => 'admin.user.pengguna'],
            ],
        ],
        [
            'label' => 'Grafik',
            'icon' => 'fa-solid fa-chart-column',
            'route' => 'admin.grafik.index',
        ],
        [
            'label' => 'Tools',
            'icon' => 'fa-solid fa-screwdriver-wrench',
            'children' => [
                ['label' => 'Generate Barcode', 'route' => 'admin.tools.generate-barcode'],
                ['label' => 'Backup Data', 'route' => 'admin.tools.backup-data'],
            ],
        ],
    ];
@endphp

<div
    x-show="sidebarOpen"
    class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"
    x-transition.opacity
    @click="sidebarOpen = false"
></div>

<aside
    class="fixed inset-y-0 left-0 z-40 w-[280px] -translate-x-full border-r border-slate-200 bg-white transition-transform duration-200 lg:static lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : ''"
>
    <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
        <img src="{{ asset('assets/images/logo-mudain-icon.png') }}" alt="Mudain" class="h-10 w-10 rounded-xl bg-orange-100 p-2">
        <div>
            <p class="text-sm font-semibold text-slate-500">Sistem Informasi</p>
            <p class="text-lg font-bold text-slate-900">Mudain</p>
        </div>
    </div>

    <nav class="h-[calc(100vh-80px)] space-y-2 overflow-y-auto px-4 py-5">
        @foreach ($menu as $item)
            @if (isset($item['children']))
                @php
                    $activeGroup = collect($item['children'])->contains(fn ($child) => request()->routeIs($child['route']));
                @endphp
                <div x-data="{ open: {{ $activeGroup ? 'true' : 'false' }} }" class="rounded-2xl border border-slate-200/80 bg-slate-50/70">
                    <button
                        type="button"
                        class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold text-slate-700"
                        @click="open = !open"
                    >
                        <span class="flex items-center gap-3">
                            <i class="{{ $item['icon'] }} text-orange-500"></i>
                            {{ $item['label'] }}
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="space-y-1 border-t border-slate-200 px-3 py-3">
                        @foreach ($item['children'] as $child)
                            <a
                                href="{{ route($child['route']) }}"
                                class="block rounded-xl px-3 py-2 text-sm {{ request()->routeIs($child['route']) ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-600 hover:bg-white hover:text-slate-900' }}"
                            >
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a
                    href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ request()->routeIs($item['route']) ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-700 hover:bg-slate-100' }}"
                >
                    <i class="{{ $item['icon'] }}"></i>
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </nav>
</aside>
