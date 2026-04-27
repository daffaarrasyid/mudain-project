@extends('admin.layouts.app')

@section('page-title', 'Generate Barcode')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Generate Barcode Produk</h2>
            <p class="mt-2 text-sm text-slate-500">Pilih produk dari database untuk menampilkan barcode berbasis kode produk.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Produk</label>
                        <select name="id_produk" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                            <option value="">Pilih produk</option>
                            @foreach ($produkOptions as $produk)
                                <option value="{{ $produk->id_produk }}" @selected(request('id_produk') === $produk->id_produk)>{{ $produk->nama_produk }} ({{ $produk->id_produk }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Tampilkan Barcode</button>
                </form>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                @if ($barcodeData)
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <p class="text-sm text-slate-500">Barcode untuk</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">{{ $barcodeData['produk']->nama_produk }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $barcodeData['produk']->id_produk }}</p>
                        <div class="mt-8 overflow-x-auto rounded-2xl bg-white px-6 py-8">
                            <p class="font-mono text-xl tracking-[0.35em] text-slate-900">{{ $barcodeData['bars'] }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex min-h-[280px] items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
                        Pilih produk untuk menampilkan barcode.
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
