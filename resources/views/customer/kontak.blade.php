@extends('customer.layouts.app')

@section('content')
    <header class="relative w-full h-[400px] md:h-[500px] flex flex-col items-center justify-center fade-in-up is-visible">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/kontak.png') }}" 
                 alt="Contact Background" class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-[#f84a00] mix-blend-multiply opacity-80"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/10"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 -mt-16 md:-mt-24">
            <h1 class="text-4xl md:text-5xl lg:text-[64px] font-bold text-white mb-4 drop-shadow-lg tracking-tight">
                Kontak
            </h1>
            <p class="text-orange-50 text-lg md:text-xl font-medium drop-shadow-md max-w-xl mx-auto">
                Mari bisa berkomunikasi dengan kami agar terjalin kerjasama yang harmonis
            </p>
        </div>
    </header>

    <section class="container mx-auto px-4 md:px-6 lg:px-12 relative z-20 -mt-24 md:-mt-32 mb-32 fade-in-up delay-100">
        <div class="bg-white rounded-[30px] shadow-2xl overflow-hidden flex flex-col lg:flex-row">
            
            <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Hubungi kami</h2>
                <p class="text-gray-500 mb-10 text-[15px] leading-relaxed max-w-sm">
                    Agar memudahkan kerjasama yang kedepannya bisa terjalin dengan baik
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 shrink-0 bg-brand text-white rounded-full flex items-center justify-center text-xl shadow-md transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Kantor Pusat</h4>
                            <p class="text-gray-500 text-[14px] leading-relaxed">Jalan Nuri No. 47, Rancamanyar Regency 2, Kel. Rancamanyar, Kec. Baleendah, Kab. Bandung, Jawa Barat 40375</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 shrink-0 bg-brand text-white rounded-full flex items-center justify-center text-xl shadow-md transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Email Kami</h4>
                            <div class="flex flex-col text-gray-500 text-[14px]">
                                <a href="mailto:Mudakita.id@gmail.com" class="hover:text-brand transition-colors">Mudakita.id@gmail.com</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 shrink-0 bg-brand text-white rounded-full flex items-center justify-center text-xl shadow-md transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Nomor Kami</h4>
                            <div class="flex flex-col text-gray-500 text-[14px]">
                                <a href="tel:085174339047" class="hover:text-brand transition-colors">Telepon : +62 851-7433-9047</a>
                                <a href="https://wa.me/6285174339047" target="_blank" class="hover:text-brand transition-colors">WhatsApp : +62 851-7433-9047</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 shrink-0 bg-brand text-white rounded-full flex items-center justify-center text-xl shadow-md transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Website</h4>
                            <div class="flex flex-col text-gray-500 text-[14px]">
                                <a href="https://mudain.my.id" target="_blank" class="hover:text-brand transition-colors">mudain.my.id</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h4 class="font-bold text-gray-800 text-lg mb-4">Ikuti Sosial Media Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" target="_blank" class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center text-lg shadow-md transform hover:-translate-y-1 hover:bg-[#cc4c0e] transition-all duration-300">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center text-lg shadow-md transform hover:-translate-y-1 hover:bg-[#cc4c0e] transition-all duration-300">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center text-lg shadow-md transform hover:-translate-y-1 hover:bg-[#cc4c0e] transition-all duration-300">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center text-lg shadow-md transform hover:-translate-y-1 hover:bg-[#cc4c0e] transition-all duration-300">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 min-h-[400px] lg:min-h-auto relative bg-gray-200">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.276418804618!2d107.59604151477323!3d-6.976722894959664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9273180490b%3A0xcba2ed23a3b0439!2sJl.%20Nuri%20No.47%2C%20Rancamanyar%2C%20Kec.%20Baleendah%2C%20Kabupaten%20Bandung%2C%20Jawa%20Barat%2040375!5e0!3m2!1sen!2sid!4v1689000000000!5m2!1sen!2sid" 
                    class="absolute inset-0 w-full h-full border-0 grayscale-[0.2] hover:grayscale-0 transition-all duration-500" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </section>
@endsection