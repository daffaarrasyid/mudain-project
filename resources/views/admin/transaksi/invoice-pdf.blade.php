<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $penjualan->invoice }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .kop-table td { border: none !important; padding: 0 !important; }
        .kop-line { border-top: 2px solid #E65C00; border-bottom: 1px solid #E65C00; height: 3px; margin-bottom: 25px; }
        
        .title-block { text-align: center; margin-bottom: 20px; }
        .title-block h2 { font-size: 16px; font-weight: bold; color: #E65C00; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .title-block .subtitle { font-size: 11px; color: #666; margin-top: 3px; display: block; font-weight: bold; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .info-table td { border: none !important; padding: 4px 0; vertical-align: top; font-size: 10px; }
        .info-card { background-color: #fff8f5; border: 1px solid #ffebe0; border-radius: 8px; padding: 12px; }
        
        table.items-table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        table.items-table th, table.items-table td { padding: 9px 12px; text-align: left; }
        table.items-table th { background-color: #E65C00; color: white; font-size: 10px; font-weight: bold; text-transform: uppercase; border: 1px solid #d45200; }
        table.items-table td { border-bottom: 1px solid #eee; border-left: 1px solid #eee; border-right: 1px solid #eee; font-size: 10px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-orange { color: #E65C00; }
        .text-red { color: #EF4444; }
        .text-green { color: #10B981; }
        
        .totals-section { float: right; width: 45%; margin-top: 10px; }
        .totals-table { width: 100%; border-collapse: collapse; }
        .totals-table td { padding: 6px 0; font-size: 10px; }
        .totals-table tr.grand-total td { font-size: 12px; font-weight: bold; color: #E65C00; border-top: 1px solid #ddd; padding-top: 8px; }
        
        .footer { clear: both; text-align: center; margin-top: 60px; font-size: 9px; color: #888; font-style: italic; border-top: 1px solid #eee; padding-top: 12px; }
    </style>
</head>
<body>

    <!-- KOP LAPORAN / SURAT -->
    <table class="kop-table">
        <tr>
            <td style="width: 15%; vertical-align: middle; text-align: left;">
                <img src="{{ public_path('assets/images/logo-mudain-orange.png') }}" style="height: 40px; display: block;" alt="Logo Mudain">
            </td>
            <td style="width: 85%; text-align: right; vertical-align: middle; line-height: 1.3;">
                <span style="font-size: 18px; font-weight: bold; color: #E65C00;">CV Muda Kita Indonesia</span><br>
                <span style="font-size: 9px; color: #555;">Jalan Nuri No. 47, Rancamanyar Regency 2, Kel. Rancamanyar, Kec. Baleendah, Kab. Bandung, Jawa Barat</span><br>
                <span style="font-size: 9px; color: #555;">Telepon: 0851-7433-9047 | Email: Mudakita.id@gmail.com | Website: mudain.co.id</span>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL LAPORAN -->
    <div class="title-block">
        <h2>INVOICE PENJUALAN</h2>
        <span class="subtitle">No: {{ $penjualan->invoice }}</span>
    </div>

    <!-- DETAIL INFORMASI INVOICE -->
    <table class="info-table">
        <tr>
            <td style="width: 48%;">
                <div class="info-card">
                    <strong style="color: #E65C00; font-size: 11px;">INFORMASI PELANGGAN</strong><br>
                    <div style="margin-top: 5px; line-height: 1.5;">
                        Nama: <strong>{{ $penjualan->customer->nama_customer ?? 'Pelanggan Umum' }}</strong><br>
                        Tipe: {{ $penjualan->customer->jenis_customer ?? 'Umum' }}<br>
                        Alamat: {{ $penjualan->customer->alamat ?? '-' }}
                    </div>
                </div>
            </td>
            <td style="width: 4%;"></td>
            <td style="width: 48%;">
                <div class="info-card" style="background-color: #fafafa; border: 1px solid #eaeaea;">
                    <strong style="color: #555; font-size: 11px;">INFORMASI TRANSAKSI</strong><br>
                    <div style="margin-top: 5px; line-height: 1.5;">
                        Tanggal: <strong>{{ \Carbon\Carbon::parse($penjualan->created_at)->format('d M Y, H:i') }}</strong> WIB<br>
                        Operator Kasir: {{ $penjualan->user->name ?? 'Admin' }}<br>
                        Status Bayar: <span class="font-bold {{ $penjualan->status_pembayaran == 'Lunas' ? 'text-green' : 'text-red' }}">{{ strtoupper($penjualan->status_pembayaran) }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- DAFTAR ITEM YANG DIBELI -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 45%;">Item / Layanan</th>
                <th class="text-center" style="width: 15%;">Qty</th>
                <th class="text-right" style="width: 20%;">Harga Satuan</th>
                <th class="text-right" style="width: 20%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->details as $detail)
            <tr>
                <td class="font-bold">{{ $detail->produk->nama_item ?? 'Item Dihapus' }}</td>
                <td class="text-center">{{ $detail->qty }}</td>
                <td class="text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-orange">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL AKHIR -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td style="width: 55%; color: #666;">Total Tagihan</td>
                <td style="width: 45%;" class="text-right font-bold">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="color: #666;">Jumlah Dibayar</td>
                <td class="text-right">Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td>
            </tr>
            @if($penjualan->kembalian < 0)
            <tr class="grand-total">
                <td class="text-red font-bold">SISA PIUTANG</td>
                <td class="text-right text-red font-bold">Rp {{ number_format(abs($penjualan->kembalian), 0, ',', '.') }}</td>
            </tr>
            @else
            <tr class="grand-total">
                <td>KEMBALIAN</td>
                <td class="text-right">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Terima kasih atas kepercayaannya. Dokumen ini merupakan bukti sah transaksi dan dicetak secara otomatis oleh sistem.</p>
        <p style="margin-top: 4px; font-weight: bold; color: #555;">CV Muda Kita Indonesia</p>
    </div>

</body>
</html>