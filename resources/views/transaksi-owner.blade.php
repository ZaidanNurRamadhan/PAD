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
                                <span class="text-success">{{ $item['status'] }}</span>
                                <a href="#" style="color: black; float: right;" data-bs-toggle="modal" data-bs-target="#Edittransaksi"><i class="fas fa-angle-right"></i></a>
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
    @include('component.TambahTransaksi')
    {{-- edit --}}
    @include('component.EditTransaksi')
    @endsection
