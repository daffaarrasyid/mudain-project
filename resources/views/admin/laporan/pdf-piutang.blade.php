<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Piutang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #38BDF8; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #38BDF8; }
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
        <div class="title">LAPORAN PIUTANG (TAGIHAN CUSTOMER)</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}<br>
            Customer: <span class="font-bold">{{ $request->customer_id == 'Semua' ? 'SEMUA CUSTOMER' : \App\Models\Customer::find($request->customer_id)->nama_customer }}</span>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total Belanja</th>
                <th>Sudah Dibayar</th>
                <th>Sisa Tagihan (Piutang)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($piutangs as $index => $trx)
            @php
                $sisaPiutang = $trx->total_harga - $trx->bayar;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->invoice }}</td>
                <td>{{ $trx->customer->nama_customer ?? 'Umum / Tanpa Nama' }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #FF0000;">Rp {{ number_format($sisaPiutang, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada catatan piutang customer pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL SISA PIUTANG</td>
                <td class="text-right font-bold" style="color: #FF0000;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align: center; margin-top: 40px; font-style: italic; color: #777;">
        Dicetak otomatis oleh Sistem Mudain Project pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>