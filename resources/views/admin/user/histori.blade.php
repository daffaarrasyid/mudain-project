@extends('admin.layouts.app')

@section('page-title', 'Histori Pengguna')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Histori Pengguna</h2>
            <p class="mt-2 text-sm text-slate-500">Pantau seluruh aktivitas penggunaan sistem berdasarkan pengguna dan tanggal.</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-4">
                <select name="id_pengguna" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option value="">Semua pengguna</option>
                    @foreach ($penggunaOptions as $pengguna)
                        <option value="{{ $pengguna->id_pengguna }}" @selected((string) request('id_pengguna') === (string) $pengguna->id_pengguna)>
                            {{ $pengguna->nama_user }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter Histori</button>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="px-4 py-3">Aktivitas</th>
                            <th class="px-4 py-3">Tabel</th>
                            <th class="px-4 py-3">Referensi</th>
                            <th class="px-4 py-3">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-4 py-4 text-slate-700">{{ $item->waktu->format('d M Y H:i') }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $item->pengguna?->nama_user ?? 'Sistem' }}</td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $item->aktivitas }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $item->tabel_target ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $item->id_referensi ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-500">{{ \Illuminate\Support\Str::limit($item->detail, 80) ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada histori aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection
