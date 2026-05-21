<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Histori Aktivitas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #FF0000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 12px; color: #666; line-height: 1.4; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        .table th { background-color: #f9f9f9; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-xs { font-size: 10px; color: #777; margin-top: 3px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">LAPORAN HISTORI AKTIVITAS</div>
        <div class="subtitle">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}<br>
            Filter: 
            @if(request('action') && request('action') != 'all') Aksi: {{ request('action') }} | @endif
            @if(request('module') && request('module') != 'all') Modul: {{ request('module') }} | @endif
            @if(request('search')) Pencarian: {{ request('search') }} @endif
            @if(!request('action') && !request('module') && !request('search')) Semua Data @endif
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Waktu</th>
                <th width="20%">Pengguna</th>
                <th width="15%">Aktivitas</th>
                <th width="15%">Modul</th>
                <th width="30%">Deskripsi & Info</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $index => $log)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
                <td>
                    <div class="font-bold">{{ $log->user_name }}</div>
                    <div class="text-xs">{{ $log->user_role }}</div>
                </td>
                <td class="text-center font-bold">{{ $log->actionLabel }}</td>
                <td class="text-center">{{ $log->module }}</td>
                <td>
                    <div>{{ $log->description }}</div>
                    <div class="text-xs">IP: {{ $log->ip_address }}<br>{{ Str::limit($log->user_agent, 45) }}</div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada log aktivitas sesuai kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
