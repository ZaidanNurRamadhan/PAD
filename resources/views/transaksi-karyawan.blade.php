@extends('layout.karyawan')

@section('content')
<section class="table-container d-flex flex-column">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Transaksi</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahtransaksi" type="button">Tambah Transaksi</button>
    </div>

    <div class="table-wrapper flex-grow-1">
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
                @foreach($data as $item)
                    <tr>
                        <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>{{ $item['produk'] }}</td>
                        <td>{{ $item['terjual'] }}</td>
                        <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['tanggal_keluar'] }}</td>
                        <td>{{ $item['tanggal_retur'] }}</td>
                        <td>{{ $item['waktu_edar'] }}</td>
                        <td>
                            <span class="{{ $item['status'] === 'Open' ? 'text-success' : 'text-danger' }}">{{ $item['status'] }}</span>
                            <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="# Edittransaksi"><i class="fas fa-angle-right"></i></a>
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
                    <input type="date" name="tglretur" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
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
                    <input type="text" name="tglretur" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
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

<style>
    /* Flexbox untuk memastikan konten memenuhi layar penuh */
    .table-container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Buat konten tabel bisa tumbuh */
    .table-wrapper {
        flex-grow: 1;
        overflow-y: auto;
        margin-bottom: 20px; /* Jarak agar tidak menempel dengan pagination */
    }

    /* Agar pagination selalu di bawah */
    .pagination {
        margin-top: auto;
        padding: 10px 0;
        border-top: 1px solid #ddd;
    }

    /* Desain tombol pagination */
    .btn-light {
        border: 1px solid #ddd;
        background-color: #f8f9fa;
    }

    /* Styling tabel */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #dc3545;
    }
</style>
@endsection
