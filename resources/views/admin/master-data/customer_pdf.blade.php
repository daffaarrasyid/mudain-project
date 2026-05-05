<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Customer</title>
    <style>
        /* CSS Biasa agar DomPDF bisa ngebaca dengan sempurna */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #E65C00;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #E65C00;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2d2d2d;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-center {
            text-align: center;
        }
        .date-print {
            font-size: 10px;
            color: #999;
            text-align: right;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- KOP LAPORAN -->
    <div class="header">
        <h1>Data Customer</h1>
        <p>Mudain - Sahabat Terbaik Organisasimu</p>
    </div>

    <!-- Tanggal Cetak Otomatis (Waktu saat tombol PDF diklik) -->
    <div class="date-print">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB
    </div>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="13%">Kode</th>
                <th width="20%">Nama Customer</th>
                <th width="15%">No. Telp</th>
                <th width="18%">Email</th>
                <th width="19%">Alamat</th>
                <th class="text-center" width="10%">Jenis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $cus)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="color: #E65C00; font-weight: bold;">{{ $cus->kode_customer }}</td>
                <td>{{ $cus->nama_customer }}</td>
                <td>{{ $cus->no_telp }}</td>
                <td>{{ $cus->email ?? '-' }}</td>
                <td>{{ $cus->alamat ?? '-' }}</td>
                <td class="text-center">{{ $cus->jenis_customer }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Belum ada data customer yang terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>