<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profil['nama'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/40 via-slate-950 to-slate-950"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,.18),transparent_25%)]"></div>

        <header class="relative z-10 mx-auto flex max-w-7xl items-center justify-between px-6 py-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo-mudain-icon.png') }}" alt="Mudain" class="h-11 w-11 rounded-xl bg-white/10 p-2">
                <div>
                    <p class="text-sm font-semibold text-orange-200">Mudain Project</p>
                    <p class="text-xs text-white/70">Landing Page Publik</p>
                </div>
            </div>
            <a href="{{ route('admin.login') }}" class="rounded-2xl border border-white/15 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">
                Login Admin
            </a>
        </header>

        <section class="relative z-10 mx-auto grid max-w-7xl gap-10 px-6 pb-20 pt-10 lg:grid-cols-[1.1fr_460px] lg:items-center">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-orange-200">Informasi Utama Mudain</p>
                <h1 class="mt-4 max-w-3xl text-5xl font-black leading-tight lg:text-6xl">{{ $profil['nama'] }}</h1>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-white/80">{{ $profil['tagline'] }}</p>
                <p class="mt-5 max-w-2xl text-base leading-7 text-white/70">{{ $profil['deskripsi'] }}</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-white/60">Total Penjualan</p>
                        <p class="mt-3 text-3xl font-black">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-white/60">Portofolio</p>
                        <p class="mt-3 text-3xl font-black">{{ $portofolio->count() }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-white/60">Mitra</p>
                        <p class="mt-3 text-3xl font-black">{{ $mitra->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[36px] border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur">
                <img src="{{ asset('assets/images/model-mudain.png') }}" alt="Mudain" class="w-full object-contain">
            </div>
        </section>
    </div>

    <main class="mx-auto max-w-7xl space-y-12 px-6 py-14">
        <section>
            <div class="mb-6 flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-orange-300">Produk Publik</p>
                    <h2 class="mt-2 text-3xl font-black">Produk Tersedia</h2>
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($produk as $item)
                    <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-slate-900">
                            @if ($item->gambar)
                                <img src="{{ $item->gambar }}" alt="{{ $item->nama_produk }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-white/50">Belum ada gambar</div>
                            @endif
                        </div>
                        <h3 class="mt-4 text-xl font-bold">{{ $item->nama_produk }}</h3>
                        <p class="mt-2 text-sm leading-6 text-white/70">{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) ?: 'Deskripsi belum tersedia.' }}</p>
                        <p class="mt-4 text-lg font-black text-orange-300">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </article>
                @empty
                    <p class="text-sm text-white/60">Belum ada produk publik yang ditampilkan.</p>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.2em] text-orange-300">Portofolio</p>
                <h2 class="mt-2 text-3xl font-black">Karya Terbaru</h2>
            </div>
            <div class="grid gap-5 lg:grid-cols-3">
                @forelse ($portofolio as $item)
                    <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-slate-900">
                            @if ($item->gambar)
                                <img src="{{ $item->gambar }}" alt="{{ $item->judul }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-white/50">Belum ada gambar</div>
                            @endif
                        </div>
                        <h3 class="mt-4 text-xl font-bold">{{ $item->judul }}</h3>
                        <p class="mt-2 text-sm leading-6 text-white/70">{{ \Illuminate\Support\Str::limit($item->deskripsi, 140) ?: 'Deskripsi belum tersedia.' }}</p>
                    </article>
                @empty
                    <p class="text-sm text-white/60">Belum ada portofolio yang ditampilkan.</p>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.2em] text-orange-300">Mitra</p>
                <h2 class="mt-2 text-3xl font-black">Partner Kolaborasi</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($mitra as $item)
                    <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="aspect-[16/9] overflow-hidden rounded-2xl bg-white/5">
                            @if ($item->logo)
                                <img src="{{ $item->logo }}" alt="{{ $item->nama_mitra }}" class="h-full w-full object-contain p-5">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-white/50">Logo belum tersedia</div>
                            @endif
                        </div>
                        <h3 class="mt-4 text-lg font-bold">{{ $item->nama_mitra }}</h3>
                        <p class="mt-2 text-sm leading-6 text-white/70">{{ \Illuminate\Support\Str::limit($item->deskripsi, 90) ?: 'Mitra kolaborasi Mudain.' }}</p>
                    </article>
                @empty
                    <p class="text-sm text-white/60">Belum ada mitra yang ditampilkan.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>
