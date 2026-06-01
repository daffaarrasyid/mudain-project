@extends('customer.layouts.app')

@section('content')
    <header class="relative w-full h-[450px] md:h-[600px] flex items-center justify-center fade-in-up is-visible">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Team" class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-brand mix-blend-multiply opacity-70"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>
        </div>
        
        <div class="relative z-10 text-center px-4">
            <h1 class="text-5xl md:text-6xl lg:text-[72px] font-bold text-white mb-4 drop-shadow-2xl tracking-tight">
                Tentang kami
            </h1>
            <p class="text-orange-50 text-xl md:text-2xl font-medium drop-shadow-md">
                CV. Muda Karya Indonesia
            </p>
        </div>
    </header>

    <section class="container mx-auto px-6 lg:px-12 py-24 flex flex-col lg:flex-row items-center gap-16">
        
        <div class="w-full lg:w-1/2 relative h-[450px] fade-in-up">
            <img src="{{ asset('assets/images/gambar1.jpg') }}" alt="Dashboard" class="absolute top-0 left-0 w-3/4 h-[280px] object-cover rounded-3xl shadow-lg z-10 transform hover:scale-105 transition-transform duration-500">
            <img src="{{ asset('assets/images/gambar2.jpg') }}" alt="Professional" class="absolute bottom-0 right-0 w-3/5 h-[240px] object-cover rounded-3xl shadow-[0_20px_40px_rgba(0,0,0,0.2)] z-20 border-4 border-white transform hover:scale-105 transition-transform duration-500 delay-100">
            
            <div class="absolute top-1/2 left-[55%] transform -translate-x-1/2 -translate-y-1/2 bg-brand text-white p-6 md:p-8 rounded-3xl shadow-[0_15px_30px_rgba(232,87,17,0.4)] z-30 flex flex-col justify-center w-[180px] md:w-[220px] hover:-translate-y-[60%] transition-transform duration-300 cursor-default">
                <h3 class="text-4xl md:text-5xl font-bold mb-1"><span class="counter" data-target="5">0</span>+</h3>
                <p class="text-sm md:text-base font-medium leading-tight text-orange-100">Tahun<br>Pengalaman</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 fade-in-up delay-100">
            <p class="text-gray-500 font-medium mb-3 text-[15px]">Kenalan yukk!!!!</p>
            <h2 class="text-3xl md:text-4xl font-bold text-brand leading-tight mb-6">
                Bikin kaos & jaket di<br>Mudain aja
            </h2>
            <p class="text-gray-500 mb-8 leading-relaxed text-[15px]">
                Di Mudain kalian bebas mengkreasikan segala bentuk inovasi yang kalian punya, adapun beberapa barang yang bisa dicetak:
            </p>
            
            <div class="grid grid-cols-2 gap-y-3 gap-x-4 mb-10 text-brand font-medium text-[15px]">
                @php
                    $items = ['Kaos Custom', 'Kemeja Custom', 'Jaket Custom', 'Topi', 'Lanyard ID Card', 'dan lain-lain'];
                @endphp
                @foreach($items as $item)
                <div class="flex items-center hover:translate-x-2 transition-transform duration-200">
                    <span class="w-1.5 h-1.5 bg-brand rounded-full mr-3"></span> {{ $item }}
                </div>
                @endforeach
            </div>

            <button class="bg-brand hover:bg-[#cc4c0e] text-white font-semibold py-3 px-8 rounded-full shadow-[0_8px_20px_rgba(232,87,17,0.3)] hover:shadow-[0_12px_25px_rgba(232,87,17,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex items-center group">
                Tanya-tanya dulu 
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </section>

    <section class="bg-brand py-24 md:py-32 fade-in-up" id="stats-section">
        <div class="container mx-auto px-6 lg:px-12 grid grid-cols-2 md:grid-cols-4 gap-y-16 gap-x-8 divide-x-0 md:divide-x md:divide-orange-400/50">
            
            @php
                $stats = [
                    ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'num' => '5', 'label' => "Pengalaman di<br>industri tekstil"],
                    ['icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'num' => '200', 'label' => "Pesanan Selesai<br>dengan baik"],
                    ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'num' => '40', 'label' => "Reseller yang<br>bekerjasama"],
                    ['icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5', 'num' => '150', 'label' => "Pelanggan sangat<br>puas dengan kita"]
                ];
            @endphp

            @foreach($stats as $index => $stat)
            <div class="flex flex-col md:flex-row items-center justify-center text-center md:text-left text-white space-y-4 md:space-y-0 md:space-x-5 {{ $index > 0 ? 'pl-0 md:pl-8' : '' }} group">
                <div class="bg-white/20 p-5 rounded-2xl shadow-inner transform group-hover:rotate-12 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
                <div>
                    <h4 class="text-4xl font-extrabold leading-none"><span class="counter" data-target="{{ $stat['num'] }}">0</span>+</h4>
                    <p class="text-[13px] text-orange-100 font-semibold mt-2 uppercase tracking-wider leading-tight">{!! $stat['label'] !!}</p>
                </div>
            </div>
            @endforeach

        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 py-24 flex flex-col-reverse lg:flex-row items-center gap-16">
        <div class="w-full lg:w-1/2 fade-in-up" x-data="{ tab: 'misi' }">
            <p class="text-gray-400 font-medium mb-2 text-[15px]">Tujuan Kami</p>
            <h2 class="text-3xl md:text-4xl font-bold text-brand leading-tight mb-8">
                Memuaskan klien lokal<br>dan global
            </h2>
            
            <div class="flex flex-wrap gap-3 mb-8">
                <button @click="tab = 'misi'" :class="tab === 'misi' ? 'bg-brand text-white shadow-md' : 'bg-[#ffd9c7] text-brand hover:bg-brand hover:text-white shadow-sm hover:shadow-md'" class="px-8 py-2.5 rounded-full text-sm font-semibold transform hover:-translate-y-1 transition-all duration-300">Misi</button>
                <button @click="tab = 'visi'" :class="tab === 'visi' ? 'bg-brand text-white shadow-md' : 'bg-[#ffd9c7] text-brand hover:bg-brand hover:text-white shadow-sm hover:shadow-md'" class="px-8 py-2.5 rounded-full text-sm font-semibold transform hover:-translate-y-1 transition-all duration-300">Visi</button>
            </div>

            <div x-show="tab === 'misi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                <p class="text-gray-500 leading-relaxed text-[15px]">
                    Memberikan pelayanan terbaik dalam pembuatan pakaian seragam, memastikan kepuasan pelanggan, dan menjadi mitra terpercaya bagi setiap instansi dan perusahaan di Indonesia.
                </p>
            </div>
            
            <div x-show="tab === 'visi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <p class="text-gray-500 leading-relaxed text-[15px]">
                    Menjadi pelopor dan perusahaan konveksi terdepan di Indonesia yang berorientasi pada kualitas unggul, inovasi desain, dan kepuasan pelanggan secara global.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 fade-in-up delay-100 relative group overflow-hidden rounded-[30px] shadow-2xl">
            <img src="{{ asset('assets/images/gambar1.jpg') }}" alt="Dashboard Statistics" class="w-full h-[350px] object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
            <div class="absolute inset-0 bg-brand/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200; // Semakin rendah angkanya, semakin lambat animasinya

            const countUpObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const updateCount = () => {
                            const target = +counter.getAttribute('data-target');
                            const count = +counter.innerText;
                            const inc = target / speed;

                            if (count < target) {
                                counter.innerText = Math.ceil(count + inc);
                                setTimeout(updateCount, 15);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCount();
                        observer.unobserve(counter); // Jalanin animasinya sekali aja
                    }
                });
            }, { threshold: 0.5 }); // Jalanin pas 50% section statistik kelihatan

            counters.forEach(counter => {
                countUpObserver.observe(counter);
            });
        });
    </script>
@endsection