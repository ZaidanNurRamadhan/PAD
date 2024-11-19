@extends('layout.karyawan')
@section('content')
<div class="container-fluid">
    <section class="card p-4">
        <h3 class="text-center">Stok Keseluruhan</h3>
        <div class="row mt-4">
            <div class="col text-center">
                <h5 style="color: #1570EF" class="fw-semibold">Kategori</h5>
                <p class="fw-semibold">{{ $produks->groupBy('category')->count() ?? 0 }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #E19133" class="fw-semibold">Total Produk</h5>
                <p class="fw-semibold">{{ $produks->count() ?? 0 }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #F36960" class="fw-semibold">Produk Menipis</h5>
                <p class="fw-semibold">{{ $produks->filter(fn($p) => $p->stok < $p->batas_kritis)->count() ?? 0 }}</p>
            </div>
        </div>
    </section>
    <section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Produk</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahproduk">
                Tambah Produk
            </button>
        </div>
        <div class="table table-responsive flex-grow-1">
            <table class="table h-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Batas Kritis</th>
                    </tr>
                </thead>
                <tbody class="h-100">
                    @foreach($data as $produk)
                        <tr>
                            <td>{{ $produk['id'] }}</td>
                            <td>{{ $produk['name'] }}</td>
                            <td>Rp{{ number_format($produk['harga_beli'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($produk['harga_jual'], 0, ',', '.') }}</td>
                            <td>{{ $produk['stok'] }} Packets</td>
                            <td>{{ $produk['batas_kritis'] }} Packets</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary">Prev</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
        {{-- tambah --}}
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
@endsection
