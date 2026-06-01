@extends('customer.layouts.app')

@section('content')
    <header class="container mx-auto px-6 lg:px-12 pt-10 pb-24 flex flex-col md:flex-row items-center relative">
        <div class="md:w-1/2 pr-0 md:pr-10 z-10 fade-in-up is-visible">
            <p class="text-brand font-bold text-lg mb-4 tracking-wide">Satu Tempat, Beribu Karya</p>
            <h1 class="text-4xl md:text-5xl lg:text-[54px] font-bold text-brand leading-[1.15] mb-6">
                Support Penuh Buat Event & Organisasi Lo!
            </h1>
            <p class="text-gray-500 mb-10 text-[15px] leading-relaxed max-w-lg">
                Lagi cari sponsor merchandise? Mudain hadir dengan skema kemitraan yang fleksibel, kualitas jahitan kelas dunia, dan pengerjaan tepat waktu demi suksesnya proker lo.
            </p>
            <a href="https://wa.me/6285174339047?text=Halo%20Mudain,%20saya%20ingin%20berkolaborasi%20untuk%20pembuatan%20merchandise%20/%20pakaian" target="_blank" class="inline-block bg-brand hover:bg-[#cf4b0c] text-white font-semibold py-3.5 px-8 rounded-lg shadow-[0_8px_20px_rgba(232,87,17,0.3)] hover:shadow-[0_12px_25px_rgba(232,87,17,0.4)] transform hover:-translate-y-1 transition-all duration-300">
                Kolaborasi Sekarang
            </a>
        </div>
        
        <div class="md:w-1/2 mt-16 md:mt-0 relative flex justify-center items-center fade-in-up delay-200 is-visible">
            <img src="{{ asset('assets/images/anak-sekolah.png') }}" alt="Mahasiswa" class="relative z-10 w-full max-w-[800px] hover:scale-105 transition duration-500 drop-shadow-2xl">
        </div>
    </header>

    @php
        $features = [
            [
                'title' => 'Bahan Premium', 
                'desc' => 'Kami menyeleksi bahan kain kualitas premium berstandar tinggi untuk menjamin kenyamanan maksimal saat Anda memakainya seharian.',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>', 
                'delay' => 'delay-100'
            ],
            [
                'title' => 'Jahitan Rapi', 
                'desc' => 'Setiap detail pengerjaan dikerjakan oleh penjahit profesional berpengalaman demi menghasilkan jahitan presisi, kuat, dan awet.',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>', 
                'delay' => 'delay-200'
            ],
            [
                'title' => 'Beres Tepat Waktu', 
                'desc' => 'Kami berkomitmen penuh untuk menyelesaikan produksi pesanan secara on-time sesuai jadwal kesepakatan demi kelancaran event Anda.',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 
                'delay' => 'delay-300'
            ]
        ];
    @endphp

    <section class="container mx-auto px-6 lg:px-12 py-16 text-center">
        <div class="fade-in-up">
            <h2 class="text-[32px] font-bold text-[#4a4a4a] mb-2">Kenapa harus di Mudain?</h2>
            <div class="w-16 h-1 bg-brand mx-auto mb-16 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 lg:px-16">
            @foreach($features as $feature)
            <div class="bg-white p-10 rounded-[20px] shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_40px_rgba(232,87,17,0.15)] transform hover:-translate-y-3 transition-all duration-300 border border-gray-50 group fade-in-up {{ $feature['delay'] }}">
                <div class="bg-brand text-white w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $feature['svg'] !!}</svg>
                </div>
                <h3 class="text-[20px] font-bold text-dark mb-4">{{ $feature['title'] }}</h3>
                <p class="text-gray-400 text-[13px] leading-relaxed">
                    {{ $feature['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 py-16 text-center fade-in-up">
        <h2 class="text-[32px] font-bold text-[#4a4a4a] mb-2">Mitra kami</h2>
        <div class="w-16 h-1 bg-brand mx-auto mb-16 rounded-full"></div>
        <div class="overflow-hidden py-10 w-full">
            <div class="animate-scroll flex gap-12 lg:gap-20 items-center">
                @for ($i = 0; $i < 3; $i++)
                    @forelse($mitras as $mitra)
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_mitra }}" title="{{ $mitra->nama_mitra }}" 
                             class="img-logo h-16 md:h-20 opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500 object-contain">
                    @empty
                        <span class="text-gray-300 font-bold tracking-widest uppercase">Belum ada Mitra</span>
                    @endforelse
                @endfor
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 lg:px-12 py-20 text-center mb-10">
        <div class="fade-in-up">
            <h2 class="text-[32px] font-bold text-[#4a4a4a] mb-2">Testimoni</h2>
            <div class="w-16 h-1 bg-brand mx-auto mb-20 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-16 px-4">
            @forelse($testimonis as $index => $item)
                @php 
                    $delay = ($index + 1) * 100; 
                    // Logika selang-seling Oranye-Putih utuh 100%
                    $isOrange = $index % 2 !== 0; 
                @endphp
                
                <div class="relative px-6 pt-14 pb-8 rounded-[20px] shadow-[0_10px_30px_rgba(0,0,0,0.08)] transform hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(232,87,17,0.2)] transition-all duration-300 fade-in-up text-center group {{ $isOrange ? 'bg-brand' : 'bg-white' }}" style="transition-delay: {{ $delay }}ms">
                    
                    @if($item->foto_profil)
                        <img src="{{ asset('storage/' . $item->foto_profil) }}" alt="{{ $item->nama_customer }}" 
                             class="w-16 h-16 rounded-full border-[5px] border-white absolute -top-8 left-1/2 transform -translate-x-1/2 shadow-md object-cover bg-white">
                    @else
                        <div class="w-16 h-16 rounded-full border-[5px] border-white absolute -top-8 left-1/2 transform -translate-x-1/2 shadow-md bg-gray-200 flex items-center justify-center text-gray-400 text-2xl">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                    
                    <div class="flex justify-center mb-2 text-sm {{ $isOrange ? 'text-white' : 'text-brand' }}">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $item->rating)
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star opacity-50"></i> @endif
                        @endfor
                    </div>
                    
                    <h4 class="font-bold text-lg {{ $isOrange ? 'text-white' : 'text-dark' }}">{{ $item->nama_customer }}</h4>
                    <p class="text-[11px] mb-4 uppercase tracking-wider font-semibold {{ $isOrange ? 'text-orange-200' : 'text-gray-400' }}">{{ $item->jabatan ?? 'Customer' }}</p>
                    
                    <div class="text-4xl font-serif font-black mb-2 leading-none {{ $isOrange ? 'text-white opacity-40' : 'text-brand opacity-80' }}">"</div>
                    
                    <p class="text-[12px] leading-relaxed {{ $isOrange ? 'text-white' : 'text-gray-400' }}">
                        {{ $item->testimoni }}
                    </p>
                </div>
            @empty
                <div class="col-span-full text-gray-400 italic">Belum ada testimoni dari customer.</div>
            @endforelse
        </div>
    </section>
@endsection