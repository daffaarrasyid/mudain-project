@extends('admin.layouts.app')

@section('page-title', 'Grafik')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Grafik Bisnis</h2>
                    <p class="mt-2 text-sm text-slate-500">Visualisasi arus kas, penjualan, dan laba rugi per tahun.</p>
                </div>
                <form method="GET" class="flex gap-3">
                    <input type="number" min="2020" max="2100" name="tahun" value="{{ $tahun }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Tampilkan</button>
                </form>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Arus Kas {{ $tahun }}</h3>
                <div class="mt-4 h-80">
                    <canvas id="chartKasTahunan"></canvas>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Penjualan {{ $tahun }}</h3>
                <div class="mt-4 h-80">
                    <canvas id="chartPenjualanTahunan"></canvas>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900">Laba Rugi {{ $tahun }}</h3>
            <div class="mt-4 h-80">
                <canvas id="chartLabaRugiTahunan"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const grafikKas = @json($chartArusKas);
        const grafikPenjualan = @json($chartPenjualan);
        const grafikLabaRugi = @json($chartLabaRugi);

        new Chart(document.getElementById('chartKasTahunan'), {
            type: 'bar',
            data: {
                labels: grafikKas.labels,
                datasets: [
                    { label: 'Kas Masuk', data: grafikKas.masuk, backgroundColor: '#10b981' },
                    { label: 'Kas Keluar', data: grafikKas.keluar, backgroundColor: '#ef4444' },
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('chartPenjualanTahunan'), {
            type: 'line',
            data: {
                labels: grafikPenjualan.labels,
                datasets: [{
                    label: 'Penjualan',
                    data: grafikPenjualan.data,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('chartLabaRugiTahunan'), {
            type: 'line',
            data: {
                labels: grafikLabaRugi.labels,
                datasets: [{
                    label: 'Laba / Rugi',
                    data: grafikLabaRugi.data,
                    borderColor: '#0f172a',
                    backgroundColor: 'rgba(15, 23, 42, 0.08)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>
@endpush
