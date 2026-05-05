<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Supplier Mudain</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #E65C00;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #E65C00;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #E65C00;
            color: white;
        }
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        tbody tr:hover {
            background-color: #e8f4f8;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .date-info {
            margin-top: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Data Supplier Mudain</h1>
        <p>Laporan Data Supplier - {{ now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 12%;">Kode Supplier</th>
                <th style="width: 25%;">Nama Supplier</th>
                <th style="width: 15%;">No. Telepon</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 20%;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $index => $supplier)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $supplier->kode_supplier }}</strong></td>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>{{ $supplier->no_telp ?? '-' }}</td>
                <td>{{ $supplier->email ?? '-' }}</td>
                <td>{{ $supplier->alamat ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999;">Tidak ada data supplier</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="date-info">
        <p>Total Supplier: <strong>{{ count($suppliers) }}</strong></p>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <div class="footer">
        <p>© 2026 PT. Mudain - All Rights Reserved</p>
    </div>
</body>
</html>
