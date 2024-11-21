@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between mb-2">
            <h3>Manajemen Toko</h3>
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#Tambahtoko">Tambah Toko</button>
        </div>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tokoList as $toko)
                        <tr>
                            <td>{{ $toko->name }}</td>
                            <td>{{ $toko->namaPemilik }}</td>
                            <td>{{ $toko->address }}</td>
                            <td>{{ $toko->phone_number }}</td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko{{ $toko->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko{{ $toko->id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
    {{-- tambah --}}
    <section class="modal fade" id="Tambahtoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Toko</h1>
            </header>
            <form action="{{ route('toko.store') }}" method="post">
                @csrf
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Toko</label>
                        <input type="text" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Nama Pemilik</label>
                        <input type="text" name="pemilikname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemilik toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control" style="max-width: 273px;" placeholder="Masukkan alamat toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="kontak" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak toko">
                    </section>
                </article>
                <footer class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Tambah</button>
                </footer>
            </form>
        </main>
        </div>
      </section>
      {{-- edit --}}
      @foreach ($tokoList as $toko)
      <section class="modal fade" id="Edittoko{{ $toko->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Toko</h1>
            </header>
            <form action="{{ route('toko.update', $toko->id) }}" method="post">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Toko</label>
                        <input type="text" name="tname" class="form-control" style="max-width: 273px;" value="{{ $toko->name }}" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Nama Pemilik</label>
                        <input type="text" name="pemilikname" class="form-control" style="max-width: 273px;" value="{{ $toko->namaPemilik }}" placeholder="Masukkan nama pemilik toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control" style="max-width: 273px;" value="{{ $toko->address }}" placeholder="Masukkan alamat toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="kontak" class="form-control" style="max-width: 273px;" value="{{ $toko->phone_number }}" placeholder="Masukkan kontak toko">
                    </section>
                </article>
                <footer class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </footer>
            </form>
        </main>
        </div>
      </section>
      @endforeach
      {{-- hapus --}}
      @foreach ($tokoList as $toko)
      <section class="modal fade" id="Hapustoko{{ $toko->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Toko</h1>
            </header>
            <form action="{{ route('toko.destroy', $toko->id) }}" method="post">
                @csrf
                @method('DELETE')
                <article class="modal-body">
                    <p>Anda yakin ingin menghapus toko ini?</p>
                </article>
                <footer class="modal-footer">
                  <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" style="width: 100px;" class="btn btn-danger">Ya</button>
                </footer>
            </form>
        </main>
        </div>
      </section>
      @endforeach
@endsection