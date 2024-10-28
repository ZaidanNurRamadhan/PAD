@extends('layout.owner')
@section('content')
<section class="card">
    <div class="card-header d-flex justify-content-between align-items-center border-0 p-3">
        <h5 class="align-self-end">Laporan</h5>
        <div class="dropdown align-self-start">
            <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                <span class="selected-text">Harian</span>
                <span class="arrow">▼</span>
            </div>
            <div class="dropdown-options" class="dropdown-options">
                <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
                <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
                <div class="dropdown-option" onclick="selectOption(this,'Tahunan')">Tahunan</div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col text-center">
            <p>4</p>
            <p>Jumlah Transaksi</p>
        </div>
        <div class="col text-center">
            <p>126</p>
            <p>Produk yang Terjual</p>
        </div>
        <div class="col text-center">
            <p>126</p>
            <p>Produk Retur</p>
        </div>
    </div>
</section>
<section class="card mt-4 p-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Rekap Transaksi</h5>
        <button class="btn btn-outline-secondary">Download</button>
    </div>
    <div class="table-responsive">
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
                    <td class="text-danger">Closed</td>
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
                    <td class="text-danger">Closed</td>
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
                    <td class="text-danger">Closed</td>
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
                    <td class="text-danger">Closed</td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary">Prev</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </div>
</section>
@endsection
