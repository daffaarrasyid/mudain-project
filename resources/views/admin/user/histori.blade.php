@extends('admin.layouts.app')

@section('content')
<div x-data="{
        modalLog: false,
        logDesc: '',
        logUser: '',
        logRole: '',
        logAction: '',
        logModule: '',
        logIp: '',
        logTime: '',
        logBg: '',
        logText: '',
        logBorder: '',
        logIcon: '',
        openLog(desc, user, role, action, module, ip, time, bg, text, border, icon) {
            this.logDesc   = desc;
            this.logUser   = user;
            this.logRole   = role;
            this.logAction = action;
            this.logModule = module;
            this.logIp     = ip;
            this.logTime   = time;
            this.logBg     = bg;
            this.logText   = text;
            this.logBorder = border;
            this.logIcon   = icon;
            this.modalLog  = true;
        }
     }"
    class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Histori Aktivitas Pengguna</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua log login, logout, dan perubahan data sistem</p>
        </div>
        <div class="flex flex-col items-end gap-3 w-full md:w-auto mt-4 md:mt-0">
            <div class="flex items-center gap-3 w-full justify-end">
                <span class="text-xs text-gray-400 hidden sm:block">
                    Total: <span class="font-bold text-gray-600">{{ $logs->total() }}</span> log
                </span>
                @if($logs->total() > 0)
                <form action="{{ route('admin.user.histori.clear') }}" method="POST"
                    onsubmit="return confirm('Yakin hapus semua log aktivitas? Tindakan ini tidak bisa dibatalkan.')" class="w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                        <i class="fa-solid fa-trash-can"></i> Hapus Semua Log
                    </button>
                </form>
                @endif
            </div>
            
            @if($logs->total() > 0)
            <a href="{{ route('admin.user.histori.export') }}" target="_blank" id="btnExportPdf"
                class="w-full sm:w-auto bg-[#FF0000] hover:bg-[#CC0000] text-white px-4 py-2 rounded-lg text-xs font-bold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </a>
            @endif
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-5">

        {{-- Tampilkan Dropdown --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 justify-start">
            <span>Tampilkan</span>
            <select id="perPageSelect" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-[#E65C00] focus:border-[#E65C00] block py-2 px-3 outline-none cursor-pointer">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>

        {{-- Search Real-time --}}
        <div class="relative flex-1">
            <input type="text" id="searchInput" value="{{ request('search') }}"
                placeholder="Cari nama, aktivitas, modul, deskripsi..."
                class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] transition-colors">
            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <button id="clearSearch" type="button" style="display:none;"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        {{-- Filter Aktivitas --}}
        <select id="filterAction" onchange="applyFilters()"
            class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] appearance-none min-w-[150px] cursor-pointer">
            <option value="">Semua Aktivitas</option>
            <option value="Login"     {{ request('action') === 'login'  ? 'selected' : '' }}>Login</option>
            <option value="Logout"    {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
            <option value="Tambah Data" {{ request('action') === 'create' ? 'selected' : '' }}>Tambah Data</option>
            <option value="Ubah Data"   {{ request('action') === 'update' ? 'selected' : '' }}>Ubah Data</option>
            <option value="Hapus Data"  {{ request('action') === 'delete' ? 'selected' : '' }}>Hapus Data</option>
            <option value="Ekspor"      {{ request('action') === 'export' ? 'selected' : '' }}>Ekspor</option>
        </select>

        {{-- Filter Modul --}}
        <select id="filterModule" onchange="applyFilters()"
            class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#E65C00] appearance-none min-w-[160px] cursor-pointer">
            <option value="">Semua Modul</option>
            @foreach($modules as $mod)
            <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
            @endforeach
        </select>

        {{-- Tombol Filter --}}
        <button type="button" onclick="applyFilters()"
            class="bg-[#E65C00] hover:bg-[#cc5200] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all transform hover:-translate-y-0.5 shadow-lg shadow-orange-500/20 whitespace-nowrap flex items-center gap-2">
            <i class="fa-solid fa-filter text-xs"></i> Filter
        </button>

        {{-- Tombol Reset --}}
        <button type="button" id="resetFilter"
            class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors whitespace-nowrap flex items-center gap-2">
            <i class="fa-solid fa-xmark text-xs"></i> Reset
        </button>
    </div>

    {{-- Hasil pencarian info --}}
    <div id="searchInfo" class="hidden mb-3 text-xs text-gray-400 flex items-center gap-1.5">
        <i class="fa-solid fa-circle-info"></i>
        <span id="searchInfoText"></span>
    </div>

    {{-- Table --}}
    <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-100">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
            <thead>
                <tr class="text-gray-700 text-sm font-bold border-b-2 border-gray-100 bg-gray-50">
                    <th class="px-5 py-4">#</th>
                    <th class="px-5 py-4">Pengguna</th>
                    <th class="px-5 py-4">Role</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                    <th class="px-5 py-4">Modul</th>
                    <th class="px-5 py-4">Deskripsi</th>
                    <th class="px-5 py-4">IP Address</th>
                    <th class="px-5 py-4">Waktu</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse($logs as $i => $log)
                @php $color = $log->actionColor; @endphp
                <tr class="data-row border-b border-gray-50 even:bg-gray-50/50 hover:bg-orange-50/30 transition-colors"
                    data-search="{{ strtolower($log->user_name.' '.$log->user_role.' '.$log->actionLabel.' '.$log->module.' '.$log->description.' '.$log->ip_address) }}"
                    data-action="{{ $log->actionLabel }}"
                    data-module="{{ $log->module }}">
                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $logs->firstItem() + $i }}</td>

                    {{-- Pengguna --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-[#E65C00]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[10px] font-bold text-[#E65C00]">
                                    {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                </span>
                            </div>
                            <span class="font-semibold text-gray-700">{{ $log->user_name ?? '-' }}</span>
                        </div>
                    </td>

                    {{-- Role --}}
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 border border-gray-200 px-2.5 py-1 rounded-md text-xs font-semibold">
                            <i class="fa-solid fa-user-shield text-[#E65C00] text-[9px]"></i>
                            {{ $log->user_role ?? '-' }}
                        </span>
                    </td>

                    {{-- Badge Aksi --}}
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 {{ $color['bg'] }} {{ $color['text'] }} border {{ $color['border'] }} px-2.5 py-1.5 rounded-lg text-[11px] font-bold">
                            <i class="fa-solid {{ $color['icon'] }} text-[9px]"></i>
                            {{ $log->actionLabel }}
                        </span>
                    </td>

                    {{-- Modul --}}
                    <td class="px-5 py-4">
                        @if($log->module)
                        <span class="text-xs text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded">{{ $log->module }}</span>
                        @else
                        <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>

                    {{-- Deskripsi (klik → modal) --}}
                    <td class="px-5 py-4">
                        <button @click="openLog(
                            '{{ addslashes($log->description) }}',
                            '{{ addslashes($log->user_name ?? '-') }}',
                            '{{ addslashes($log->user_role ?? '-') }}',
                            '{{ $log->actionLabel }}',
                            '{{ addslashes($log->module ?? '-') }}',
                            '{{ $log->ip_address ?? '-' }}',
                            '{{ $log->created_at->format('d M Y, H:i:s') }}',
                            '{{ $color['bg'] }}',
                            '{{ $color['text'] }}',
                            '{{ $color['border'] }}',
                            '{{ $color['icon'] }}'
                        )"
                            class="flex items-center gap-1.5 text-xs text-[#E65C00] hover:text-[#cc5200] font-medium hover:underline underline-offset-2 transition-colors group max-w-[200px] text-left">
                            <span class="truncate">{{ Str::limit($log->description, 35) }}</span>
                            <i class="fa-solid fa-up-right-from-square text-[9px] opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0"></i>
                        </button>
                    </td>

                    {{-- IP --}}
                    <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $log->ip_address ?? '-' }}</td>

                    {{-- Waktu --}}
                    <td class="px-5 py-4 text-gray-500 text-xs whitespace-nowrap">
                        <div class="font-medium">{{ $log->created_at->format('d M Y') }}</div>
                        <div class="text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                        <i class="fa-solid fa-clock-rotate-left text-4xl mb-3 block opacity-30"></i>
                        <p class="text-sm font-medium">Belum ada aktivitas tercatat.</p>
                        <p class="text-xs mt-1">Log akan muncul setelah ada pengguna yang login atau melakukan perubahan data.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between mt-5 text-sm text-gray-500 gap-3">
        <div>
            Menampilkan <span class="font-bold text-gray-700">{{ $logs->firstItem() ?? 0 }}</span> sampai
            <span class="font-bold text-gray-700">{{ $logs->lastItem() ?? 0 }}</span> dari
            <span class="font-bold text-[#E65C00]">{{ $logs->total() }}</span> log aktivitas
        </div>
        <div class="flex items-center gap-1 text-sm">
            @if($logs->onFirstPage())
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                @if ($page == $logs->currentPage())
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-[#E65C00] text-white font-bold shadow-md">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm">{{ $page }}</a>
                @endif
            @endforeach

            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-[#E65C00] hover:text-white transition-colors shadow-sm"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-300 bg-gray-50 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
    </div>

    {{-- Modal Detail Log --}}
    <div x-show="modalLog" style="display:none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 m-auto"
            @click.away="modalLog = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

            {{-- Header Modal --}}
            <div class="flex justify-between items-start mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                        :class="logBg">
                        <i class="fa-solid text-lg" :class="[logIcon, logText]"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Detail Aktivitas</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md border"
                            :class="[logBg, logText, logBorder]" x-text="logAction"></span>
                    </div>
                </div>
                <button @click="modalLog = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Info Grid --}}
            <div class="space-y-3 mb-5">
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                    <i class="fa-solid fa-user text-[#E65C00] text-sm mt-0.5 w-4 flex-shrink-0"></i>
                    <div>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Pengguna</p>
                        <p class="text-sm font-semibold text-gray-700" x-text="logUser"></p>
                        <p class="text-xs text-gray-400" x-text="logRole"></p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                    <i class="fa-solid fa-layer-group text-[#E65C00] text-sm mt-0.5 w-4 flex-shrink-0"></i>
                    <div>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Modul</p>
                        <p class="text-sm font-semibold text-gray-700" x-text="logModule"></p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 bg-orange-50 border border-orange-100 rounded-xl">
                    <i class="fa-solid fa-file-lines text-[#E65C00] text-sm mt-0.5 w-4 flex-shrink-0"></i>
                    <div>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Deskripsi Aktivitas</p>
                        <p class="text-sm text-gray-800 font-medium leading-relaxed" x-text="logDesc"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                        <i class="fa-solid fa-network-wired text-gray-400 text-sm mt-0.5 w-4 flex-shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">IP Address</p>
                            <p class="text-xs font-mono font-semibold text-gray-600" x-text="logIp"></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                        <i class="fa-solid fa-clock text-gray-400 text-sm mt-0.5 w-4 flex-shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Waktu</p>
                            <p class="text-xs font-semibold text-gray-600" x-text="logTime"></p>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" @click="modalLog = false"
                class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition-colors">
                Tutup
            </button>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchInput');
    const filterAction = document.getElementById('filterAction');
    const filterModule = document.getElementById('filterModule');
    const clearBtn     = document.getElementById('clearSearch');
    const resetBtn     = document.getElementById('resetFilter');
    const searchInfo   = document.getElementById('searchInfo');
    const searchInfoTx = document.getElementById('searchInfoText');
    const rows         = document.querySelectorAll('.data-row');

    function applyFilters() {
        const keyword = searchInput.value.toLowerCase().trim();
        const action  = filterAction.value.toLowerCase();
        const module  = filterModule.value.toLowerCase();

        let visible = 0;

        rows.forEach(row => {
            const text       = row.dataset.search || '';
            const rowAction  = (row.dataset.action || '').toLowerCase();
            const rowModule  = (row.dataset.module || '').toLowerCase();

            const matchSearch = !keyword || text.includes(keyword);
            const matchAction = !action  || rowAction === action;
            const matchModule = !module  || rowModule === module;

            if (matchSearch && matchAction && matchModule) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle tombol clear pada search input
        if (clearBtn) clearBtn.style.display = keyword ? 'block' : 'none';

        // Tampilkan/sembunyikan tombol Reset utama
        const isFiltered = keyword || action || module;
        if (resetBtn) resetBtn.style.display = isFiltered ? 'flex' : 'none';

        // Info jumlah hasil
        if (isFiltered) {
            if (searchInfo) searchInfo.classList.remove('hidden');
            if (searchInfoTx) searchInfoTx.textContent = `Menampilkan ${visible} dari ${rows.length} log pada halaman ini`;
        } else {
            if (searchInfo) searchInfo.classList.add('hidden');
        }

        // Update URL tombol export
        const btnExport = document.getElementById('btnExportPdf');
        if (btnExport) {
            let exportUrl = new URL("{{ route('admin.user.histori.export') }}");
            if (keyword) exportUrl.searchParams.set('search', searchInput.value.trim()); // Original text
            if (action) exportUrl.searchParams.set('action', filterAction.value);
            if (module) exportUrl.searchParams.set('module', filterModule.value);
            btnExport.href = exportUrl.toString();
        }
    }

    // Ekspos ke global scope agar bisa dipanggil dari onclick di HTML
    window.applyFilters = applyFilters;

    // Live search saat mengetik
    if (searchInput) searchInput.addEventListener('input', applyFilters);

    // Tombol clear (×) di dalam input search
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            applyFilters();
            searchInput.focus();
        });
    }

    // Tombol Reset — bersihkan semua filter sekaligus
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            searchInput.value    = '';
            filterAction.value   = '';
            filterModule.value   = '';
            applyFilters();
            searchInput.focus();
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

    // Sembunyikan tombol Reset saat awal load (jika tidak ada filter aktif)
    if (resetBtn) resetBtn.style.display = 'none';

    // Jalankan filter saat load jika ada nilai awal dari URL
    applyFilters();
});
</script>
@endpush
@endsection
