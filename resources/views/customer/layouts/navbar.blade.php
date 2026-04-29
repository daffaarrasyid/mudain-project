<nav class="container mx-auto px-6 lg:px-12 py-6 flex items-center justify-between fade-in-up is-visible relative z-50">
    <div class="text-3xl font-extrabold text-brand flex items-center cursor-pointer transform hover:scale-105 transition duration-300">
        <img src="{{ asset('assets/images/logo-mudain-orange.png') }}" alt="" class="h-10 md:h-12 w-auto object-contain">
    </div>

    <button id="navToggle" type="button" class="md:hidden inline-flex items-center justify-center rounded-full border border-gray-200 p-2 text-gray-600 hover:bg-gray-100 hover:text-brand transition duration-300 focus:outline-none focus:ring-2 focus:ring-brand">
        <span class="sr-only">Buka menu</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div id="desktopNav" class="hidden md:flex space-x-10 text-[15px] font-medium text-gray-400">
        <a href="{{ route('beranda') }}"
            class="relative group {{ request()->routeIs('beranda') ? 'text-dark font-semibold' : 'text-gray-400 hover:text-brand' }} transition duration-300">
            Beranda
            <span class="absolute left-0 -bottom-1 h-[2px] bg-brand transition-all duration-300 {{ request()->routeIs('beranda') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>
        <a href="{{ route('tentang') }}"
            class="relative group {{ request()->routeIs('tentang') ? 'text-dark font-semibold' : 'text-gray-400 hover:text-brand' }} transition duration-300">
            Tentang kami
            <span class="absolute left-0 -bottom-1 h-[2px] bg-brand transition-all duration-300 {{ request()->routeIs('tentang') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>
        <a href="{{ route('produk') }}" class="relative group {{ request()->routeIs('produk') ? 'text-dark font-semibold' : 'text-gray-400 hover:text-brand' }} transition duration-300">
            Produk
            <span class="absolute left-0 -bottom-1 h-[2px] bg-brand transition-all duration-300 {{ request()->routeIs('produk') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>
        <a href="{{ route('kontak') }}" class="relative group {{ request()->routeIs('kontak') ? 'text-dark font-semibold' : 'text-gray-400 hover:text-brand' }} transition duration-300">
            Kontak
            <span class="absolute left-0 -bottom-1 h-[2px] bg-brand transition-all duration-300 {{ request()->routeIs('kontak') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>
    </div>

    <div id="mobileNav" class="md:hidden hidden absolute left-0 right-0 top-full mt-4 z-50 rounded-3xl bg-white/95 shadow-xl border border-gray-100 backdrop-blur-xl p-5">
        <div class="flex flex-col gap-4 text-[15px] font-medium text-gray-700">
            <a href="{{ route('beranda') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('beranda') ? 'bg-brand text-white' : 'hover:bg-brand/10 hover:text-brand transition duration-300' }}">
                Beranda
            </a>
            <a href="{{ route('tentang') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('tentang') ? 'bg-brand text-white' : 'hover:bg-brand/10 hover:text-brand transition duration-300' }}">
                Tentang kami
            </a>
            <a href="{{ route('produk') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('produk') ? 'bg-brand text-white' : 'hover:bg-brand/10 hover:text-brand transition duration-300' }}">
                Produk
            </a>
            <a href="{{ route('kontak') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('kontak') ? 'bg-brand text-white' : 'hover:bg-brand/10 hover:text-brand transition duration-300' }}">
                Kontak
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileNav');

        navToggle.addEventListener('click', function() {
            mobileNav.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!mobileNav.contains(event.target) && !navToggle.contains(event.target)) {
                mobileNav.classList.add('hidden');
            }
        });
    });
</script>
