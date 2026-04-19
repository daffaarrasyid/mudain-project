<header class="w-full bg-white px-6 py-2 flex items-center justify-between md:justify-end shadow-sm relative z-30">
    
    <button @click="sidebarOpen = true" class="md:hidden text-gray-600 hover:text-[#E65C00] focus:outline-none">
        <i class="fa-solid fa-bars text-2xl"></i>
    </button>

    <div class="flex items-center space-x-6 px-5 py-2">
        <button class="relative text-gray-500 hover:text-gray-700 transition">
            <i class="fa-solid fa-bell text-xl"></i>
            <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] text-white border-2 border-white">5</span>
        </button>
        
        <div class="flex items-center space-x-3 border-l border-gray-200 pl-4 cursor-pointer">
            <img src="https://ui-avatars.com/api/?name=Dadang&background=E65C00&color=fff" alt="Profile" class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm">
            <div class="hidden sm:block text-right">
                <p class="text-sm font-bold text-gray-800 leading-tight">Dadang</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
    </div>
</header>