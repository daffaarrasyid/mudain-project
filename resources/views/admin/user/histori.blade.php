@extends('admin.layouts.app')

@section('content')
    <style>
        @keyframes slideUpFade {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-animasi-1 {
            animation: slideUpFade 0.8s ease-out 0.1s both;
        }

    </style>

    <div
        class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 animate-[fadeIn_0.5s_ease-in-out] w-full min-w-0">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Histori Pengguna</h2>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar rounded-xl border border-gray-50">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead>
                    <tr class="text-gray-800 text-sm font-bold border-b-2 border-gray-100">
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Tipe User</th>
                        <th class="px-6 py-4">Aktivitas</th>
                        <th class="px-6 py-4">Timestamp</th>
                        <th class="px-6 py-4 text-center">Waktu Logout</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @for ($i = 1; $i <= 4; $i++)
                        <tr class="border-b border-gray-50 even:bg-gray-50/70 hover:bg-orange-50/40 transition-colors">
                            <td class="px-6 py-5 font-medium text-gray-700">Admin</td>
                            <td class="px-6 py-5">Asep Suherlan</td>
                            <td class="px-6 py-5">Administrator</td>
                            <td class="px-6 py-5">Membuat Entry Penjualan</td>
                            <td class="px-6 py-5 text-gray-500">2026-04-15 09:28:03</td>
                            <td class="px-6 py-5 text-center">
                                @if ($i == 1)
                                    <span
                                        class="bg-[#10B981] text-white px-3 py-1.5 rounded-md text-[11px] font-bold shadow-sm">Sedang
                                        Aktif</span>
                                @else
                                    <span class="text-gray-500">2026-04-15 09:28:03</span>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
