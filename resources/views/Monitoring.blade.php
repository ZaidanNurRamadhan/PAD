@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column justify-content-between" style="height: 100vh;">
        <div class="card-header d-flex justify-content-between bg-white position-sticky terlaris">
            <div class="fs-4">Monitoring Data Produk</div>
            </div>
        </div>
        <div class="table-responsive scrollable-table w-100 mt-2">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Waktu Edar</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Hari</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        @if($item['status'] === 'closed')
                            <tr>
                                <td>{{$item['nama_toko']}}</td>
                                <td>{{$item['waktu_edar']}}</td>
                                <td>{{$item['jumlah']}}</td>
                                <td>{{$item['kategori']}}</td>
                                <td>{{$item['hari']}}</td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal_keluar'])->format('d/m/Y')}}</td>
                            </tr>
                        @endif
                        @empty
                            <tr><td colspan="9" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                    @for ($i = count($data); $i < 10; $i++)
                        <tr><td colspan="6"></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Pagination di pojok bawah -->
        <div class="pagination">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
@endsection
