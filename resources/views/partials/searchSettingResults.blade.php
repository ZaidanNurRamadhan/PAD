@foreach ($results as $employee)
    <tr>
        <td>{{ $employee['name'] }}</td>
        <td>{{ $employee['contact'] }}</td>
        <td>{{ $employee['email'] }}</td>
        <td class="d-flex justify-content-center">
            <!-- Tombol Edit -->
            <button class="btn btn-warning btn-sm mx-2"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#Editkaryawan"
                data-id="{{ $employee['id'] }}"
                data-name="{{ $employee['name'] }}"
                data-contact="{{ $employee['contact'] }}"
                data-email="{{ $employee['email'] }}">
                Edit
            </button>
            <!-- Tombol Hapus -->
            <button class="btn btn-danger btn-sm mx-2 deleteKaryawan" type="button" data-id="{{ $employee['id'] }}" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">Hapus</button>
        </td>
    </tr>
@endforeach
{!! $results->links('pagination::bootstrap-5') !!} <!-- This will generate the pagination links -->
