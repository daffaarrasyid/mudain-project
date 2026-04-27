@extends('admin.layouts.app')

@section('page-title', 'Arus Kas')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Kas Masuk</p>
                <p class="mt-3 text-3xl font-black text-emerald-600">Rp {{ number_format($ringkasan['masuk'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Kas Keluar</p>
                <p class="mt-3 text-3xl font-black text-rose-600">Rp {{ number_format($ringkasan['keluar'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Saldo</p>
                <p class="mt-3 text-3xl font-black text-slate-900">Rp {{ number_format($ringkasan['saldo'], 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-4">
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <select name="jenis" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option value="">Semua jenis</option>
                    @foreach (['penjualan', 'pembelian', 'pembayaran_hutang', 'pembayaran_piutang', 'pengeluaran_lain'] as $jenis)
                        <option value="{{ $jenis }}" @selected(request('jenis') === $jenis)>{{ str_replace('_', ' ', ucfirst($jenis)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter Kas</button>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Arah</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-4 py-4 text-slate-700">{{ $item->tanggal->format('d M Y H:i') }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ str_replace('_', ' ', $item->jenis) }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->arah === 'masuk' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $item->arah }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-semibold text-slate-900">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-slate-500">{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada data arus kas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">{{ $items->links() }}</div>
        </div>
    </div>
@endsection
