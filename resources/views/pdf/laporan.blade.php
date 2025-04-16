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
            <th>Nama Toko</th>
            <th>Total Harga</th>
            <th>Jumlah</th>
            <th>Produk</th>
            <th>Terjual</th>
            <th>Harga</th>
            <th>Tanggal Keluar</th>
            <th>Tanggal Retur</th>
            <th>Waktu Edar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @if ($item->status === 'closed')
                <tr>
                    <td>{{ $item->toko->name }}</td>
                    <td>{{ number_format($item->harga * $item->jumlahDibeli, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlahDibeli }}</td>
                    <td>{{ $item->produk->name }}</td>
                    <td>{{ $item->terjual }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->format('d/m/Y') }}</td>
                    <td>{{ $item->waktu_edar }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

</body>
</html>
