<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $penjualan->invoice }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #E65C00; }
        .info-table { w-full; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th, table.items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.items th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals { float: right; width: 40%; }
        .totals table { width: 100%; }
        .totals table td { padding: 5px; }
        .bold { font-weight: bold; }
        .text-orange { color: #E65C00; }
        .footer { clear: both; margin-top: 50px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>INVOICE</h1>
        <p>No: {{ $penjualan->invoice }}</p>
    </div>

    <table class="info-table" width="100%">
        <tr>
            <td width="50%">
                <strong>Kepada:</strong><br>
                {{ $penjualan->customer->nama_customer ?? 'Pelanggan Umum' }}
            </td>
            <td width="50%" class="text-right">
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d M Y, H:i') }}<br>
                <strong>Kasir:</strong> {{ $penjualan->user->name ?? 'Admin' }}<br>
                <strong>Status:</strong> {{ strtoupper($penjualan->status_pembayaran) }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Item / Layanan</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->details as $detail)
            <tr>
                <td>{{ $detail->produk->nama_item ?? 'Item Dihapus' }}</td>
                <td class="text-center">{{ $detail->qty }}</td>
                <td class="text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Total Tagihan</td>
                <td class="text-right bold">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Telah Dibayar</td>
                <td class="text-right">Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                @if($penjualan->kembalian < 0)
                <td class="text-orange bold">Sisa Hutang</td>
                <td class="text-right text-orange bold">Rp {{ number_format(abs($penjualan->kembalian), 0, ',', '.') }}</td>
                @else
                <td>Kembalian</td>
                <td class="text-right">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                @endif
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Terima kasih atas kepercayaannya. Dokumen ini sah dan dicetak secara otomatis oleh sistem.</p>
    </div>

</body>
</html>