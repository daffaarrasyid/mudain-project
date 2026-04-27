@extends('admin.layouts.app')

@section('page-title', 'Informasi Konten')

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <h2 class="text-2xl font-bold text-slate-900">Informasi Modul Konten</h2>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500">
            Modul inti landing page yang mengikuti tabel fungsional pada proyek ini adalah portofolio, mitra, dan produk publik.
            Halaman ini disediakan sebagai ruang informasi tambahan jika nanti Anda ingin menambah testimoni pada iterasi berikutnya.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('admin.konten.portofolio') }}" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Buka Portofolio</a>
            <a href="{{ route('admin.konten.mitra') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">Buka Mitra</a>
            <a href="{{ route('admin.konten.produk') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">Buka Produk Publik</a>
        </div>
    </div>
@endsection
