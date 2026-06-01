<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudain - Sahabat Terbaik Organisasimu</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#e85711', dark: '#2d2d2d', },
                    fontFamily: { poppins: ['Poppins', 'sans-serif'], }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; background-color: #fcfcfc; }
        
        /* Custom Scroll Animation */
        .fade-in-up { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .fade-in-up.is-visible { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        /* Infinite Scroll Mitra */
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-scroll { display: flex; width: max-content; animation: scroll 20s linear infinite; }
        .animate-scroll:hover { animation-play-state: paused; }
        .img-logo { flex-shrink: 0; }
    </style>
</head>
<body class="text-gray-800">

    @include('customer.layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('customer.layouts.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.15 };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, observerOptions);

            const animatedElements = document.querySelectorAll('.fade-in-up');
            animatedElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>