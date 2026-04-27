@extends('admin.layouts.app')

@section('page-title', $title)

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">{{ $title }}</h2>
            <p class="mt-2 max-w-3xl text-sm text-slate-500">{{ $description }}</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" class="grid gap-3 md:grid-cols-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Filter Laporan</button>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            @foreach ($columns as $column)
                                <th class="px-4 py-3">{{ $column['label'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr>
                                @foreach ($columns as $column)
                                    @php
                                        $raw = data_get($item, $column['key']);
                                    @endphp
                                    <td class="px-4 py-4 text-slate-700">
                                        @switch($column['format'] ?? null)
                                            @case('currency')
                                                Rp {{ number_format((float) $raw, 0, ',', '.') }}
                                                @break
                                            @case('datetime')
                                                {{ $raw ? \Illuminate\Support\Carbon::parse($raw)->format('d M Y H:i') : '-' }}
                                                @break
                                            @case('date')
                                                {{ $raw ? \Illuminate\Support\Carbon::parse($raw)->format('d M Y') : '-' }}
                                                @break
                                            @default
                                                {{ $raw !== null && $raw !== '' ? \Illuminate\Support\Str::limit((string) $raw, 70) : '-' }}
                                        @endswitch
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}" class="px-4 py-10 text-center text-slate-500">Belum ada data untuk laporan ini.</td>
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
