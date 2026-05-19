@extends('customer.layouts.app')

@section('content')

    <section class="container mx-auto px-6 lg:px-12 pt-10 pb-16 text-center fade-in-up is-visible">
        <h2 class="text-[32px] font-bold text-[#4a4a4a] mb-2">Portofolio</h2>
        <div class="w-16 h-1 bg-brand mx-auto mb-10 rounded-full"></div>

        @if ($portofolios->count() > 0)
            <div x-data="carouselComponent({{ $portofolios->count() }})" x-init="startAutoPlay()" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()"
                class="relative w-full rounded-[30px] overflow-hidden shadow-2xl group bg-gray-100">

                <div class="flex transition-transform duration-700 ease-in-out"
                    :style="`transform: translateX(-${currentIndex * 100}%)`">

                    @foreach ($portofolios as $porto)
                        <div class="w-full shrink-0 relative aspect-[16/9] md:aspect-[21/9]">
                            <img src="{{ asset('storage/' . $porto->gambar) }}" alt="{{ $porto->nama_klien }}"
                                class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-black/20 flex flex-col justify-end p-8 text-left opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <h3 class="text-white text-2xl md:text-3xl font-bold">{{ $porto->nama_klien }}</h3>
                            </div>
                        </div>
                    @endforeach

                </div>

                @if ($portofolios->count() > 1)
                    <button @click="prev()"
                        class="absolute left-5 top-1/2 transform -translate-y-1/2 bg-brand/90 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 hover:bg-brand hover:scale-110 transition-all duration-300 z-20 focus:outline-none">
                        <i class="fa-solid fa-chevron-left text-xl"></i>
                    </button>
                    <button @click="next()"
                        class="absolute right-5 top-1/2 transform -translate-y-1/2 bg-brand/90 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 hover:bg-brand hover:scale-110 transition-all duration-300 z-20 focus:outline-none">
                        <i class="fa-solid fa-chevron-right text-xl"></i>
                    </button>

                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="goTo(index)" class="h-2.5 rounded-full transition-all duration-500 shadow-sm"
                                :class="currentIndex === index ? 'bg-brand w-8' : 'bg-white/50 w-2.5 hover:bg-white'"></button>
                        </template>
                    </div>
                @endif
            </div>
        @else
            <p class="text-gray-400 italic">Belum ada data portofolio.</p>
        @endif
    </section>

    <section class="container mx-auto px-6 lg:px-12 py-10 pb-32 fade-in-up">
        <h2 class="text-[32px] font-bold text-[#4a4a4a] text-center mb-2">Produk Kami</h2>
        <div class="w-16 h-1 bg-brand mx-auto mb-10 rounded-full"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-[280px]">
            @php
                $styles = [
                    [
                        'bg' => 'linear-gradient(149deg, #120A08 23.33%, #707070 97.22%)',
                        'imgClass' =>
                            'absolute right-0 top-4 w-40 object-contain transform group-hover:scale-110 transition-transform duration-500 z-0',
                        'col' => 'col-span-1 flex flex-col justify-end',
                        'textColor' => 'text-gray-400',
                        'btnClass' => 'bg-brand text-white',
                    ],
                    [
                        'bg' => 'linear-gradient(146deg, #F1BC32 5.55%, #FFE295 100%)',
                        'imgClass' =>
                            'absolute right-0 top-0 w-44 object-contain transform group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 z-0',
                        'col' => 'col-span-1 flex flex-col justify-end',
                        'textColor' => 'text-yellow-100',
                        'btnClass' => 'bg-brand text-white',
                    ],
                    [
                        'bg' => 'linear-gradient(126deg, #E54D0C 25.77%, #FA9C73 92.03%)',
                        'imgClass' =>
                            'absolute -right-6 top-1/2 transform -translate-y-1/2 w-64 md:w-80 object-contain group-hover:scale-110 transition-transform duration-500 z-0',
                        'col' => 'col-span-1 md:col-span-2 flex flex-col justify-center',
                        'textColor' => 'text-orange-200',
                        'btnClass' => 'bg-white text-brand',
                    ],
                    [
                        'bg' => 'linear-gradient(126deg, #DEDEDE 25.77%, #CECECE 92.03%)',
                        'imgClass' =>
                            'absolute right-4 bottom-4 w-72 md:w-80 object-contain transform group-hover:scale-105 transition-transform duration-500 origin-bottom-right z-0',
                        'col' => 'col-span-1 md:col-span-2 flex flex-col justify-end',
                        'textColor' => 'text-gray-500',
                        'btnClass' => 'bg-brand text-white',
                    ],
                    [
                        'bg' => 'linear-gradient(180deg, #752E10 0%, #FFBB9E 100%)',
                        'imgClass' =>
                            'absolute right-2 top-8 w-44 object-contain transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 z-0',
                        'col' => 'col-span-1 flex flex-col',
                        'textColor' => 'text-[#e0e5d5]',
                        'btnClass' => 'bg-brand text-white',
                    ],
                    [
                        'bg' => 'linear-gradient(180deg, #ECEAD1 0%, #868577 100%)',
                        'imgClass' =>
                            'absolute right-4 top-4 w-36 object-contain transform group-hover:scale-110 transition-transform duration-500 z-0 origin-bottom',
                        'col' => 'col-span-1 flex flex-col',
                        'textColor' => 'text-gray-50',
                        'btnClass' => 'bg-brand text-white',
                    ],
                ];
            @endphp

            @forelse($produks as $index => $produk)
                @php $style = $styles[$index % count($styles)]; @endphp
                <div class="relative rounded-[30px] p-8 overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 {{ $style['col'] }}"
                    style="background: {{ $style['bg'] }};">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}"
                        class="{{ $style['imgClass'] }}">
                    <div
                        class="relative z-10 {{ str_contains($style['col'], 'justify-center') || str_contains($style['bg'], '#DEDEDE') ? 'w-1/2' : '' }} mt-auto">
                        <p class="text-[11px] {{ $style['textColor'] }} mb-1 font-semibold tracking-wide">Gaskenn buat</p>
                        <h3
                            class="text-2xl md:text-3xl font-bold leading-none mb-1 {{ str_contains($style['bg'], '#DEDEDE') ? 'text-dark' : 'text-white' }}">
                            {{ $produk->nama_produk }}</h3>
                        <h2 class="text-3xl md:text-4xl font-black text-transparent tracking-wider mb-2"
                            style="-webkit-text-stroke: 1px rgba({{ str_contains($style['bg'], '#DEDEDE') ? '0,0,0,0.2' : '255,255,255,0.4' }});">
                            CUSTOM</h2>
                        <a href="https://wa.me/6281234567890?text=Halo%20Mudain,%20saya%20mau%20pesan%20{{ $produk->nama_produk }}%20Custom"
                            target="_blank"
                            class="inline-block mt-2 {{ $style['btnClass'] }} px-5 py-1.5 rounded-full text-sm font-semibold shadow-md hover:opacity-80 transition-opacity">Pesan</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-gray-400 italic text-center">Belum ada produk.</div>
            @endforelse
        </div>
    </section>

    <script>
        function carouselComponent(totalSlides) {
            return {
                currentIndex: 0,
                slides: Array.from({
                    length: totalSlides
                }, (_, i) => i),
                autoPlayInterval: null,
                next() {
                    if (this.slides.length > 0) this.currentIndex = (this.currentIndex === this.slides.length - 1) ? 0 :
                        this.currentIndex + 1;
                },
                prev() {
                    if (this.slides.length > 0) this.currentIndex = (this.currentIndex === 0) ? this.slides.length - 1 :
                        this.currentIndex - 1;
                },
                goTo(index) {
                    this.currentIndex = index;
                },
                startAutoPlay() {
                    if (this.slides.length > 1) {
                        this.stopAutoPlay();
                        this.autoPlayInterval = setInterval(() => {
                            this.next();
                        }, 5000);
                    }
                },
                stopAutoPlay() {
                    if (this.autoPlayInterval) clearInterval(this.autoPlayInterval);
                }
            }
        }
    </script>
@endsection
