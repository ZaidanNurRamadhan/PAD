@extends('layout.karyawan')
@section('content')
    <section class="card p-4">
        <h4 class="fw-bold text-center">Stok Keseluruhan</h4>
        <div class="row mt-2">
            <div class="col text-center">
                <h5 style="color: #1570EF" class="fw-semibold">Kategori</h5>
                <p class="fw-semibold">14</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #E19133" class="fw-semibold">Total Produk</h5>
                <p class="fw-semibold">858</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #F36960" class="fw-semibold">Produk Menipis</h5>
                <p class="fw-semibold">12</p>
            </div>
        </div>
    </section>
    <section class="card mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Produk</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahproduk">
                Tambah Produk
              </button>
        </div>
        <table class="table table-transaksi">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Batas Kritis</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Maggi</td>
                    <td>Rp43000</td>
                    <td>Rp43000</td>
                    <td>43 Packets</td>
                    <td>12 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Bru</td>
                    <td>Rp25700</td>
                    <td>Rp43000</td>
                    <td>22 Packets</td>
                    <td>6 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Red Bull</td>
                    <td>Rp40500</td>
                    <td>Rp43000</td>
                    <td>36 Packets</td>
                    <td>9 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Bourn Vita</td>
                    <td>Rp50200</td>
                    <td>Rp43000</td>
                    <td>14 Packets</td>
                    <td>6 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Horlicks</td>
                    <td>Rp53000</td>
                    <td>Rp43000</td>
                    <td>10 Packets</td>
                    <td>5 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Harpic</td>
                    <td>Rp60500</td>
                    <td>Rp43000</td>
                    <td>8 Packets</td>
                    <td>5 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Ariel</td>
                    <td>Rp40800</td>
                    <td>Rp43000</td>
                    <td>23 Packets</td>
                    <td>7 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Scotch Brite</td>
                    <td>Rp35900</td>
                    <td>Rp43000</td>
                    <td>12 Packets</td>
                    <td>5 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Coca cola</td>
                    <td>Rp20500</td>
                    <td>Rp43000</td>
                    <td>41 Packets</td>
                    <td>10 Packets</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary">Prev</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
    <section class="modal fade" id="Tambahproduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Produk</label>
                        <input type="text" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga Beli</label>
                        <input type="text" name="hbeli" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga beli">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga Jual</label>
                        <input type="text" name="hjual" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga jual">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Jumlah Stok</label>
                        <input type="text" name="jstok" class="form-control" style="max-width: 273px;" placeholder="Masukkan jumlah stok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Ambang Kritis</label>
                        <input type="text" name="astok" class="form-control" style="max-width: 273px;" placeholder="Masukkan ambang kritis">
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
      {{-- hapus --}}
      <section class="modal fade" id="Hapusproduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content d-flex justify-content-center align-items-center">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Produk</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <p>Anda yakin ingin menghapus produk ini?</p>
                </article>
            </form>
            <footer class="modal-footer">
              <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" style="width: 100px;" class="btn btn-danger">Ya</button>
            </footer>
        </main>
        </div>
      </section>
      {{-- edit --}}
      <section class="modal fade" id="Edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Produk</label>
                        <input type="text" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga Beli</label>
                        <input type="text" name="hbeli" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga beli">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga Jual</label>
                        <input type="text" name="hjual" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga jual">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Jumlah Stok</label>
                        <input type="text" name="jstok" class="form-control" style="max-width: 273px;" placeholder="Masukkan jumlah stok">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Ambang Kritis</label>
                        <input type="text" name="astok" class="form-control" style="max-width: 273px;" placeholder="Masukkan ambang kritis">
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
