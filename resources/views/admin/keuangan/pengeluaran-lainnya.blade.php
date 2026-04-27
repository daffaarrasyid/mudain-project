@extends('admin.layouts.app')

@section('page-title', 'Pengeluaran Lainnya')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Pengeluaran Lainnya</h2>
            <p class="mt-2 text-sm text-slate-500">Catat biaya operasional seperti listrik, transport, dan kebutuhan lain di luar pembelian barang.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $editItem ? 'Ubah Pengeluaran' : 'Tambah Pengeluaran' }}</h3>
                        <p class="text-sm text-slate-500">Simpan biaya operasional ke arus kas.</p>
                    </div>
                    @if ($editItem)
                        <a href="{{ url()->current() }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">Batal</a>
                    @endif
                </div>

                <form action="{{ $editItem ? route('admin.keuangan.pengeluaran.update', $editItem) : route('admin.keuangan.pengeluaran.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @if ($editItem)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal</label>
                        <input type="datetime-local" name="tanggal" value="{{ old('tanggal', ($editItem?->tanggal ?? now())->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
                        <input type="text" name="kategori_pengeluaran" value="{{ old('kategori_pengeluaran', $editItem?->kategori_pengeluaran) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan', $editItem?->keterangan) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Jumlah</label>
                        <input type="number" name="jumlah_pengeluaran" min="0" step="0.01" value="{{ old('jumlah_pengeluaran', $editItem?->jumlah_pengeluaran) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">{{ $editItem ? 'Simpan Perubahan' : 'Simpan Pengeluaran' }}</button>
                </form>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" class="mb-5 grid gap-3 md:grid-cols-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengeluaran" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead>
                            <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-4 py-4 text-slate-700">{{ $item->tanggal->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-4 text-slate-700">{{ $item->kategori_pengeluaran ?: '-' }}</td>
                                    <td class="px-4 py-4 text-slate-700">{{ $item->keterangan }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-900">Rp {{ number_format($item->jumlah_pengeluaran, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ request()->fullUrlWithQuery(['edit' => $item->id_pengeluaran]) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">Edit</a>
                                            <form action="{{ route('admin.keuangan.pengeluaran.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada pengeluaran tambahan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">{{ $items->links() }}</div>
            </section>
        </div>
    </div>
@endsection
