<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok In/Out</title>
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
        <div class="title">LAPORAN MUTASI STOK BARANG</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}<br>
            Tipe Laporan: <span class="font-bold">{{ strtoupper($request->jenis) }}</span>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Waktu</th>
                <th>Nama Produk / Barang</th>
                <th>Jenis</th>
                <th>Qty</th>
                <th>Keterangan</th>
                <th>User / Operator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td class="font-bold">{{ $trx->produk->nama_item ?? 'Produk Dihapus' }}</td>
                <td class="text-center font-bold" style="color: {{ $trx->jenis == 'Masuk' ? '#10B981' : '#FF0000' }}">
                    {{ $trx->jenis }}
                </td>
                <td class="text-center font-bold">{{ $trx->jumlah }}</td>
                <td>{{ $trx->keterangan ?? '-' }}</td>
                <td class="text-center">{{ $trx->user->name ?? 'Admin' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada aktivitas stok pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 40px; font-style: italic; color: #777;">
        Dicetak otomatis oleh Sistem Mudain Project pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>