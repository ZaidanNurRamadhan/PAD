@extends('layout.karyawan')
@section('content')
    <section class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Transaksi</h5>
            <button class="btn btn-primary">Tambah Transaksi</button>
        </div>
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Zaidan Punya</td>
                    <td>63</td>
                    <td>Rp62000</td>
                    <td>43</td>
                    <td>Lays</td>
                    <td>40</td>
                    <td>Rp1.500</td>
                    <td>11/12/22</td>
                    <td>19</td>
                    <td><span class="text-success">Open</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>20</td>
                    <td>Rp62000</td>
                    <td>20</td>
                    <td>Bru</td>
                    <td>20</td>
                    <td>Rp1.500</td>
                    <td>11/12/22</td>
                    <td>30/12/22</td>
                    <td><span class="text-danger">Closed</span></td>
                </tr>
                <tr>
                    <td>Sinar Mas</td>
                    <td>63</td>
                    <td>Rp62000</td>
                    <td>43</td>
                    <td>Lays</td>
                    <td>40</td>
                    <td>Rp1.500</td>
                    <td>11/12/22</td>
                    <td>19</td>
                    <td><span class="text-success">Open</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>20</td>
                    <td>Rp62000</td>
                    <td>20</td>
                    <td>Bru</td>
                    <td>20</td>
                    <td>Rp1.500</td>
                    <td>11/12/22</td>
                    <td>30/12/22</td>
                    <td><span class="text-danger">Closed</span></td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <button class="btn btn-light">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-light">Next</button>
        </div>
    </section>
@endsection
