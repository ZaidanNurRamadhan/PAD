@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Manajemen Karyawan</h5>
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#Tambahkaryawan">Tambah Karyawan</button>
        </div>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Kontak</th>
                        <th>Username</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Afriza</td>
                        <td>081212795478</td>
                        <td>afriza123</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Editkaryawan">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">Hapus</button>
                        </td>
                    </tr>
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
    <section class="modal fade" id="Tambahkaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Karyawan</label>
                        <input type="text" name="kname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" style="max-width: 273px;" placeholder="Masukkan username">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control" style="max-width: 273px;" placeholder="Masukkan password">
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
      <section class="modal fade" id="Editkaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Karyawan</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Karyawan</label>
                        <input type="text" name="kname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" style="max-width: 273px;" placeholder="Masukkan username">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control" style="max-width: 273px;" placeholder="Masukkan password">
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
      <section class="modal fade" id="Hapuskaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Karyawan</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <p>Anda yakin ingin menghapus informasi karyawan ini?</p>
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
