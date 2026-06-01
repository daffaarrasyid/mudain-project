<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Mudain</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
    </style>
</head>
<body class="text-gray-800 antialiased overflow-hidden" x-data="{ sidebarOpen: false, sidebarHover: false }">

    <div class="flex h-screen w-full bg-[#F4F6F9]">
        
        @include('admin.components.sidebar')

        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            
            @include('admin.components.navbar')

            <main class="flex-1 md:ml-[5.5rem] overflow-x-hidden overflow-y-auto bg-[#F4F6F9] p-4 md:p-6 lg:p-8 animate-[fadeIn_0.5s_ease-in-out]">
                @yield('content')
            </main>
        </div>
            
    </div>

    @stack('scripts')
</body>
</html>