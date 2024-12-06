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
                    <span class="selected-text">
                        {{ request('filter') === 'bulanan' ? 'Bulanan' : 'Harian' }}
                    </span>
                    <span class="arrow">▼</span>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option" onclick="applyFilter('harian')">Harian</div>
                    <div class="dropdown-option mt-2" onclick="applyFilter('bulanan')">Bulanan</div>
                </div>
            </div>

            <script>
                function applyFilter(filter) {
                    const url = new URL(window.location.href); // Ambil URL saat ini
                    url.searchParams.set('filter', filter); // Set parameter filter
                    window.location.href = url; // Redirect ke URL baru
                }
            
                function toggleDropdown(element) {
                    const options = element.nextElementSibling; // Dropdown options
                    options.classList.toggle('show'); // Toggle visibility
                }
            </script>
            
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
                <p>{{ array_sum(array_column($data, 'jumlahDibeli')) - array_sum(array_column($data, 'terjual')) }}</p>
            </div>
        </div>
    </section>
</div>
<section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
    <div class="card-header d-flex justify-content-between border-0 mb-2">
        <h5 class="align-self-end">Rekap Transaksi</h5>
        <a href="{{ route('laporan.export') }}" id="downloadBtn">
            <button class="btn btn-outline-secondary">Download</button>
        </a>
    </div>
    <div class="table-responsive flex-grow-1">
        <table class="table">
            <thead>
                <tr>
                    <th>Total Harga</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Produk</th>
                    <th class="text-center">Terjual</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Tanggal keluar</th>
                    <th class="text-center">Tanggal Retur</th>
                    <th class="text-center">Waktu Edar</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
<<<<<<< HEAD
                    @if($item['status'] === 'closed')
                        <tr>
                            <td>{{$item['toko']}}</td>
                        </tr>
                        <tr>
                            <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item['jumlahDibeli'] }}</td>
                            <td class="text-center">{{ $item['produk'] }}</td>
                            <td class="text-center">{{ $item['terjual'] }}</td>
                            <td class="text-center">Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal_keluar'])->format('d/m/Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal_retur'])->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $item['waktu_edar'] }}</td>
                            <td class="text-danger text-center">{{ $item['status'] }}</td>
                        </tr>
                    @endif
                @empty
=======
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
>>>>>>> ae4c336cde000dadff925cae72fa57e64d33eaaa
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
<<<<<<< HEAD
<script>$data = Transaksi::where('status', 'Close')->get();
    return view('laporan', ['data' => $data]);
    document.getElementById('downloadBtn').addEventListener('click', function(e) {
    e.preventDefault(); // Mencegah aksi default, agar bisa memanipulasi pengunduhan
    window.location.href = e.target.href; // Arahkan ke URL download

    // Setelah download, redirect ke halaman laporan
    setTimeout(function() {
        window.location.href = '/laporan'; // URL tujuan setelah download
    }, 2000); // Tunda beberapa detik agar pengunduhan bisa dimulai terlebih dahulu
});

    </script>
@endsection
=======
@endsection
>>>>>>> ae4c336cde000dadff925cae72fa57e64d33eaaa
