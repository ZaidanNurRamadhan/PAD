@extends('layout.owner')
@section('content')
<div class="container-fluid">
    <section class="card p-3">
        <div class="card-header d-flex justify-content-between align-items-center border-0">
            <p class="text-white">laporannnnbbbbbb</p>
            <h3 class="align-self-end">Laporan</h3>
            <div class="dropdown align-self-start">
                <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                    <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                    <span class="selected-text">Harian</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="dropdown-options" class="dropdown-options">
                    <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
                    <div class="dropdown-option mt-2" onclick="selectOption(this,'Bulanan')">Bulanan</div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col text-center">
                <p style="color: #1570EF" class="fw-semibold">Jumlah Transaksi</p>
                <p>{{ count($data) }}</p>
            </div>
            <div class="col text-center">
                <p style="color: #E19133" class="fw-semibold">Produk yang Terjual</p>
                <p>{{ array_sum(array_column($data, 'terjual')) }}</p>
            </div>
            <div class="col text-center">
                <p style="color: #845EBC" class="fw-semibold">Produk Retur</p>
                <p>{{ array_sum(array_column($data, 'jumlah')) - array_sum(array_column($data, 'terjual')) }}</p>
            </div>
        </div>
    </section>
</div>
<section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
    <div class="card-header d-flex justify-content-between border-0 mb-2">
        <h5 class="align-self-end">Rekap Transaksi</h5>
        <button class="btn btn-outline-secondary">Download</button>
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>{{ $item['produk'] }}</td>
                        <td>{{ $item['terjual'] }}</td>
                        <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['tanggal_keluar'] }}</td>
                        <td>{{ $item['tanggal_retur'] }}</td>
                        <td>{{ $item['waktu_edar'] }}</td>
                        <td class="{{ $item['status'] === 'Open' ? 'text-success' : 'text-danger' }}">{{ $item['status'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center">Tidak ada data</td></tr>
                @endforelse
                @for ($i = count($data); $i < 19; $i++)
                    <tr><td colspan="9"></td></tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between">
        <button class="btn btn-secondary">Prev</button>
        <span>Page 1 of 10</span>
        <button class="btn btn-secondary">Next</button>
    </div>
</section>
@endsection
