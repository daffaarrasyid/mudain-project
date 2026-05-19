@extends('admin.layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="text-center max-w-md px-6">

        {{-- Icon --}}
        <div class="mx-auto mb-6 flex items-center justify-center w-24 h-24 rounded-full bg-red-50 border-4 border-red-100">
            <i class="fa-solid fa-ban text-5xl text-red-400"></i>
        </div>

        {{-- Kode --}}
        <p class="text-7xl font-black text-red-200 leading-none mb-2">403</p>

        {{-- Judul --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-3">Akses Ditolak</h1>

        {{-- Pesan --}}
        <p class="text-sm text-gray-500 mb-2">
            {{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
        </p>
        <p class="text-xs text-gray-400 mb-8">
            Hubungi <span class="font-semibold text-gray-500">Owner / Super Admin</span> jika Anda membutuhkan akses ke halaman ini.
        </p>

        {{-- Tombol kembali --}}
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 bg-[#E65C00] hover:bg-[#cc5200] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-house"></i> Kembali ke Dashboard
        </a>

    </div>
</div>
@endsection
