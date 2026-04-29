@extends('customer.layouts.app')

@section('content')
    <section class="container mx-auto px-6 lg:px-12 pt-10 pb-16 text-center fade-in-up is-visible">
        <h2 class="text-[32px] font-bold text-[#4a4a4a] mb-2">Portofolio</h2>
        <div class="w-16 h-1 bg-brand mx-auto mb-10 rounded-full"></div>

        <div x-data="carouselComponent()" 
             x-init="startAutoPlay()" 
             @mouseenter="stopAutoPlay()" 
             @mouseleave="startAutoPlay()"
             class="relative w-full rounded-[30px] overflow-hidden shadow-2xl group bg-gray-100">
            
            <div class="flex transition-transform duration-700 ease-in-out" 
                 :style="`transform: translateX(-${currentIndex * 100}%)`">
                
                <div class="w-full shrink-0 relative aspect-[16/9] md:aspect-[21/9]">
                    <img src="{{ asset('assets/images/portofolio-1.png') }}" alt="Portofolio 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

                <div class="w-full shrink-0 relative aspect-[16/9] md:aspect-[21/9]">
                    <img src="{{ asset('assets/images/portofolio-2.png') }}" alt="Portofolio 2" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

                <div class="w-full shrink-0 relative aspect-[16/9] md:aspect-[21/9]">
                    <img src="{{ asset('assets/images/portofolio-3.png') }}" alt="Portofolio 3" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

            </div>

            <button @click="prev()" class="absolute left-5 top-1/2 transform -translate-y-1/2 bg-brand/90 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 hover:bg-brand hover:scale-110 transition-all duration-300 z-20 focus:outline-none">
                <i class="fa-solid fa-chevron-left text-xl"></i>
            </button>

            <button @click="next()" class="absolute right-5 top-1/2 transform -translate-y-1/2 bg-brand/90 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 hover:bg-brand hover:scale-110 transition-all duration-300 z-20 focus:outline-none">
                <i class="fa-solid fa-chevron-right text-xl"></i>
            </button>

            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goTo(index)" 
                            class="h-2.5 rounded-full transition-all duration-500 shadow-sm" 
                            :class="currentIndex === index ? 'bg-brand w-8' : 'bg-white/50 w-2.5 hover:bg-white'"></button>
                </template>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 py-10 pb-32 fade-in-up">
        <h2 class="text-[32px] font-bold text-[#4a4a4a] text-center mb-2">Produk Kami</h2>
        <div class="w-16 h-1 bg-brand mx-auto mb-10 rounded-full"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-[280px]">
            
            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 flex flex-col justify-end"
                 style="background: linear-gradient(149deg, #120A08 23.33%, #707070 97.22%);">
                <img src="{{ asset('assets/images/kaos.png') }}" alt="Kaos" class="absolute right-0 top-4 w-40 object-contain transform group-hover:scale-110 transition-transform duration-500 z-0">
                <div class="relative z-10 text-white mt-auto">
                    <p class="text-[11px] text-gray-400 mb-1">Gaskenn buat</p>
                    <h3 class="text-2xl font-bold leading-none mb-1">Kaos</h3>
                    <h2 class="text-3xl font-black text-transparent tracking-wider" style="-webkit-text-stroke: 1px rgba(255,255,255,0.4);">CUSTOM</h2>
                    <button class="mt-4 bg-brand text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-md hover:bg-[#cc4c0e] transition-colors">Pesan</button>
                </div>
            </div>

            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 flex flex-col justify-end"
                 style="background: linear-gradient(146deg, #F1BC32 5.55%, #FFE295 100%);">
                <img src="{{ asset('assets/images/jaket.png') }}" alt="Jaket" class="absolute right-0 top-0 w-44 object-contain transform group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 z-0">
                <div class="relative z-10 text-white mt-auto">
                    <p class="text-[11px] text-yellow-100 mb-1">Gaskenn buat</p>
                    <h3 class="text-2xl font-bold leading-none mb-1 text-white">Jaket</h3>
                    <h2 class="text-3xl font-black text-transparent tracking-wider" style="-webkit-text-stroke: 1px rgba(255,255,255,0.6);">CUSTOM</h2>
                    <button class="mt-4 bg-brand text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-md hover:bg-[#cc4c0e] transition-colors">Pesan</button>
                </div>
            </div>

            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 md:col-span-2 flex flex-col justify-center"
                 style="background: linear-gradient(126deg, #E54D0C 25.77%, #FA9C73 92.03%);">
                <img src="{{ asset('assets/images/lanyard.png') }}" alt="Lanyard" class="absolute -right-6 top-1/2 transform -translate-y-1/2 w-64 md:w-80 object-contain group-hover:scale-110 transition-transform duration-500 z-0">
                <div class="relative z-10 text-white w-1/2">
                    <p class="text-[12px] text-orange-200 mb-1">Gaskenn buat</p>
                    <h3 class="text-3xl font-bold leading-none mb-1">Lanyard ID Card</h3>
                    <h2 class="text-4xl font-black text-transparent tracking-wider mb-5" style="-webkit-text-stroke: 1.5px rgba(255,255,255,0.4);">CUSTOM</h2>
                    <button class="bg-white text-brand px-6 py-2 rounded-full text-sm font-bold shadow-md hover:bg-gray-100 transition-colors">Pesan</button>
                </div>
            </div>

            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 md:col-span-2 flex flex-col justify-end"
                 style="background: linear-gradient(126deg, #DEDEDE 25.77%, #CECECE 92.03%);">
                <div class="absolute right-4 bottom-4 flex gap-2 z-0 transform group-hover:scale-105 transition-transform duration-500 origin-bottom-right">
                    <img src="{{ asset('assets/images/pdh.png') }}" alt="PDH" class="w-72 md:w-80 object-contain">
                </div>
                <div class="relative z-10 text-dark mt-auto w-1/2">
                    <p class="text-[12px] text-gray-500 mb-1">Gaskenn buat</p>
                    <h3 class="text-3xl font-bold leading-none mb-1">Kemeja PDH</h3>
                    <h2 class="text-4xl font-black text-transparent tracking-wider mb-5" style="-webkit-text-stroke: 1.5px rgba(0,0,0,0.2);">CUSTOM</h2>
                    <button class="bg-brand text-white px-6 py-2 rounded-full text-sm font-bold shadow-md hover:bg-[#cc4c0e] transition-colors">Pesan</button>
                </div>
            </div>

            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 flex flex-col"
                 style="background: linear-gradient(180deg, #752E10 0%, #FFBB9E 100%);">
                <img src="{{ asset('assets/images/topi.png') }}" alt="Topi" class="absolute right-2 bottom-4 w-44 object-contain transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 z-0">
                <div class="relative z-10 text-white">
                    <p class="text-[11px] text-[#e0e5d5] mb-1">Gaskenn buat</p>
                    <h3 class="text-2xl font-bold leading-none mb-1">Topi</h3>
                    <h2 class="text-3xl font-black text-transparent tracking-wider" style="-webkit-text-stroke: 1px rgba(255,255,255,0.4);">CUSTOM</h2>
                    <button class="mt-4 bg-brand text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-md hover:bg-[#cc4c0e] transition-colors">Pesan</button>
                </div>
            </div>

            <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 col-span-1 flex flex-col"
                 style="background: linear-gradient(180deg, #ECEAD1 0%, #868577 100%);">
                <img src="{{ asset('assets/images/rompi.png') }}" alt="Rompi" class="absolute right-4 bottom-0 w-36 object-contain transform group-hover:scale-110 transition-transform duration-500 z-0 origin-bottom">
                <div class="relative z-10 text-white">
                    <p class="text-[11px] text-gray-50 mb-1">Gaskenn buat</p>
                    <h3 class="text-2xl font-bold leading-none mb-1">Rompi</h3>
                    <h2 class="text-3xl font-black text-transparent tracking-wider" style="-webkit-text-stroke: 1px rgba(255,255,255,0.4);">CUSTOM</h2>
                    <button class="mt-4 bg-brand text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-md hover:bg-[#cc4c0e] transition-colors">Pesan</button>
                </div>
            </div>

        </div>
    </section>

    <script>
        function carouselComponent() {
            return {
                currentIndex: 0,
                // Array slides (sesuaikan angka dengan jumlah foto)
                slides: [0, 1, 2], 
                autoPlayInterval: null,
                
                next() {
                    // Jika di slide terakhir, balik ke 0. Jika tidak, tambah 1.
                    this.currentIndex = (this.currentIndex === this.slides.length - 1) ? 0 : this.currentIndex + 1;
                },
                prev() {
                    // Jika di slide pertama, lompat ke terakhir.
                    this.currentIndex = (this.currentIndex === 0) ? this.slides.length - 1 : this.currentIndex - 1;
                },
                goTo(index) {
                    this.currentIndex = index;
                },
                startAutoPlay() {
                    // Hapus interval lama jika ada untuk mencegah tabrakan
                    this.stopAutoPlay();
                    // Set interval baru jalan setiap 5 detik
                    this.autoPlayInterval = setInterval(() => {
                        this.next();
                    }, 5000);
                },
                stopAutoPlay() {
                    if (this.autoPlayInterval) {
                        clearInterval(this.autoPlayInterval);
                    }
                }
            }
        }
    </script>
@endsection