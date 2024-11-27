@extends('layout.karyawan')
@section('content')
<div class="main-content">
    <section class="card">
        <div class="card-header">
            <h5>Laporan</h5>
            <button class="btn">Harian</button>
        </div>
        <div class="card-body">
            <div class="summary">
                <div>
                    <h3>4</h3>
                    <h6>Jumlah Transaksi</h6>
                </div>
                <div>
                    <h3>126</h3>
                    <h6>Produk yang Terjual</h6>
                </div>
                <div>
                    <h3>126</h3>
                    <h6>Produk Retur</h6>
                </div>
            </div>
            <h5>Rekap Transaksi</h5>
            <table>
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
                        <td colspan="9"><strong>Zaidan Punya</strong></td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>43</td>
                        <td>Lays</td>
                        <td>40</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td>30/12/22</td>
                        <td>19</td>
                        <td class="status">CLosed</td>
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
                        <td class="status">CLosed</td>
                    </tr>
                    <tr>
                        <td colspan="9"><strong>Sinar Mas</strong></td>
                    </tr>
                    <tr>
                        <td>Rp62000</td>
                        <td>43</td>
                        <td>Lays</td>
                        <td>40</td>
                        <td>Rp1.500</td>
                        <td>11/12/22</td>
                        <td>30/12/22</td>
                        <td>19</td>
                        <td class="status">CLosed</td>
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
                        <td class="status">CLosed</td>
                    </tr>
                </tbody>
            </table>
            <nav class="pagination">
                <button class="btn">Previous</button>
                <span>Page 1 of 10</span>
                <button class="btn">Next</button>
            </nav>
        </div>
    </section>
</div>
@endsection