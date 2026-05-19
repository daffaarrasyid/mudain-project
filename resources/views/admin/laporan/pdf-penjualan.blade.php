<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #FF0000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 12px; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f9f9f9; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-red { color: #FF0000; }
        .text-green { color: #10B981; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">LAPORAN PENJUALAN</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Kasir</th>
                <th>Status</th>
                <th>Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualans as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->invoice }}</td>
                <td>{{ $trx->customer->nama_customer ?? 'Umum' }}</td>
                <td>{{ $trx->user->name ?? 'Admin' }}</td>
                <td class="text-center font-bold {{ $trx->status_pembayaran == 'Lunas' ? 'text-green' : 'text-red' }}">
                    {{ $trx->status_pembayaran }}
                </td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL PENDAPATAN</td>
                <td class="text-right font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>