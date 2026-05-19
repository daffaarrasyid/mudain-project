@extends('admin.layouts.app')

@section('content')
    <style>
        @keyframes slideUpFade {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-animasi-1 {
            animation: slideUpFade 0.8s ease-out 0.1s both;
        }

        .card-animasi-2 {
            animation: slideUpFade 0.8s ease-out 0.2s both;
        }

        .card-animasi-3 {
            animation: slideUpFade 0.8s ease-out 0.3s both;
        }

        .card-animasi-4 {
            animation: slideUpFade 0.8s ease-out 0.4s both;
        }

        .card-animasi-5 {
            animation: slideUpFade 0.8s ease-out 0.5s both;
        }
    </style>

    <div class="w-full min-w-0">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 animate-[fadeIn_0.5s_ease-in-out]">
            <div>
                <h1 class="text-2xl font-black text-gray-800">Dashboard Analitik</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan performa bisnis berdasarkan periode.</p>
            </div>

            <form method="GET" action="{{ route('admin.grafik.index') }}" class="w-full md:w-auto">
                <div
                    class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl shadow-sm border border-gray-100 hover:border-[#E65C00] transition-colors">
                    <i class="fa-solid fa-calendar-days text-[#E65C00]"></i>
                    <select name="periode" onchange="this.form.submit()"
                        class="bg-transparent text-sm font-bold text-gray-800 focus:outline-none cursor-pointer w-full">
                        <option value="hari_ini" {{ $periode == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ $periode == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ $periode == 'tahun_ini' ? 'selected' : '' }}>Tahun Keseluruhan</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="card-animasi-1 lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Tren Arus Kas (Pendapatan vs Pengeluaran)</h2>
                <div class="relative h-[300px] md:h-[350px] w-full">
                    <canvas id="pendapatanChart"></canvas>
                </div>
            </div>

            <div class="card-animasi-2 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Performa Kategori (Konveksi vs Percetakan)</h2>
                <div class="relative h-[250px] w-full">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            <div class="card-animasi-3 lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Proporsi Kas</h2>
                <div class="relative h-[250px] w-full flex items-center justify-center">
                    <canvas id="kasChart"></canvas>
                </div>
            </div>

            <div class="card-animasi-4 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">10 Barang Terlaris (Berdasarkan QTY)</h2>
                <div class="relative h-[250px] w-full">
                    <canvas id="terlarisChart"></canvas>
                </div>
            </div>

            <div class="card-animasi-5 lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Kesehatan Piutang</h2>
                <p class="text-[11px] text-gray-400 mb-5">Rasio Transaksi Lunas vs Kredit</p>
                <div class="relative h-[220px] w-full flex items-center justify-center">
                    <canvas id="pembayaranChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <script>
        const dataPendapatan = @json($chartPendapatan);
        const totalMasuk = {{ $totalMasuk }};
        const totalKeluar = {{ $totalKeluar }};
        const dataTerlaris = @json($chartTerlaris);
        const valKonveksi = {{ $chartKategori['Konveksi'] }};
        const valPercetakan = {{ $chartKategori['Percetakan'] }};
        const valLunas = {{ $chartPembayaran['Lunas'] }};
        const valKredit = {{ $chartPembayaran['Kredit'] }};
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Poppins', sans-serif";
            Chart.defaults.color = '#9CA3AF';

            // 1. Line Chart Pendapatan
            new Chart(document.getElementById('pendapatanChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: dataPendapatan.labels.length ? dataPendapatan.labels : ['Belum ada data'],
                    datasets: [{
                            label: 'Pemasukan (Rp)',
                            data: dataPendapatan.masuk.length ? dataPendapatan.masuk : [0],
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Pengeluaran (Rp)',
                            data: dataPendapatan.keluar.length ? dataPendapatan.keluar : [0],
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.05)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        y: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => 'Rp ' + (v / 1000).toLocaleString() + 'k'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 2. Bar Chart Kategori
            new Chart(document.getElementById('kategoriChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Konveksi', 'Percetakan'],
                    datasets: [{
                        data: [valKonveksi, valPercetakan],
                        backgroundColor: ['#E65C00', '#38BDF8'],
                        borderRadius: 8,
                        barThickness: 80
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1500,
                        easing: 'easeOutBounce'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 3. Doughnut Kas
            new Chart(document.getElementById('kasChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        data: [totalMasuk, totalKeluar],
                        backgroundColor: ['#10B981', '#EF4444'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    animation: {
                        animateRotate: true,
                        duration: 2000
                    }
                }
            });

            // 4. Bar Chart Terlaris
            new Chart(document.getElementById('terlarisChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dataTerlaris.labels.length ? dataTerlaris.labels : ['Kosong'],
                    datasets: [{
                        data: dataTerlaris.data.length ? dataTerlaris.data : [0],
                        backgroundColor: '#8B5CF6',
                        borderRadius: 6,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        y: {
                            duration: 2000,
                            easing: 'easeOutBack',
                            delay: ctx => ctx.dataIndex * 50
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 5. Doughnut Status Pembayaran (Insight Baru)
            new Chart(document.getElementById('pembayaranChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Lunas', 'Kredit / Piutang'],
                    datasets: [{
                        data: [valLunas, valKredit],
                        backgroundColor: ['#3B82F6', '#F59E0B'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    animation: {
                        animateScale: true,
                        duration: 2000
                    }
                }
            });

        });
    </script>
@endsection
