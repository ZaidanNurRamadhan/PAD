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
                <p>{{ $data->total() }}</p> <!-- Total transactions from pagination -->
            </div>
            <div class="col text-center">
                <p style="color: #E19133" class="fw-semibold">Produk yang Terjual</p>
                <p>{{ $data->sum('terjual') }}</p> <!-- Sum of terjual (sold products) from paginated data -->
            </div>
            <div class="col text-center">
                <p style="color: #845EBC" class="fw-semibold">Produk Retur</p>
                <p>{{ array_sum(array_column($data, 'jumlahDibeli')) - array_sum(array_column($data, 'terjual')) }}</p>
            </div>
        </div>
    </section>

    <section class="table-container mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
        <div class="d-flex justify-content-between border-0 mb-2 flex-column">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="align-self-center">Rekap Transaksi</h5>
                <div class="dropdown">
                    <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                        <span class="selected-text">Download</span>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option" onclick="selectOption(this,'Harian')">
                            <a href="{{ route('laporan.export') }}" class="btn btn-outline-secondary w-100 text-start">Download Excel</a>
                        </div>
                        <div class="dropdown-option mt-2" onclick="selectOption(this,'Bulanan')">
                            <a href="{{ route('laporanpdf.export') }}" class="btn btn-outline-secondary w-100 text-start">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table table-responsive flex-grow-1 table-data">
                <table class="table overflow-auto">
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
                    <tbody class="h-100">
                        @forelse($data as $item)
                            @if($item->status === 'closed')
                                <tr>
                                    <td>{{ $item->toko->name }}</td>
                                </tr>
                                <tr>
                                    <td>Rp{{ number_format($item->harga * $item->jumlahDibeli, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->jumlahDibeli }}</td>
                                    <td class="text-center">{{ $item->produk->name }}</td>
                                    <td class="text-center">{{ $item->terjual }}</td>
                                    <td class="text-center">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->returDate)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $item->waktu_edar }}</td>
                                    <td class="text-danger text-center">{{ $item->status }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr><td colspan="9" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            {!! $data->links('pagination::bootstrap-5') !!} <!-- This will generate the pagination links -->
    </section>
</div>
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
