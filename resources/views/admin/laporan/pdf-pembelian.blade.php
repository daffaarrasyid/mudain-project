<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #E65C00; padding-bottom: 10px; }
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
        <div class="title" style="color: #E65C00;">LAPORAN PEMBELIAN BARANG (KULAKAN)</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Nota/Faktur</th>
                <th>Supplier</th>
                <th>Penerima (User)</th>
                <th>Status Bayar</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelians as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->invoice ?? $trx->faktur }}</td>
                <td>{{ $trx->supplier->nama_supplier ?? 'Umum / Tanpa Nama' }}</td>
                <td>{{ $trx->user->name ?? 'Admin' }}</td>
                <td class="text-center font-bold {{ $trx->status_pembayaran == 'Lunas' ? 'text-green' : 'text-red' }}">
                    {{ $trx->status_pembayaran }}
                </td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pembelian pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL PENGELUARAN</td>
                <td class="text-right font-bold" style="color: #E65C00;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align: center; margin-top: 40px; font-style: italic; color: #777;">
        Dicetak otomatis oleh Sistem Mudain Project pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>