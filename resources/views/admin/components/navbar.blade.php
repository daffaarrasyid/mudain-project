<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                type="button"
                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 text-slate-700 lg:hidden"
                @click="sidebarOpen = true"
            >
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <p class="text-sm text-slate-500">Panel Admin</p>
                <h1 class="text-xl font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()?->nama_user }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()?->role?->nama_role ?? 'Pengguna' }}</p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-100 font-bold text-orange-700">
                {{ strtoupper(substr(auth()->user()?->nama_user ?? 'M', 0, 1)) }}
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
