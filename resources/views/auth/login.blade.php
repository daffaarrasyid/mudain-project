<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard Admin - Mudain</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Animasi Kustom untuk interaktifitas */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased overflow-x-hidden">

    <div class="min-h-screen flex flex-col md:flex-row relative">

        <div
            class="absolute inset-0 md:relative md:w-1/2 bg-gradient-to-br from-[#E65C00] to-[#F9D423] flex flex-col justify-between px-6 py-10 md:px-12 md:py-10 z-0 overflow-hidden">

            <div class="z-10 flex justify-center md:justify-start sm:mb-2 animate-fade-in-up">
                <img src="{{ asset('assets/images/logo-mudain.png') }}" alt="icon" class="w-48 h-16 object-contain">
            </div>

            <div class="hidden md:flex z-10 flex-grow items-center justify-center animate-fade-in-up delay-200 mt-10">
                <img src="{{ asset('assets/images/model-mudain.png') }}" alt="Model Mudain"
                    class="max-w-[85%] object-contain drop-shadow-2xl animate-float transition-transform duration-500 hover:scale-105"
                    onerror="this.src='https://via.placeholder.com/400x500.png/E65C00/FFFFFF?text=Masukkan+Gambar+Model'">
            </div>

            <div
                class="z-10 text-center text-white/90 md:text-white/80 text-xs md:text-sm animate-fade-in-up delay-300">
                <p>Copyright © Sistem Aplikasi Managament Perusahaan Mudain</p>
                <p>Project 2026 @kreasiin</p>
            </div>

            <div class="absolute top-1/4 -right-20 w-64 h-32 bg-[#A03D00] rounded-full rotate-45 opacity-40 blur-sm">
            </div>
            <div class="absolute bottom-1/4 left-10 w-48 h-24 bg-[#A03D00] rounded-full -rotate-45 opacity-40 blur-sm">
            </div>
        </div>

        <div
            class="relative z-20 w-full min-h-screen md:min-h-0 md:w-[55%] flex items-center justify-center px-5 py-24 md:py-0 md:bg-white md:rounded-l-[3.5rem] md:-ml-12 md:shadow-[-15px_0_30px_rgba(0,0,0,0.1)]">

            <div
                class="w-full max-w-md bg-white md:bg-transparent p-8 sm:p-12 rounded-[2rem] md:rounded-none shadow-[0_20px_50px_rgba(0,0,0,0.15)] md:shadow-none opacity-0 animate-fade-in-up delay-200">

                <h2 class="text-3xl sm:text-4xl font-bold text-[#E65C00] mb-10 text-center md:text-left">
                    Login Dashboard Admin
                </h2>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-[#E65C00]">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Username/Email"
                            class="w-full px-5 py-3.5 bg-[#F4F4F4] border border-transparent rounded-xl 
                                      focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] focus:bg-white 
                                      transition-all duration-300 outline-none text-gray-800"
                            required>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-[#E65C00]">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan Password"
                            class="w-full px-5 py-3.5 bg-[#F4F4F4] border border-transparent rounded-xl 
                                      focus:ring-2 focus:ring-[#E65C00]/50 focus:border-[#E65C00] focus:bg-white 
                                      transition-all duration-300 outline-none text-gray-800"
                            required>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full mt-8 py-3.5 px-4 bg-gradient-to-r from-[#E65C00] to-[#F9D423] 
                                   hover:from-[#cc5200] hover:to-[#e6c321] text-white font-bold text-lg rounded-xl 
                                   shadow-lg hover:shadow-[#E65C00]/40 transform hover:-translate-y-1 
                                   transition-all duration-300 active:scale-95">
                        Masuk
                    </button>
                </form>

            </div>
        </div>

    </div>
</body>

</html>
