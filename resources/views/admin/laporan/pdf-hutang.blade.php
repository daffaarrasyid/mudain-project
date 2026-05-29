<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hutang</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .kop-table td { border: none !important; padding: 0 !important; }
        .kop-line { border-top: 2px solid #E65C00; border-bottom: 1px solid #E65C00; height: 3px; margin-bottom: 20px; }
        
        .title-block { text-align: center; margin-bottom: 20px; }
        .title-block h2 { font-size: 15px; font-weight: bold; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .title-block .subtitle { font-size: 10px; color: #666; margin-top: 5px; display: block; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; }
        table.data-table th, table.data-table td { padding: 8px 10px; text-align: left; }
        table.data-table th { background-color: #E65C00; color: white; font-size: 10px; font-weight: bold; text-transform: uppercase; border: 1px solid #d45200; }
        table.data-table td { border-bottom: 1px solid #eee; border-left: 1px solid #eee; border-right: 1px solid #eee; font-size: 9px; }
        table.data-table tbody tr:nth-child(even) { background-color: #fafafa; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-orange { color: #E65C00; }
        .text-red { color: #EF4444; font-weight: bold; }
        .text-green { color: #10B981; font-weight: bold; }
        .footer { text-align: center; margin-top: 45px; font-size: 9px; color: #888; font-style: italic; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <!-- KOP LAPORAN -->
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

    <!-- JUDUL DOCUMENT -->
    <div class="title-block">
        <h2>Laporan Hutang Dagang (Ke Supplier)</h2>
        <span class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d M Y') }}<br>
            Supplier: <span class="font-bold text-orange">{{ $request->supplier_id == 'Semua' ? 'SEMUA SUPPLIER' : \App\Models\Supplier::find($request->supplier_id)->nama_supplier }}</span>
        </span>
    </div>

    <!-- TABEL DATA -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal Pembelian</th>
                <th style="width: 15%;">No. Nota/Faktur</th>
                <th style="width: 20%;">Supplier</th>
                <th class="text-right" style="width: 15%;">Total Tagihan</th>
                <th class="text-right" style="width: 15%;">Sudah Dibayar</th>
                <th class="text-right" style="width: 15%;">Sisa Hutang</th>
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
                <td class="font-bold text-orange">{{ $trx->faktur ?? $trx->invoice }}</td>
                <td>{{ $trx->supplier->nama_supplier ?? 'Umum / Tanpa Nama' }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                <td class="text-right text-red">Rp {{ number_format($sisaHutang, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="color: #999; padding: 20px;">Tidak ada catatan hutang pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #fff8f5; font-weight: bold;">
                <td colspan="6" class="text-right font-bold text-red" style="font-size: 10px; border-top: 2px solid #EF4444;">TOTAL SISA HUTANG</td>
                <td class="text-right font-bold text-red" style="font-size: 11px; border-top: 2px solid #EF4444;">Rp {{ number_format($totalHutang, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dokumen ini sah dan dihasilkan secara otomatis oleh Sistem Mudain Project. CV. Muda Kita Indonesia © 2026. All Rights Reserved.</p>
    </div>

</body>
</html>