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
                    @forelse($data as $item)
                        <tr colspan="9">
                            <td>{{ $item['toko']}}</td>
                        </tr>
                        <tr>
                            <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                            <td>{{ $item['jumlahDibeli'] }}</td>
                            <td>{{ $item['produk'] }}</td>
                            <td>{{ $item['terjual'] }}</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['tanggal_keluar'])->format('d/m/Y')}}</td>
                            <td>{{ $item['tanggal_retur'] }}</td>
                            <td>{{ $item['waktu_edar'] }}</td>
                            <td class="text-center">
                                <span class="{{ $item['status'] == 'closed' ? 'text-danger' : 'text-success' }}">
                                    {{ ucfirst($item['status']) }}
                                </span>
                                <a class="btn btn-sm p-0 m-0" onclick="editTransaksi({{ $item['id'] }})">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="9" class="text-center">Tidak ada data</td></tr>
                        @endforelse

                        {{-- Menambahkan baris kosong dengan border jika data kurang dari 20 --}}
                        @for ($i = count($data); $i < 19; $i++)
                            <tr><td colspan="9"></td></tr>
                        @endfor
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>

    @include('component.EditTransaksi')
    @include('component.TambahTransaksi')

    @endsection
