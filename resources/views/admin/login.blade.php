<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mudain</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="grid min-h-screen lg:grid-cols-[1.2fr_420px]">
        <section class="relative hidden overflow-hidden lg:block">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500 via-amber-400 to-slate-950"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,.28),transparent_35%)]"></div>
            <div class="relative flex h-full flex-col justify-between p-12">
                <div>
                    <img src="{{ asset('assets/images/logo-mudain.png') }}" alt="Mudain" class="h-16 w-auto">
                </div>
                <div class="max-w-xl">
                    <p class="text-sm uppercase tracking-[0.3em] text-white/70">Sistem Informasi Mudain</p>
                    <h1 class="mt-4 text-5xl font-black leading-tight">Kelola produk, transaksi, produksi, dan laporan dalam satu dashboard.</h1>
                    <p class="mt-5 text-lg text-white/80">Masuk untuk memantau bisnis, stok, hutang-piutang, arus kas, dan portofolio publik Mudain.</p>
                </div>
                <p class="text-sm text-white/70">Project PJBL 2026</p>
            </div>
        </section>

        <section class="flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-md rounded-[32px] border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur">
                <div class="mb-8">
                    <p class="text-sm text-orange-300">Admin Panel</p>
                    <h2 class="mt-2 text-3xl font-black">Masuk ke Mudain</h2>
                </div>

                @if (session('success'))
                    <div class="mb-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-white/80">Username</label>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm outline-none transition focus:border-orange-300 focus:ring-2 focus:ring-orange-300/20"
                            placeholder="admin"
                            required
                        >
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-white/80">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm outline-none transition focus:border-orange-300 focus:ring-2 focus:ring-orange-300/20"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-orange-500/20 transition hover:bg-orange-600">
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
