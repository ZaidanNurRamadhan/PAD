<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>

    <p><strong>Total Transaksi:</strong> {{ $data->count() }}</p>
    <p><strong>Total Retur:</strong> {{ $retur }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Toko</th>
                <th>Nama Produk</th>
                <th>Jumlah Dibeli</th>
                <th>Terjual</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Tanggal Keluar</th>
                <th>Tanggal Retur</th>
                <th>Waktu Edar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->toko->name ?? 'N/A' }}</td>
                    <td>{{ $transaksi->produk->name ?? 'N/A' }}</td>
                    <td>{{ $transaksi->jumlahDibeli }}</td>
                    <td>{{ $transaksi->terjual }}</td>
                    <td>{{ number_format($transaksi->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaksi->harga * $transaksi->terjual, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td>{{ $transaksi->returDate ? \Carbon\Carbon::parse($transaksi->returDate)->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $transaksi->waktuEdar ?? 'N/A' }}</td>
                    <td>{{ $transaksi->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
