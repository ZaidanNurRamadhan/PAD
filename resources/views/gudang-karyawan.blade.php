@extends('layout.karyawan')
@section('content')
    <section class="card">
        <h5>Stok Keseluruhan</h5>
        <div class="row">
            <div class="col">
                <h6>Kategori</h6>
                <p>14</p>
            </div>
            <div class="col">
                <h6>Total Produk</h6>
                <p>868</p>
            </div>
            <div class="col">
                <h6>Produk Menipis</h6>
                <p>12</p>
            </div>
        </div>
    </section>
    <section class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Produk</h5>
            <button class="btn btn-primary">Tambah Produk</button>
        </div>
        <table class="table">
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
                        <button class="m-2 btn btn-warning btn-sm">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm">Hapus</button>
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
@endsection
