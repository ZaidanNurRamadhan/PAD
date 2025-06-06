@extends('layout.owner')
@section('content')
<style>
    /* Make thead sticky */
    .table-responsive {
        max-height: 570px; /* Adjust as needed */
        overflow-y: auto;
    }
    thead th {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1500;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }
</style>
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
    <div class="card-header d-flex justify-content-between border-0 px-0">
        <h5 class="align-self-end text-judul">Rekap Transaksi</h5>
        <a href="{{ route('laporan.export') }}" id="downloadBtn">
            <button class="btn btn-outline-secondary">Download</button>
        </a>
    </div>
    <div class="table-responsive flex-grow-1 table-data">
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
    const itemsPerPage = 10;
    let laporanData = [];
    let currentPage = 1;

    function toggleDropdown(element) {
        const options = element.nextElementSibling; // Dropdown options
        options.classList.toggle('show'); // Toggle visibility
    }

    function applyFilter(filter) {
        currentFilter = filter;
        currentPage = 1;
        document.getElementById('filterText').textContent = filter.charAt(0).toUpperCase() + filter.slice(1);
        fetchData();
        toggleDropdown(document.querySelector('.dropdown-selected'));
    }

    function fetchData() {
        const token = localStorage.getItem('authToken');
        const url = `/api/laporan?filter=${currentFilter}`;
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

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = laporanData.slice(startIndex, endIndex);

        pageData.forEach(item => {
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
        let paginationNav = document.getElementById('pagination-nav');
        if (!paginationNav) {
            // Create pagination nav if it doesn't exist
            const section = document.querySelector('section.card.mt-4.p-4.min-vh-100.d-flex.flex-column');
            paginationNav = document.createElement('nav');
            paginationNav.id = 'pagination-nav';
            paginationNav.setAttribute('aria-label', 'Page navigation');
            paginationNav.className = 'mt-3 d-flex justify-content-between';
            section.appendChild(paginationNav);
        }

        paginationNav.innerHTML = '';

        const totalPages = Math.ceil(laporanData.length / itemsPerPage);

        if (totalPages <= 1) {
            return; // No need for pagination if only one page
        }

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Previous';
        prevBtn.className = 'btn btn-outline-primary me-2';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
                renderPagination();
            }
        });
        paginationNav.appendChild(prevBtn);

        // Page buttons as buttons inside a div container
        const pageButtonsContainer = document.createElement('div');
        pageButtonsContainer.className = 'd-inline-flex';

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
            pageButton.type = 'button';
            pageButton.addEventListener('click', () => {
                currentPage = i;
                renderTable();
                renderPagination();
            });
            pageButtonsContainer.appendChild(pageButton);
        }
        paginationNav.appendChild(pageButtonsContainer);

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.className = 'btn btn-outline-primary';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
                renderPagination();
            }
        });
        paginationNav.appendChild(nextBtn);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'http://127.0.0.1:8000/api/laporan/export-pdf';
        });
        applyFilter(currentFilter);
    });
</script>
@endsection
