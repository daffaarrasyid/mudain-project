@extends('admin.layouts.app')

@section('page-title', 'Daftar Penjualan')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Daftar Penjualan</h2>
                    <p class="mt-2 text-sm text-slate-500">Semua transaksi penjualan yang sudah tercatat pada sistem.</p>
                </div>
                <a href="{{ route('admin.transaksi.entry-penjualan') }}" class="rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Tambah Penjualan</a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice atau customer" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter</button>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Item</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $item->id_penjualan }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $item->tanggal->format('d M Y H:i') }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $item->pembeli?->nama_pembeli ?? 'Umum' }}</td>
                                <td class="px-4 py-4 text-slate-500">
                                    @foreach ($item->detailPenjualan as $detail)
                                        <div>{{ $detail->produk?->nama_produk }} x {{ $detail->jumlah }}</div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->status_pembayaran === 'tunai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $item->status_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-semibold text-slate-900">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5">{{ $items->links() }}</div>
        </div>
    </div>
@endsection
