<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arus Kas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #E65C00; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #E65C00;}
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
        <div class="title">LAPORAN ARUS KAS (CASH FLOW)</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Ref</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Tipe</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kas as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->kode_kas }}</td>
                <td>{{ $trx->jenis }}</td>
                <td>{{ $trx->keterangan ?? '-' }}</td>
                <td class="text-center font-bold" style="color: {{ $trx->tipe == 'Masuk' ? '#10B981' : '#FF0000' }}">
                    {{ $trx->tipe }}
                </td>
                <td class="text-right">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada mutasi kas pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL PEMASUKAN</td>
                <td class="text-right font-bold" style="color:#10B981;">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="6" class="text-right font-bold">TOTAL PENGELUARAN</td>
                <td class="text-right font-bold" style="color:#FF0000;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="6" class="text-right font-bold">SALDO PERIODE INI</td>
                <td class="text-right font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>