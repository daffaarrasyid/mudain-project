@extends('admin.layouts.app')

@section('page-title', 'Stok In/Out')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Stok In/Out</h2>
            <p class="mt-2 text-sm text-slate-500">Catat penyesuaian stok masuk atau keluar dan pantau seluruh histori pergerakannya.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Catat Pergerakan Stok</h3>
                <form action="{{ route('admin.stok.store') }}" method="POST" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Produk</label>
                        <select name="id_produk" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                            <option value="">Pilih produk</option>
                            @foreach ($produkOptions as $produk)
                                <option value="{{ $produk->id_produk }}" @selected(old('id_produk') === $produk->id_produk)>
                                    {{ $produk->nama_produk }} (stok: {{ $produk->stok_aktif }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Arah</label>
                        <select name="arah" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                            <option value="masuk" @selected(old('arah') === 'masuk')>Stok Masuk</option>
                            <option value="keluar" @selected(old('arah') === 'keluar')>Stok Keluar</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Jumlah</label>
                        <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal</label>
                        <input type="datetime-local" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Keterangan</label>
                        <textarea name="keterangan" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">{{ old('keterangan') }}</textarea>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Simpan Pergerakan</button>
                </form>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" class="mb-5 grid gap-3 md:grid-cols-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <select name="id_produk" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                        <option value="">Semua produk</option>
                        @foreach ($produkOptions as $produk)
                            <option value="{{ $produk->id_produk }}" @selected(request('id_produk') === $produk->id_produk)>{{ $produk->nama_produk }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead>
                            <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3">Masuk</th>
                                <th class="px-4 py-3">Keluar</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-4 py-4 text-slate-700">{{ $item->tanggal->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-slate-900">{{ $item->produk?->nama_produk }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->produk?->id_produk }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-emerald-600">{{ $item->jumlah_masuk }}</td>
                                    <td class="px-4 py-4 text-rose-600">{{ $item->jumlah_keluar }}</td>
                                    <td class="px-4 py-4 text-slate-500">{{ $item->keterangan ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada pergerakan stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $items->links() }}
                </div>
            </section>
        </div>
    </div>
@endsection
