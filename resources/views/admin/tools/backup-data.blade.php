@extends('admin.layouts.app')

@section('page-title', 'Backup Data')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Backup Data</h2>
                    <p class="mt-2 text-sm text-slate-500">Buat file backup JSON untuk mengamankan seluruh data inti aplikasi.</p>
                </div>
                <form action="{{ route('admin.tools.backup-data.process') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Buat Backup Baru</button>
                </form>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Nama File</th>
                            <th class="px-4 py-3">Waktu Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($backups as $backup)
                            <tr>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $backup['name'] }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $backup['updated_at'] }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('admin.tools.backup-data.download', ['path' => $backup['path']]) }}" class="inline-flex rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center text-slate-500">Belum ada file backup.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
