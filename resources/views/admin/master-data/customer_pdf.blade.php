<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Customer</title>
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
        
        .summary-info { margin-top: 20px; font-size: 10px; color: #555; }
        .summary-info p { margin: 3px 0; }
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
                <span style="font-size: 9px; color: #555;">Telepon: 0851-7433-9047 | Email: Mudakita.id@gmail.com | Website: mudain.my.id</span>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL DOCUMENT -->
    <div class="title-block">
        <h2>Laporan Data Customer</h2>
        <span class="subtitle">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</span>
    </div>

    <!-- TABEL DATA -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 13%;">Kode</th>
                <th style="width: 20%;">Nama Customer</th>
                <th style="width: 15%;">No. Telp</th>
                <th style="width: 18%;">Email</th>
                <th style="width: 19%;">Alamat</th>
                <th class="text-center" style="width: 10%;">Jenis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $cus)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold text-orange">{{ $cus->kode_customer }}</td>
                <td>{{ $cus->nama_customer }}</td>
                <td>{{ $cus->no_telp }}</td>
                <td>{{ $cus->email ?? '-' }}</td>
                <td>{{ $cus->alamat ?? '-' }}</td>
                <td class="text-center">{{ $cus->jenis_customer }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="color: #999; padding: 20px;">Belum ada data customer yang terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- KETERANGAN / RINGKASAN -->
    <div class="summary-info">
        <p>Total Jumlah Customer: <strong class="text-orange">{{ count($customers) }}</strong> orang / instansi</p>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dokumen ini sah dan dihasilkan secara otomatis oleh Sistem Mudain Project. CV. Muda Kita Indonesia © 2026. All Rights Reserved.</p>
    </div>

</body>
</html>