@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#E65C00] rounded-2xl p-6 text-white shadow-lg shadow-orange-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-shirt text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Produk</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="87">0</h3>
            </div>
        </div>
        <div class="bg-[#3B82F6] rounded-2xl p-6 text-white shadow-lg shadow-blue-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-truck text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Supplier</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="39">0</h3>
            </div>
        </div>
        <div class="bg-[#10B981] rounded-2xl p-6 text-white shadow-lg shadow-green-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-users text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Pelanggan</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="105">0</h3>
            </div>
        </div>
        <div class="bg-[#8B5CF6] rounded-2xl p-6 text-white shadow-lg shadow-purple-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-shopping-basket text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Penjualan Hari Ini</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="3">0</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-8 shadow-sm flex items-center space-x-6 border border-gray-100">
            <div class="bg-orange-100 text-[#E65C00] p-5 rounded-2xl">
                <i class="fa-solid fa-arrow-right-to-bracket text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 font-medium">Kas Masuk Hari Ini</p>
                <h2 class="text-3xl font-extrabold text-gray-800 mt-1">Rp. <span class="counter-animate" data-target="30000000">0</span></h2>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-sm flex items-center space-x-6 border border-gray-100">
            <div class="bg-orange-100 text-[#E65C00] p-5 rounded-2xl">
                <i class="fa-solid fa-arrow-right-from-bracket text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 font-medium">Kas Keluar Hari Ini</p>
                <h2 class="text-3xl font-extrabold text-gray-800 mt-1">Rp. <span class="counter-animate" data-target="789000">0</span></h2>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">History Login</h3>
            <div class="space-y-5">
                @for($i=0; $i<4; $i++)
                <div class="flex justify-between items-center pb-3 border-b border-gray-50 last:border-0 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-300">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name=Dadang&background=E65C00&color=fff" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Dadang</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800 text-sm">14:05:35</p>
                        <p class="text-xs text-gray-500">2026-03-29</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pendapatan Bulan Ini</h3>
            <div class="relative h-64 w-full">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Kategori Produk</h3>
            <div class="relative h-64 w-full">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Kas</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // ==========================================
        // 1. ANIMASI NUMBER COUNTER (ANGKA NAIK)
        // ==========================================
        const counters = document.querySelectorAll('.counter-animate');
        const animationDuration = 2000; // Durasi animasi 2 detik

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const start = 0;
            let startTime = null;

            function updateCounter(currentTime) {
                if (!startTime) startTime = currentTime;
                const progress = Math.min((currentTime - startTime) / animationDuration, 1);
                
                // Efek Ease-Out (mulai cepat, melambat di akhir)
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentVal = Math.floor(easeOutQuart * (target - start) + start);
                
                // Format angka menggunakan standar Indonesia (titik sebagai pemisah ribuan)
                counter.innerText = currentVal.toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target.toLocaleString('id-ID'); // Pastikan angka akhir presisi
                }
            }
            requestAnimationFrame(updateCounter);
        });

        // ==========================================
        // 2. ANIMASI CHART.JS YANG DIPERINDAH
        // ==========================================
        
        // Line Chart (Pendapatan)
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [30, 25, 75, 40, 60, 70, 30, 10, 90, 35, 80, 20],
                    borderColor: '#E65C00', backgroundColor: 'rgba(230, 92, 0, 0.2)',
                    tension: 0.4, fill: true, pointBackgroundColor: '#fff', pointBorderColor: '#E65C00', pointRadius: 4
                }, {
                    label: 'Pengeluaran',
                    data: [60, 45, 95, 50, 75, 80, 40, 25, 75, 90, 75, 45],
                    borderColor: '#8B5CF6', backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    tension: 0.4, fill: true, pointBackgroundColor: '#fff', pointBorderColor: '#8B5CF6', pointRadius: 4
                }]
            },
            options: { 
                responsive: true, maintainAspectRatio: false, 
                plugins: { legend: { position: 'bottom' } }, 
                scales: { y: { beginAtZero: true } },
                // Penambahan Animasi Smooth & lambat
                animation: {
                    duration: 2500, // 2.5 detik
                    easing: 'easeOutQuart'
                }
            }
        });

        // Bar Chart (Kategori Produk)
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Baju', 'PDH', 'Lanyard', 'Ganci'],
                datasets: [{
                    data: [3, 1, 7, 6],
                    backgroundColor: ['#E65C00', '#A78BFA', '#38BDF8', '#34D399'],
                    borderRadius: 8
                }]
            },
            options: { 
                responsive: true, maintainAspectRatio: false, 
                plugins: { legend: { display: false } }, 
                scales: { y: { beginAtZero: true } },
                // Penambahan Animasi Stagger (Bar muncul bergantian)
                animation: {
                    duration: 1500,
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 300; // Jeda 300ms antar batang grafik
                        }
                        return delay;
                    }
                }
            }
        });

        // Doughnut Chart (Kas)
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April'],
                datasets: [{
                    data: [100, 250, 700, 450],
                    backgroundColor: ['#A78BFA', '#F87171', '#38BDF8', '#FBBF24'],
                    borderWidth: 0
                }]
            },
            options: { 
                responsive: true, maintainAspectRatio: false, 
                plugins: { legend: { position: 'right' } }, cutout: '60%',
                // Penambahan Animasi Rotasi dan Skala
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeInOutCirc'
                }
            }
        });
    });
</script>
@endpush