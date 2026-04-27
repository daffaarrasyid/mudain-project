@extends('admin.layouts.app')

@section('page-title', 'Laba Rugi')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Penjualan</p>
                <p class="mt-3 text-2xl font-black text-emerald-600">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Pembelian</p>
                <p class="mt-3 text-2xl font-black text-amber-600">Rp {{ number_format($ringkasan['total_pembelian'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Pengeluaran</p>
                <p class="mt-3 text-2xl font-black text-rose-600">Rp {{ number_format($ringkasan['total_pengeluaran'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Laba / Rugi</p>
                <p class="mt-3 text-2xl font-black text-slate-900">Rp {{ number_format($ringkasan['laba_rugi'], 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-3">
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter Laba Rugi</button>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Penjualan</th>
                            <th class="px-4 py-3">Pembelian</th>
                            <th class="px-4 py-3">Pengeluaran</th>
                            <th class="px-4 py-3">Laba / Rugi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-4 py-4 text-slate-700">{{ $item->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-4 text-emerald-600">Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-amber-600">Rp {{ number_format($item->total_pembelian, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-rose-600">Rp {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 font-semibold text-slate-900">Rp {{ number_format($item->laba_rugi, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada data laba rugi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5">{{ $items->links() }}</div>
        </div>
    </div>
@endsection
