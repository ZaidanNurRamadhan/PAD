@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column vh-min-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Transaksi</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahtransaksi" type="button">Tambah Transaksi</button>
        </div>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Total Harga</th>
                        <th>Jumlah</th>
                        <th>Produk</th>
                        <th>Terjual</th>
                        <th>Harga</th>
                        <th>Tanggal keluar</th>
                        <th>Tanggal Retur</th>
                        <th>Waktu Edar</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Zaidan Punya</td>
                        <td>63</td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>43</td>
                        <td>Lays</td>
                        <td>40</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td></td>
                        <td>19</td>
                        <td>
                            <span class="text-success">Open</span>
                            <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="#Edittransaksi"><i class="fas fa-angle-right"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>20</td>
                        <td>Bru</td>
                        <td>20</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td>30/12/22</td>
                        <td>19</td>
                        <td>
                            <span class="text-danger">Closed</span>
                            <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="#Edittransaksi"><i class="fas fa-angle-right"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sinar Mas</td>
                        <td>63</td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>43</td>
                        <td>Lays</td>
                        <td>40</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td></td>
                        <td>19</td>
                        <td>
                            <span class="text-success">Open</span>
                            <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="#Edittransaksi"><i class="fas fa-angle-right"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>20</td>
                        <td>Bru</td>
                        <td>20</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td>30/12/22</td>
                        <td>19</td>
                        <td>
                            <span class="text-danger">Closed</span>
                            <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="#Edittransaksi"><i class="fas fa-angle-right"></i></a>
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
    <section class="modal fade" id="Tambahtransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Transaksi</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Toko</label>
                        <input type="text" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Nama Produk</label>
                        <input type="text" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Tanggal Keluar</label>
                        <input type="date" name="tglkeluar" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga</label>
                        <input type="text" name="harga" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Terjual</label>
                        <input type="text" name="jstok" class="form-control" style="max-width: 273px;" placeholder="Masukkan produk terjual">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Tanggal Retur</label>
                        <input type="text" name="tglretur" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
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
      <section class="modal fade" id="Edittransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
          <main class="modal-content">
            <header class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Transaksi</h1>
            </header>
            <form action="" method="post">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="">Nama Toko</label>
                        <input type="text" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Nama Produk</label>
                        <input type="text" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Tanggal Keluar</label>
                        <input type="date" name="tglkeluar" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Harga</label>
                        <input type="text" name="harga" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Terjual</label>
                        <input type="text" name="jstok" class="form-control" style="max-width: 273px;" placeholder="Masukkan produk terjual">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="">Tanggal Retur</label>
                        <input type="date" name="tglretur" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
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
