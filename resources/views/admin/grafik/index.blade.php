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

<div class="w-full min-w-0">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="card-animasi-1 lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Pendapatan Bulan Ini</h2>
            <div class="relative h-[300px] md:h-[400px] w-full">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>

        <div class="card-animasi-2 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Kategori Barang</h2>
            <div class="relative h-[250px] md:h-[300px] w-full">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>

        <div class="card-animasi-3 lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Kas</h2>
            <div class="relative h-[250px] md:h-[300px] w-full flex items-center justify-center">
                <canvas id="kasChart"></canvas>
            </div>
        </div>

        <div class="card-animasi-4 lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">10 Barang Terlaris Bulan Ini</h2>
            <div class="relative h-[300px] md:h-[400px] w-full">
                <canvas id="terlarisChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = '#9CA3AF'; 

        // 1. Grafik Pendapatan
        const ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
        new Chart(ctxPendapatan, {
            type: 'line',
            data: {
                labels: ['02', '06', '08', '12', '15', '20', '22', '23', '24', '26', '28', '30'],
                datasets: [{
                    label: 'Pendapatan (Juta)',
                    data: [5, 3, 17, 2, 7, 18, 6, 2, 28, 9, 21, 4],
                    borderColor: '#FF8A8A', 
                    backgroundColor: 'rgba(255, 138, 138, 0.15)', 
                    borderWidth: 2,
                    fill: true, 
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart' // Efek melambat secara smooth di akhir
                },
                plugins: { legend: { display: false } }, 
                scales: {
                    y: { beginAtZero: true, max: 30, ticks: { callback: function(v) { return v + 'jt'; } } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Grafik Kategori Barang
        const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
        new Chart(ctxKategori, {
            type: 'bar',
            data: {
                labels: ['Konveksi', 'Percetakan'],
                datasets: [{
                    label: 'Total Kategori',
                    data: [60, 100],
                    backgroundColor: ['#34D399', '#38BDF8'], 
                    borderRadius: 8, 
                    barThickness: 80
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce' // Membuat balok sedikit memantul saat naik
                },
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100 },
                    x: { grid: { display: false } }
                }
            }
        });

        // 3. Grafik Kas Pie
        const ctxKas = document.getElementById('kasChart').getContext('2d');
        new Chart(ctxKas, {
            type: 'pie',
            data: {
                labels: ['Masuk', 'Keluar', 'Lainnya'],
                datasets: [{
                    data: [50, 20, 30],
                    backgroundColor: ['#38BDF8', '#A78BFA', '#FF8A8A'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true, // Animasi memutar
                    animateScale: true,  // Animasi membesar
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false } 
                }
            }
        });

        // 4. Grafik Barang Terlaris
        const ctxTerlaris = document.getElementById('terlarisChart').getContext('2d');
        new Chart(ctxTerlaris, {
            type: 'line',
            data: {
                labels: ['Lanyard', 'Kemeja', 'PDH Biasa', 'Medali', 'Gantungan', 'PDH 2 in 1', 'Kaos', 'Jaket', 'WorkShirt', 'Stiker'],
                datasets: [
                    {
                        label: 'Minggu 1',
                        data: [0, 30, 2, 30, 1, 2, 18, 0, 30, 1],
                        borderColor: '#A78BFA', backgroundColor: 'rgba(167, 139, 250, 0.1)',
                        borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0
                    },
                    {
                        label: 'Minggu 2',
                        data: [20, 15, 10, 15, 20, 20, 0, 0, 18, 20],
                        borderColor: '#FF8A8A', backgroundColor: 'rgba(255, 138, 138, 0.1)',
                        borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0
                    },
                    {
                        label: 'Minggu 3',
                        data: [0, 0, 10, 0, 10, 10, 10, 5, 0, 0],
                        borderColor: '#38BDF8', backgroundColor: 'rgba(56, 189, 248, 0.1)',
                        borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2500,
                    easing: 'easeOutQuart'
                },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
                },
                scales: {
                    y: { beginAtZero: true, max: 35 },
                    x: { grid: { display: false } }
                }
            }
        });

    });
</script>
@endsection