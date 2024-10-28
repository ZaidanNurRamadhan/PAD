@extends('layout.owner')
@section('content')
    <section class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pemasok</h2>
        <button class="btn btn-primary btn-add" type="button" data-bs-toggle="modal" data-bs-target="#Tambahpemasok">Tambah Pemasok</button>
    </div>
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
            <tr>
                <td>Tom Homan</td>
                <td>Maaza</td>
                <td>9867543638</td>
                <td>tomhoman@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Vaandir</td>
                <td>Dairy Milk</td>
                <td>9867545656</td>
                <td>vaandir@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Charin</td>
                <td>Tomato</td>
                <td>925745457</td>
                <td>charin@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Hoffman</td>
                <td>Milk Bikis</td>
                <td>9367546331</td>
                <td>hoffman@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Fainden Juke</td>
                <td>Marie Gold</td>
                <td>9667545982</td>
                <td>fainden@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Martin</td>
                <td>Saffola</td>
                <td>9867545457</td>
                <td>martin@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Joe Nike</td>
                <td>Good day</td>
                <td>9567545769</td>
                <td>joenike@gmail.com</td>
                <td>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
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
    {{-- hapus --}}
    <section class="modal fade" id="Hapuspemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Pemasok</h1>
            </header>
            <form action="" method="post">
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
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Pemasok</label>
                        <input type="text" name="pemasokname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Produk</label>
                        <input type="text" name="produk" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Kontak</label>
                        <input type="number" name="kontak" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak pemasok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email pemasok">
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
      <section class="modal fade" id="Editpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemasok</h1>
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
@endsection
