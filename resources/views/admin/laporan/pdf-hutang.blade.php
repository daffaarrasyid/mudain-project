<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hutang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #FF0000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #FF0000; }
        .subtitle { font-size: 12px; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f9f9f9; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">LAPORAN HUTANG DAGANG (KE SUPPLIER)</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}<br>
            Supplier: <span class="font-bold">{{ $request->supplier_id == 'Semua' ? 'SEMUA SUPPLIER' : \App\Models\Supplier::find($request->supplier_id)->nama_supplier }}</span>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembelian</th>
                <th>No. Nota/Faktur</th>
                <th>Supplier</th>
                <th>Total Tagihan</th>
                <th>Sudah Dibayar</th>
                <th>Sisa Hutang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hutangs as $index => $trx)
            @php
                $sisaHutang = $trx->total_harga - $trx->bayar;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->faktur ?? $trx->invoice }}</td>
                <td>{{ $trx->supplier->nama_supplier ?? 'Umum / Tanpa Nama' }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #FF0000;">Rp {{ number_format($sisaHutang, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada catatan hutang pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL SISA HUTANG</td>
                <td class="text-right font-bold" style="color: #FF0000;">Rp {{ number_format($totalHutang, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align: center; margin-top: 40px; font-style: italic; color: #777;">
        Dicetak otomatis oleh Sistem Mudain Project pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>