@extends('admin.layouts.app')

@section('page-title', $title)

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">{{ $title }}</h2>
            <p class="mt-2 max-w-3xl text-sm text-slate-500">{{ $description }}</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $editItem ? 'Ubah Data' : 'Tambah Data' }}</h3>
                        <p class="text-sm text-slate-500">{{ $editItem ? 'Perbarui data yang sudah ada.' : 'Masukkan data baru ke sistem.' }}</p>
                    </div>
                    @if ($editItem)
                        <a href="{{ url()->current() }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Batal Edit
                        </a>
                    @endif
                </div>

                <form action="{{ $editItem ? route($updateRoute, $editItem) : route($storeRoute) }}" method="POST" class="space-y-4">
                    @csrf
                    @if ($editItem)
                        @method('PUT')
                    @endif

                    @foreach ($fields as $field)
                        @php
                            $rawValue = old($field['name'], data_get($editItem, $field['value_key'] ?? $field['name']));
                            $value = is_array($rawValue) ? implode(', ', $rawValue) : $rawValue;
                            $options = $field['options'] ?? [];
                        @endphp

                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-rose-500">*</span>
                                @endif
                            </label>

                            @if (($field['type'] ?? 'text') === 'textarea')
                                <textarea
                                    name="{{ $field['name'] }}"
                                    rows="4"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >{{ $value }}</textarea>
                            @elseif (($field['type'] ?? 'text') === 'select')
                                <select
                                    name="{{ $field['name'] }}"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >
                                    <option value="">Pilih {{ strtolower($field['label']) }}</option>
                                    @foreach ($options as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input
                                    type="{{ $field['type'] ?? 'text' }}"
                                    name="{{ $field['name'] }}"
                                    value="{{ ($field['type'] ?? 'text') === 'password' ? '' : $value }}"
                                    step="{{ $field['step'] ?? '1' }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >
                            @endif
                        </div>
                    @endforeach

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-500/20 transition hover:bg-orange-600"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ $createLabel ?? ($editItem ? 'Simpan Perubahan' : 'Simpan Data') }}
                    </button>
                </form>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" class="mb-5 grid gap-3 md:grid-cols-[1fr_repeat(auto-fit,minmax(180px,1fr))]">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ $searchPlaceholder ?? 'Cari data' }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                    @foreach ($filters ?? [] as $filter)
                        <select
                            name="{{ $filter['name'] }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                            @foreach ($filter['options'] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) request($filter['name']) === (string) $optionValue)>{{ $optionLabel }}</option>
                            @endforeach
                        </select>
                    @endforeach

                    <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">
                        Filter
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead>
                            <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                @foreach ($columns as $column)
                                    <th class="px-4 py-3">{{ $column['label'] }}</th>
                                @endforeach
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($items as $item)
                                <tr class="align-top">
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
                                                    @if (is_string($raw) && filter_var($raw, FILTER_VALIDATE_URL))
                                                        <a href="{{ $raw }}" target="_blank" class="font-medium text-orange-600 hover:underline">Lihat</a>
                                                    @elseif (in_array($raw, ['belum_lunas', 'sebagian', 'lunas', 'tunai', 'piutang', 'hutang', 'menunggu', 'diproses', 'selesai', 'siap', 'revisi', 'final', 'belum_diisi'], true))
                                                        @php
                                                            $badgeClass = match ($raw) {
                                                                'lunas', 'selesai', 'siap', 'final', 'tunai' => 'bg-emerald-100 text-emerald-700',
                                                                'sebagian', 'diproses', 'revisi' => 'bg-amber-100 text-amber-700',
                                                                default => 'bg-slate-100 text-slate-700',
                                                            };
                                                        @endphp
                                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                                            {{ str_replace('_', ' ', $raw) }}
                                                        </span>
                                                    @else
                                                        {{ $raw !== null && $raw !== '' ? \Illuminate\Support\Str::limit((string) $raw, 60) : '-' }}
                                                    @endif
                                            @endswitch
                                        </td>
                                    @endforeach
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ request()->fullUrlWithQuery(['edit' => $item->getKey()]) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                                Edit
                                            </a>
                                            <form action="{{ route($destroyRoute, $item) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($columns) + 1 }}" class="px-4 py-10 text-center text-sm text-slate-500">
                                        Belum ada data untuk ditampilkan.
                                    </td>
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
