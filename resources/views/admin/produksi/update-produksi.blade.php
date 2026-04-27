@extends('admin.layouts.app')

@section('page-title', 'Update Produksi')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Update Produksi</h2>
            <p class="mt-2 text-sm text-slate-500">Ubah status dan detail produksi yang terhubung ke transaksi penjualan.</p>
        </div>

        <div class="space-y-4">
            @forelse ($items as $item)
                <form action="{{ route('admin.produksi.simpan-produksi', $item) }}" method="POST" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:grid-cols-5">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Penjualan</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $item->id_penjualan }}</p>
                            <p class="text-sm text-slate-500">{{ $item->penjualan?->pembeli?->nama_pembeli ?? 'Umum' }}</p>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Produksi</label>
                            <input type="datetime-local" name="tanggal_produksi" value="{{ old('tanggal_produksi', $item->tanggal_produksi?->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Jumlah Produksi</label>
                            <input type="number" name="jumlah_produksi" min="0" value="{{ old('jumlah_produksi', $item->jumlah_produksi) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Status</label>
                            <select name="status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                @foreach (['menunggu', 'diproses', 'selesai'] as $status)
                                    <option value="{{ $status }}" @selected($item->status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Simpan</button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">{{ old('catatan', $item->catatan) }}</textarea>
                    </div>
                </form>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">Belum ada data produksi.</div>
            @endforelse
        </div>
        <div>{{ $items->links() }}</div>
    </div>
@endsection
