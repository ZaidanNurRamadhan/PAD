@extends('layout.karyawan')
@section('content')
    <section class="table-container d-flex flex-column vh-min-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Transaksi</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahtransaksi" type="button">Tambah Transaksi</button>
        </div>
        <div class="table-responsive flex-grow-1 table-data">
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
                            <td>{{ $item->toko->name}}</td>
                        </tr>
                        <tr>
                            <td>Rp{{ number_format($item->harga * $item->jumlahDibeli, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlahDibeli }}</td>
                            <td>{{ $item->produk->name }}</td>
                            <td>{{ $item->terjual }}</td>
                            <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->transactionDate)->format('d/m/Y')}}</td>
                            <td>{{ \Carbon\Carbon::parse($item->returDate)->format('d/m/Y')}}</td>
                            <td>{{ $item->waktuEdar }}</td>
                            <td class="text-center">
                                <span class="{{ $item->status == 'closed' ? 'text-danger' : 'text-success' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <a class="btn btn-sm p-0 m-0" onclick="editTransaksi({{ $item->id }})">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="9" class="text-center">Tidak ada data</td></tr>
                        @endforelse

                        {{-- Menambahkan baris kosong dengan border jika data kurang dari 20 --}}
                        @for ($i = count($data); $i < 10; $i++)
                            <tr><td colspan="9"></td></tr>
                        @endfor
                </tbody>
            </table>
        </div>
        {!! $data->links('pagination::bootstrap-5') !!} <!-- This will generate the pagination links -->
    </section>

    @include('component.EditTransaksi')
    @include('component.TambahTransaksi')

    @endsection
