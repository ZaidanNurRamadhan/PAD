@foreach($results as $toko)
    <tr>
        <td>{{ $toko->name }}</td>
        <td>{{ $toko->namaPemilik }}</td>
        <td>{{ $toko->address }}</td>
        <td>{{ $toko->phone_number }}</td>
        <td class="d-flex justify-content-center">
            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko" data-id="{{ $toko->id }}" data-name="{{ $toko->name }}" data-pemilik="{{ $toko->namaPemilik }}" data-alamat="{{ $toko->address }}" data-kontak="{{ $toko->phone_number }}">Edit</button>
            <button class="btn btn-danger btn-sm mx-2 deleteToko" type="button" data-bs-toggle="modal" data-id="{{$toko->id}}" data-bs-target="#Hapustoko">Hapus</button>
        </td>
    </tr>
@endforeach

<!-- Pagination -->
{!! $results->links('pagination::bootstrap-5') !!}
