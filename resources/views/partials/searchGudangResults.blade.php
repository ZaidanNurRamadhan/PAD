@foreach($gudang as $index => $produk)
    <tr>
        <td> {{ $index + 1 }} </td>
        <td>{{ $produk->name }}</td>
        <td>Rp{{ number_format($produk->hargaBeli, 0, ',', '.') }}</td>
        <td>Rp{{ number_format($produk->hargaJual, 0, ',', '.') }}</td>
        <td>{{ $produk->jumlah }}</td>
        <td>{{ $produk->batasKritis }} Packets</td>
        <td class="justify-content-center d-flex">
            <button class="m-2 btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#Editproduk" data-id="{{ $produk->id }}" data-name="{{ $produk->name }}" data-hbeli="{{ $produk->hargaBeli }}" data-hjual="{{ $produk->hargaJual }}" data-jstok="{{ $produk->jumlah }}" data-astok="{{ $produk->batasKritis }}">Edit</button>
            <button class="m-2 btn btn-danger btn-sm deleteProduk" data-id="{{ $produk->id }}" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
        </td>
    </tr>
@endforeach
{!! $gudang->links('pagination::bootstrap-5') !!}
