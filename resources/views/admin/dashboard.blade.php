@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @php
                $cards = [
                    ['label' => 'Total Produk', 'value' => $ringkasan['produk'], 'icon' => 'fa-box', 'color' => 'orange'],
                    ['label' => 'Total Supplier', 'value' => $ringkasan['pemasok'], 'icon' => 'fa-truck', 'color' => 'sky'],
                    ['label' => 'Total Customer', 'value' => $ringkasan['pembeli'], 'icon' => 'fa-users', 'color' => 'emerald'],
                    ['label' => 'Penjualan Hari Ini', 'value' => $ringkasan['penjualan_hari_ini'], 'icon' => 'fa-cash-register', 'color' => 'violet'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                            <p class="mt-3 text-4xl font-black text-slate-900">{{ number_format($card['value']) }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-{{ $card['color'] }}-100 text-{{ $card['color'] }}-600">
                            <i class="fa-solid {{ $card['icon'] }} text-xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Kas Masuk Hari Ini</p>
                <p class="mt-3 text-3xl font-black text-emerald-600">Rp {{ number_format($ringkasan['kas_masuk_hari_ini'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Kas Keluar Hari Ini</p>
                <p class="mt-3 text-3xl font-black text-rose-600">Rp {{ number_format($ringkasan['kas_keluar_hari_ini'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Saldo Kas Keseluruhan</p>
                <p class="mt-3 text-3xl font-black text-slate-900">Rp {{ number_format($ringkasan['saldo_kas'], 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.6fr_1fr]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Grafik Penjualan</h3>
                    <p class="text-sm text-slate-500">Ringkasan penjualan per bulan.</p>
                </div>
                <div class="h-80">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Aktivitas Terbaru</h3>
                    <p class="text-sm text-slate-500">Riwayat penggunaan sistem terbaru.</p>
                </div>
                <div class="space-y-4">
                    @forelse ($aktivitas as $log)
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                            <p class="text-sm font-semibold text-slate-800">{{ $log->aktivitas }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $log->pengguna?->nama_user ?? 'Sistem' }} • {{ $log->waktu->format('d M Y H:i') }}</p>
                            @if ($log->detail)
                                <p class="mt-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($log->detail, 100) }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Grafik Arus Kas</h3>
                <div class="mt-4 h-72">
                    <canvas id="chartKas"></canvas>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Grafik Laba Rugi</h3>
                <div class="mt-4 h-72">
                    <canvas id="chartLabaRugi"></canvas>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Produk per Kategori</h3>
                <div class="mt-4 space-y-4">
                    @foreach ($kategoriChart as $kategori)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-700">{{ $kategori->nama_kategori }}</span>
                                <span class="text-slate-500">{{ $kategori->produk_count }} produk</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-orange-500" style="width: {{ max(8, min(100, $kategori->produk_count * 10)) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const chartPenjualan = @json($chartPenjualan);
        const chartArusKas = @json($chartArusKas);
        const chartLabaRugi = @json($chartLabaRugi);

        new Chart(document.getElementById('chartPenjualan'), {
            type: 'line',
            data: {
                labels: chartPenjualan.labels,
                datasets: [{
                    label: 'Penjualan',
                    data: chartPenjualan.data,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.12)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('chartKas'), {
            type: 'bar',
            data: {
                labels: chartArusKas.labels,
                datasets: [
                    { label: 'Kas Masuk', data: chartArusKas.masuk, backgroundColor: '#10b981' },
                    { label: 'Kas Keluar', data: chartArusKas.keluar, backgroundColor: '#ef4444' }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('chartLabaRugi'), {
            type: 'line',
            data: {
                labels: chartLabaRugi.labels,
                datasets: [{
                    label: 'Laba / Rugi',
                    data: chartLabaRugi.data,
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
