@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
    .card-animasi-2 { animation: slideUpFade 0.8s ease-out 0.3s both; }
    .card-animasi-3 { animation: slideUpFade 0.8s ease-out 0.5s both; }
    .card-animasi-4 { animation: slideUpFade 0.8s ease-out 0.7s both; }
</style>

<div class="space-y-6">
    
    <div class="card-animasi-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#E65C00] rounded-2xl p-6 text-white shadow-lg shadow-orange-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-shirt text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Produk</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="{{ $totalProduk }}">0</h3>
            </div>
        </div>
        <div class="bg-[#3B82F6] rounded-2xl p-6 text-white shadow-lg shadow-blue-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-truck text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Supplier</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="{{ $totalSupplier }}">0</h3>
            </div>
        </div>
        <div class="bg-[#10B981] rounded-2xl p-6 text-white shadow-lg shadow-green-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-users text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Pelanggan</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="{{ $totalCustomer }}">0</h3>
            </div>
        </div>
        <div class="bg-[#8B5CF6] rounded-2xl p-6 text-white shadow-lg shadow-purple-500/30 flex justify-between items-center transform hover:-translate-y-1 transition duration-300">
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fa-solid fa-shopping-basket text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white/80 text-sm font-medium">Penjualan Hari Ini</p>
                <h3 class="text-4xl font-bold counter-animate" data-target="{{ $penjualanHariIni }}">0</h3>
            </div>
        </div>
    </div>

    <div class="card-animasi-2 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-8 shadow-sm flex items-center space-x-6 border border-gray-100">
            <div class="bg-orange-100 text-[#E65C00] p-5 rounded-2xl">
                <i class="fa-solid fa-arrow-right-to-bracket text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 font-medium">Kas Masuk Hari Ini</p>
                <h2 class="text-3xl font-extrabold text-gray-800 mt-1">Rp. <span class="counter-animate" data-target="{{ $kasMasukHariIni }}">0</span></h2>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-sm flex items-center space-x-6 border border-gray-100">
            <div class="bg-orange-100 text-[#E65C00] p-5 rounded-2xl">
                <i class="fa-solid fa-arrow-right-from-bracket text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 font-medium">Kas Keluar Hari Ini</p>
                <h2 class="text-3xl font-extrabold text-gray-800 mt-1">Rp. <span class="counter-animate" data-target="{{ $kasKeluarHariIni }}">0</span></h2>
            </div>
        </div>
    </div>

    <div class="card-animasi-3 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">History Login</h3>
            <div class="space-y-5">
                @forelse($historis as $histori)
                <div class="flex justify-between items-center pb-3 border-b border-gray-50 last:border-0 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-300">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($histori->user)->name ?? 'User') }}&background=E65C00&color=fff" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ optional($histori->user)->name ?? 'User (Terhapus)' }}</p>
                            <p class="text-xs text-gray-500">{{ optional(optional($histori->user)->role)->nama ?? 'Administrator' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800 text-sm">{{ optional($histori->created_at)->format('H:i:s') }}</p>
                        <p class="text-xs text-gray-500">{{ optional($histori->created_at)->format('Y-m-d') }}</p>
                    </div>
                </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-5">Belum ada history</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Grafik Pendapatan</h3>
                <select class="chart-filter bg-gray-50 border border-gray-200 text-xs rounded-lg px-3 py-1.5 outline-none cursor-pointer" data-chart="pendapatan">
                    <option value="minggu_ini">Minggu Ini</option>
                    <option value="bulan_ini" selected>Bulan Ini</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card-animasi-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Grafik Kategori Produk</h3>
                <select class="chart-filter bg-gray-50 border border-gray-200 text-xs rounded-lg px-3 py-1.5 outline-none cursor-pointer" data-chart="kategori">
                    <option value="minggu_ini">Minggu Ini</option>
                    <option value="bulan_ini" selected>Bulan Ini</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Grafik Kas</h3>
                <select class="chart-filter bg-gray-50 border border-gray-200 text-xs rounded-lg px-3 py-1.5 outline-none cursor-pointer" data-chart="kas">
                    <option value="minggu_ini">Minggu Ini</option>
                    <option value="bulan_ini" selected>Bulan Ini</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
            </div>
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
        const animationDuration = 2000; 

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const start = 0;
            let startTime = null;

            function updateCounter(currentTime) {
                if (!startTime) startTime = currentTime;
                const progress = Math.min((currentTime - startTime) / animationDuration, 1);
                
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentVal = Math.floor(easeOutQuart * (target - start) + start);
                
                counter.innerText = currentVal.toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target.toLocaleString('id-ID'); 
                }
            }
            requestAnimationFrame(updateCounter);
        });

        // ==========================================
        // 2. INIT CHART & AJAX LIVE FILTERING
        // ==========================================
        
        // Line Chart (Pendapatan)
        const lineChart = new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: { labels: [], datasets: [
                { label: 'Pemasukan', data: [], borderColor: '#E65C00', backgroundColor: 'rgba(230, 92, 0, 0.2)', tension: 0.4, fill: true, pointBackgroundColor: '#fff', pointBorderColor: '#E65C00', pointRadius: 4 },
                { label: 'Pengeluaran', data: [], borderColor: '#8B5CF6', backgroundColor: 'rgba(139, 92, 246, 0.2)', tension: 0.4, fill: true, pointBackgroundColor: '#fff', pointBorderColor: '#8B5CF6', pointRadius: 4 }
            ]},
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } }, animation: { duration: 2500, easing: 'easeOutQuart' } }
        });

        // Bar Chart (Kategori Produk)
        const barChart = new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: { labels: [], datasets: [{ data: [], backgroundColor: ['#E65C00', '#38BDF8'], borderRadius: 8 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } }, animation: { duration: 1500 } }
        });

        // Doughnut Chart (Kas)
        const pieChart = new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'doughnut',
            data: { labels: [], datasets: [{ data: [], backgroundColor: ['#A78BFA', '#F87171'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } }, cutout: '60%', animation: { animateScale: true, animateRotate: true, duration: 2000, easing: 'easeInOutCirc' } }
        });

        // Fetch Data via AJAX
        function loadChartData(chartName, filterValue, chartInstance) {
            fetch(`{{ route('admin.dashboard.chart-data') }}?chart=${chartName}&filter=${filterValue}`)
                .then(res => res.json())
                .then(resData => {
                    chartInstance.data.labels = resData.labels;
                    if(chartName === 'pendapatan') {
                        chartInstance.data.datasets[0].data = resData.datasets[0].data;
                        chartInstance.data.datasets[1].data = resData.datasets[1].data;
                    } else {
                        chartInstance.data.datasets[0].data = resData.data;
                    }
                    chartInstance.update();
                });
        }

        // Trigger filter otomatis saat halaman dimuat dan saat diubah
        document.querySelectorAll('.chart-filter').forEach(select => {
            select.addEventListener('change', function() {
                let chartType = this.dataset.chart;
                let instance = chartType === 'pendapatan' ? lineChart : (chartType === 'kategori' ? barChart : pieChart);
                loadChartData(chartType, this.value, instance);
            });
            select.dispatchEvent(new Event('change')); // Execute once
        });

    });
</script>
@endpush