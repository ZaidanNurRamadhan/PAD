@forelse($pemasok as $index => $data)
    <tr>
        <td>{{$index + $pemasok->firstItem()}}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->produkDisediakan }}</td>
        <td>{{ $data->nomorTelepon }}</td>
        <td>{{ $data->email }}</td>
        <td class="d-flex justify-content-center">
            <button class="btn btn-warning btn-sm mx-2" onclick="editPemasok({{ $data->id }})">Edit</button>
            <button class="btn btn-danger btn-sm deletePemasok mx-2" data-id="{{$data->id}}" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
        </td>
    </tr>
@empty
    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
@endforelse

<!-- Pagination -->
{!! $pemasok->links('pagination::bootstrap-5') !!}
