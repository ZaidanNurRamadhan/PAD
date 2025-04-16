<!-- resources/views/partials/searchTransaksiResults.blade.php -->

@foreach($results as $item)
    <tr>
        <td>{{ $item->toko->name}}</td>
    </tr>
    <tr>
        <td>Rp{{ number_format($item->harga * $item->jumlahDibeli, 0, ',', '.') }}</td>
        <td>{{ $item->jumlahDibeli }}</td>
        <td>{{ $item->produk->name }}</td>
        <td>{{ $item->terjual }}</td>
        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->transactionDate)->format('d/m/Y') }}</td>
        <td>{{ $item->returDate ? \Carbon\Carbon::parse($item->returDate)->format('d/m/Y') : 'N/A' }}</td>
        <td>{{ $item->waktuEdar }}</td>
        <td class="text-center">
            <span class="{{ $item->status == 'closed' ? 'text-danger' : 'text-success' }}">
                {{ ucfirst($item->status) }}
            </span>
            <a class="btn btn-sm p-0 m-0" onclick="editTransaksi({{ $item->id }})">
                <i class="fas fa-angle-right"></i>
            </a>
        </td>
    </tr>
@endforeach

<!-- Pagination -->
{!! $results->links('pagination::bootstrap-5') !!}
