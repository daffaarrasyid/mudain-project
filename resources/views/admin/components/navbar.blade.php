<div x-data="{ profileOpen: false, modalLogout: false }">
    <header class="w-full bg-white px-6 py-2 flex items-center justify-between md:justify-end shadow-sm relative z-40">
        
        <button @click="sidebarOpen = true" class="md:hidden text-gray-600 hover:text-[#E65C00] focus:outline-none">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>

        <div class="flex items-center space-x-6 px-5 py-2 relative">       
            <div @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-3 border-l border-gray-200 pl-4 cursor-pointer group">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Dadang' }}&background=E65C00&color=fff" alt="Profile" class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm transition-transform group-hover:scale-105">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'Dadang' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role->nama ?? 'Super Admin' }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-gray-400 ml-1 transition-transform duration-300" :class="profileOpen ? 'rotate-180' : ''"></i>
            </div>

            <div x-show="profileOpen" style="display: none;"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="absolute right-4 top-[3.5rem] w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                 
                 <button @click="modalLogout = true; profileOpen = false" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 font-semibold transition-colors flex items-center gap-3">
                     <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                 </button>
            </div>
        </div>
    </header>

    <div x-show="modalLogout" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center m-auto" @click.away="modalLogout = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <i class="fa-solid fa-arrow-right-from-bracket text-3xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Logout</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin keluar saat ini?</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button @click="modalLogout = false" class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">Batal</button>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>