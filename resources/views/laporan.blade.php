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
                    <span class="selected-text" id="filterText">
                        {{ request('filter') === 'bulanan' ? 'Bulanan' : 'Harian' }}
                    </span>
                    <span class="arrow">▼</span>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option" onclick="applyFilter('harian')">Harian</div>
                    <div class="dropdown-option mt-2" onclick="applyFilter('bulanan')">Bulanan</div>
                </div>
            </div>
            {{-- <p id="debugUrl" style="margin-top: 10px; font-size: 0.9em; color: #555;"></p> --}}

            <script>
                function applyFilter(filter) {
                    currentFilter = filter;
                    currentPage = 1;
                    document.getElementById('filterText').textContent = filter.charAt(0).toUpperCase() + filter.slice(1);
                    const dropdownSelected = document.querySelector('.dropdown-selected');
                    const dropdownOptions = dropdownSelected.nextElementSibling;
                    dropdownOptions.classList.remove('show');
                    fetchData();
                    // Close dropdown after selection
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
                <p id="jumlahTransaksi">{{ count($data) }}</p>
            </div>
            <div class="col text-center">
                <p style="color: #E19133" class="fw-semibold">Produk yang Terjual</p>
                <p id="produkTerjual">{{ array_sum(array_column($data, 'terjual')) }}</p>
            </div>
            <div class="col text-center">
                <p style="color: #845EBC" class="fw-semibold">Produk Retur</p>
                <p id="produkRetur">{{ array_sum(array_column($data, 'jumlahDibeli')) - array_sum(array_column($data, 'terjual')) }}</p>
            </div>
        </div>
    </section>
</div>
<section class="card mt-4 p-4 min-vh-100 d-flex flex-column">
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
            <tbody id="laporanTableBody">
                {{-- Table body will be rendered by JavaScript --}}
            </tbody>
        </table>
    </div>
</section>
<script>
    let currentFilter = '{{ $filter ?? "harian" }}';
    let currentPage = 1;
    const itemsPerPage = 10;
    let laporanData = [];

    function toggleDropdown(element) {
        const options = element.nextElementSibling; // Dropdown options
        options.classList.toggle('show'); // Toggle visibility
    }

    // function applyFilter(filter) {
    //     currentFilter = filter;
    //     currentPage = 1;
    //     document.getElementById('filterText').textContent = filter.charAt(0).toUpperCase() + filter.slice(1);
    //     fetchData();
    //     toggleDropdown(document.querySelector('.dropdown-selected'));
    // }

    function fetchData() {
        const token = localStorage.getItem('authToken');
        const url = `http://127.0.0.1:8000/api/laporan?filter=${currentFilter}`;
        // document.getElementById('debugUrl').textContent = `Fetching data from URL: ${url}`;
        fetch(url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                laporanData = data.data;
                // console.log(laporanData)
                renderSummary();
                renderTable();
                renderPagination();
            })
            .catch(error => {
                console.error('Error fetching laporan data:', error);
            });
    }

    function renderSummary() {
        const jumlahTransaksi = laporanData.length;
        const produkTerjual = laporanData.reduce((sum, item) => sum + (item.terjual || 0), 0);
        const produkRetur = laporanData.reduce((sum, item) => sum + ((item.jumlahDibeli || 0) - (item.terjual || 0)), 0);

        document.getElementById('jumlahTransaksi').textContent = jumlahTransaksi;
        document.getElementById('produkTerjual').textContent = produkTerjual;
        document.getElementById('produkRetur').textContent = produkRetur;
    }

    function renderTable() {
        const tbody = document.getElementById('laporanTableBody');
        tbody.innerHTML = '';

        if (laporanData.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 9;
            td.className = 'text-center';
            td.textContent = 'Tidak ada data';
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        laporanData.forEach(item => {
            if (item.status === 'closed') {
                const trToko = document.createElement('tr');
                const tdToko = document.createElement('td');
                tdToko.colSpan = 9;
                tdToko.textContent = item.toko;
                trToko.appendChild(tdToko);
                tbody.appendChild(trToko);

                const tr = document.createElement('tr');

                const totalHargaTd = document.createElement('td');
                totalHargaTd.textContent = `Rp${item.total_harga.toLocaleString('id-ID')}`;
                tr.appendChild(totalHargaTd);

                const jumlahTd = document.createElement('td');
                jumlahTd.className = 'text-center';
                jumlahTd.textContent = item.jumlahDibeli;
                tr.appendChild(jumlahTd);

                const produkTd = document.createElement('td');
                produkTd.className = 'text-center';
                produkTd.textContent = item.produk;
                tr.appendChild(produkTd);

                const terjualTd = document.createElement('td');
                terjualTd.className = 'text-center';
                terjualTd.textContent = item.terjual;
                tr.appendChild(terjualTd);

                const hargaTd = document.createElement('td');
                hargaTd.className = 'text-center';
                hargaTd.textContent = `Rp${item.harga.toLocaleString('id-ID')}`;
                tr.appendChild(hargaTd);

                const tanggalKeluarTd = document.createElement('td');
                tanggalKeluarTd.className = 'text-center';
                tanggalKeluarTd.textContent = new Date(item.tanggal_keluar).toLocaleDateString('id-ID');
                tr.appendChild(tanggalKeluarTd);

                const tanggalReturTd = document.createElement('td');
                tanggalReturTd.className = 'text-center';
                tanggalReturTd.textContent = item.tanggal_retur ? new Date(item.tanggal_retur).toLocaleDateString('id-ID') : '';
                tr.appendChild(tanggalReturTd);

                const waktuEdarTd = document.createElement('td');
                waktuEdarTd.className = 'text-center';
                waktuEdarTd.textContent = item.waktu_edar;
                tr.appendChild(waktuEdarTd);

                const statusTd = document.createElement('td');
                statusTd.className = 'text-danger text-center';
                statusTd.textContent = item.status;
                tr.appendChild(statusTd);

                tbody.appendChild(tr);
            }
        });
    }

    function renderPagination() {
        // Pagination removed as per user request
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Removed pagination button event listeners
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'http://127.0.0.1:8000/api/laporan/export-pdf';
        });
        applyFilter(currentFilter);
    });
</script>
@endsection
