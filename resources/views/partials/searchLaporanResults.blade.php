@foreach($results as $item)
    @if($item->status === 'closed') <!-- Menampilkan hanya transaksi yang statusnya 'closed' -->
        <tr>
            <td>{{ $item->toko->name }}</td> <!-- Nama Toko -->
        </tr>
        <tr>
            <td>Rp{{ number_format($item->harga * $item->jumlahDibeli, 0, ',', '.') }}</td> <!-- Total Harga -->
            <td class="text-center">{{ $item->jumlahDibeli }}</td> <!-- Jumlah -->
            <td class="text-center">{{ $item->produk->name }}</td> <!-- Produk -->
            <td class="text-center">{{ $item->terjual }}</td> <!-- Terjual -->
            <td class="text-center">Rp{{ number_format($item->harga, 0, ',', '.') }}</td> <!-- Harga -->
            <td class="text-center">{{ \Carbon\Carbon::parse($item->transactionDate)->format('d/m/Y') }}</td> <!-- Tanggal Keluar -->
            <td class="text-center">{{ $item->returDate ? \Carbon\Carbon::parse($item->returDate)->format('d/m/Y') : 'N/A' }}</td> <!-- Tanggal Retur -->
            <td class="text-center">{{ $item->waktuEdar }}</td> <!-- Waktu Edar -->
            <td class="text-center">
                <span class="{{ $item->status == 'closed' ? 'text-danger' : 'text-success' }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td> <!-- Status -->
        </tr>
    @endif
@endforeach

<!-- Pagination -->
{!! $results->links('pagination::bootstrap-5') !!}
