@extends('layout.owner')
@section('content')
    <section class="table-container">
        <div class="d-flex justify-content-between">
            <h5>Manajemen Toko</h5>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#Tambahtoko">Tambah Toko</button>
        </div>
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
                <tr>
                    <td>Zaidan Punya</td>
                    <td>Zaidan</td>
                    <td>Sindangruang</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Sinar Mas</td>
                    <td>Farhan</td>
                    <td>Yogyakarta</td>
                    <td>9867545368</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>Jaya Abadi</td>
                    <td>Salman</td>
                    <td>Yogyakarta</td>
                    <td>7687764556</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                        <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
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
            <form action="" method="post">
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
            </form>
            <footer class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary">Tambah</button>
            </footer>
        </main>
        </div>
      </section>
      {{-- edit --}}
      <section class="modal fade" id="Edittoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Toko</h1>
            </header>
            <form action="" method="post">
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
            </form>
            <footer class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary">Simpan</button>
            </footer>
        </main>
        </div>
      </section>
      {{-- hapus --}}
      <section class="modal fade" id="Hapustoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <p>Anda yakin ingin menghapus toko ini?</p>
                </article>
            </form>
            <footer class="modal-footer">
              <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" style="width: 100px;" class="btn btn-danger">Ya</button>
            </footer>
        </main>
        </div>
      </section>
@endsection
