@extends('admin.layouts.app')

@section('page-title', 'Update Desain')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Update Desain</h2>
            <p class="mt-2 text-sm text-slate-500">Lengkapi nama desain, deskripsi, dan status desain yang terkait dengan penjualan.</p>
        </div>

        <div class="space-y-4">
            @forelse ($items as $item)
                <form action="{{ route('admin.produksi.simpan-desain', $item) }}" method="POST" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:grid-cols-[1fr_1fr_220px]">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Desain</label>
                            <input type="text" name="nama_desain" value="{{ old('nama_desain', $item->nama_desain) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                            <p class="mt-2 text-xs text-slate-500">Penjualan: {{ $item->id_penjualan }}</p>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Status Desain</label>
                            <select name="status_desain" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                @foreach (['belum_diisi', 'siap', 'revisi', 'final'] as $status)
                                    <option value="{{ $status }}" @selected($item->status_desain === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Simpan</button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi Desain</label>
                        <textarea name="deskripsi_desain" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">{{ old('deskripsi_desain', $item->deskripsi_desain) }}</textarea>
                    </div>
                </form>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-sm">Belum ada data desain.</div>
            @endforelse
        </div>
        <div>{{ $items->links() }}</div>
    </div>
@endsection
