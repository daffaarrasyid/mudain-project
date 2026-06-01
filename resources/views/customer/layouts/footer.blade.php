<div class="relative mt-32">
    <svg class="absolute top-[1px] w-full h-16 md:h-28 -mt-16 md:-mt-28 text-brand" preserveAspectRatio="none" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
        <path fill="currentColor" d="M0,0 C480,120 960,120 1440,0 L1440,120 L0,120 Z"></path>
    </svg>

    <footer class="bg-brand text-white pt-12 pb-6 px-6 lg:px-12">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 lg:gap-16 mb-16 px-4">
            
            <div>
                <img src="{{ asset('assets/images/mudain-putih.png') }}" alt="Logo Mudain" class="h-10 md:h-12 w-auto object-contain mb-3">
                <p class="text-white text-[13px] mb-6 font-medium">Sahabat Terbaik Organisasimu</p>
                <div class="flex space-x-4 text-xl">
                    <a href="https://instagram.com/mudain.my.id" target="_blank" class="hover:text-orange-200 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-orange-200 transition-colors"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="hover:text-orange-200 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="hover:text-orange-200 transition-colors"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-[16px] mb-5">Links</h4>
                <ul class="text-white text-[14px] space-y-3 font-medium">
                    <li><a href="/" class="hover:text-orange-200 hover:pl-1 transition-all duration-300">Beranda</a></li>
                    <li><a href="/tentang" class="hover:text-orange-200 hover:pl-1 transition-all duration-300">Tentang kami</a></li>
                    <li><a href="/produk" class="hover:text-orange-200 hover:pl-1 transition-all duration-300">Produk</a></li>
                    <li><a href="/kontak" class="hover:text-orange-200 hover:pl-1 transition-all duration-300">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-[16px] mb-5">Kontak</h4>
                <ul class="text-white text-[14px] space-y-3 font-medium">
                    <li class="hover:text-orange-200 transition duration-300"><a href="tel:085174339047">+62 851-7433-9047</a></li>
                    <li class="hover:text-orange-200 transition duration-300"><a href="mailto:Mudakita.id@gmail.com">Mudakita.id@gmail.com</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-[16px] mb-5">Alamat</h4>
                <p class="text-white text-[14px] leading-relaxed font-medium">
                    Jalan Nuri No. 47,<br>
                    Rancamanyar Regency 2, Kel. Rancamanyar,<br>
                    Kec. Baleendah, Kab. Bandung,<br>
                    Jawa Barat 40375
                </p>
            </div>
            
        </div>

        <div class="border-t border-[#f27a3c] pt-8 text-center text-white text-[13px] font-medium tracking-wide">
            Copyright &copy; {{ date('Y') }} CV Muda Kita Indonesia. All Rights Reserved.
        </div>
    </footer>
</div>