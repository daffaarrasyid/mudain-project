@extends('admin.layouts.app')

@section('page-title', 'Hutang')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Data Hutang</h2>
            <p class="mt-2 text-sm text-slate-500">Pantau hutang pembelian, ubah status, dan catat pembayaran cicilan atau pelunasan.</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pemasok" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <select name="status" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option value="">Semua status</option>
                    @foreach (['belum_lunas', 'sebagian', 'lunas'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter</button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse ($items as $item)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="grid gap-6 lg:grid-cols-[1.1fr_1fr_1fr]">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Pembelian</p>
                            <h3 class="mt-1 text-lg font-bold text-slate-900">{{ $item->id_pembelian }}</h3>
                            <p class="mt-2 text-sm text-slate-600">{{ $item->pembelian?->pemasok?->nama_pemasok }}</p>
                            <p class="text-sm text-slate-500">Tanggal: {{ $item->tanggal->format('d M Y H:i') }}</p>
                            <p class="mt-3 text-sm text-slate-500">Total hutang: <span class="font-semibold text-slate-900">Rp {{ number_format($item->jumlah_hutang, 0, ',', '.') }}</span></p>
                            <p class="text-sm text-slate-500">Sisa: <span class="font-semibold text-rose-600">Rp {{ number_format($item->sisa, 0, ',', '.') }}</span></p>
                        </div>

                        <form action="{{ route('admin.transaksi.hutang.status', $item) }}" method="POST" class="space-y-3 rounded-2xl bg-slate-50 p-4">
                            @csrf
                            @method('PUT')
                            <h4 class="font-semibold text-slate-900">Ubah Status</h4>
                            <select name="status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                @foreach (['belum_lunas', 'sebagian', 'lunas'] as $status)
                                    <option value="{{ $status }}" @selected($item->status === $status)>{{ str_replace('_', ' ', $status) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">Simpan Status</button>
                        </form>

                        <form action="{{ route('admin.transaksi.hutang.bayar', $item) }}" method="POST" class="space-y-3 rounded-2xl bg-slate-50 p-4">
                            @csrf
                            <h4 class="font-semibold text-slate-900">Pembayaran Hutang</h4>
                            <input type="number" name="jumlah_bayar" min="0.01" step="0.01" placeholder="Jumlah bayar" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                            <input type="date" name="tanggal" value="{{ now()->toDateString() }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                            <input type="text" name="keterangan" placeholder="Keterangan" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                            <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Bayar Hutang</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">
                    Belum ada data hutang.
                </div>
            @endforelse
        </div>

        <div>{{ $items->links() }}</div>
    </div>
@endsection
