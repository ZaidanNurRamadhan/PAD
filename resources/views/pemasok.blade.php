@extends('layout.owner')
@section('content')
<section class="table-container d-flex flex-column min-vh-100">
    <div class="flex-grow-1 d-flex flex-column justify-content-between">
        <article class="d-flex justify-content-between align-items-center mb-3">
            <h3>Pemasok</h3>
            <button class="btn btn-primary btn-add" type="button" data-bs-toggle="modal" data-bs-target="#Tambahpemasok">Tambah Pemasok</button>
        </article>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Richard Martin</td>
                        <td>Kit Kat</td>
                        <td>7887744556</td>
                        <td>richard@gmail.com</td>
                        <td>
                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Produk</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasok as $data)
        <tr>
            <td>{{ $data->name }}</td>
            <td>{{ $data->produkDisediakan }}</td>
            <td>{{ $data->nomorTelepon }}</td>
            <td>{{ $data->email }}</td>
            <td>
                <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination">
=======
    <div class="pagination mt-auto d-flex justify-content-between">
>>>>>>> 3260a7cb04a6a20fa917acd674467c36de27fc4b
        <button class="btn btn-secondary">Previous</button>
        <span>Page 1 of 10</span>
        <button class="btn btn-secondary">Next</button>
    </div>
</section>

    {{-- hapus --}}
    <section class="modal fade" id="Hapuspemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Pemasok</h1>
            </header>
            <form action="{{ route('pemasok.destroy', ['id' => $data->id]) }}" method="POST">
                @csrf
                <article class="modal-body">
                    <p>Anda yakin ingin menghapus pemasok ini?</p>
                </article>
            </form>
            <footer class="modal-footer">
              <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" style="width: 100px;" class="btn btn-danger">Ya</button>
            </footer>
        </main>
        </div>
      </section>
      {{-- tambah --}}
      <section class="modal fade" id="Tambahpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pemasok</h1>
            </header>
            <form action="{{ route('pemasok.store') }}" method="POST">
                @csrf
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Pemasok</label>
                        <input type="text" name="name" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Produk</label>
                        <input type="text" name="produkDisediakan" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="nomorTelepon" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email pemasok">
                    </section>
                </article>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary">Tambah</button>
            </div>
        </main>
        </div>
      </section>
      {{-- edit --}}
      <section class="modal fade" id="Editpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemasok</h1>
            </header>
            <form action="{{ route('pemasok.update', ['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Pemasok</label>
<<<<<<< HEAD
                        <input type="text" name="name" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Produk</label>
                        <input type="text" name="produkDisediakan" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="nomorTelepon" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email pemasok">
=======
                        <input type="text" name="pemasokname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Produk</label>
                        <input type="text" name="produk" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemilik toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="kontak" class="form-control" style="max-width: 273px;" placeholder="Masukkan alamat toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak toko">
>>>>>>> 3260a7cb04a6a20fa917acd674467c36de27fc4b
                    </section>
                </article>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </main>
        </div>
      </section>

      <script>
        $(document).ready(function() {
            // Add Pemasok
            $('#addPemasokForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("pemasok.store") }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#Tambahpemasok').modal('hide');
                        $('#pemasok-table-body').append(`
                            <tr id="pemasok-${response.id}">
                                <td>${response.name}</td>
                                <td>${response.produkDisediakan}</td>
                                <td>${response.nomorTelepon}</td>
                                <td>${response.email}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${response.id}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${response.id}">Hapus</button>
                                </td>
                            </tr>
                        `);
                    }
                });
            });
    
            // Edit Pemasok
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                $.get(`/pemasok/${id}/edit`, function(data) {
                    $('#edit-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-produkDisediakan').val(data.produkDisediakan);
                    $('#edit-nomorTelepon').val(data.nomorTelepon);
                    $('#edit-email').val(data.email);
                    $('#Editpemasok').modal('show');
                });
            });
    
            $('#editPemasokForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#edit-id').val();
                $.ajax({
                    type: 'PUT',
                    url: `/pemasok/update/${id}`,
                    data: $(this).serialize(),
                    success: function(response) {
                        $(`#pemasok-${id} td:nth-child(1)`).text(response.name);
                        $(`#pemasok-${id} td:nth-child(2)`).text(response.produkDisediakan);
                        $(`#pemasok-${id} td:nth-child(3)`).text(response.nomorTelepon);
                        $(`#pemasok-${id} td:nth-child(4)`).text(response.email);
                        $('#Editpemasok').modal('hide');
                    }
                });
            });
    
            // Delete Pemasok
            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                if (confirm('Anda yakin ingin menghapus pemasok ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: `/pemasok/destroy/${id}`,
                        success: function(response) {
                            $(`#pemasok-${id}`).remove();
                        }
                    });
                }
            });
        });
    </script>
@endsection
