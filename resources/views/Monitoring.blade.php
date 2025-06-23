@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column justify-content-between" style="height: 100vh;">
        <div class="card-header d-flex justify-content-between bg-white position-sticky terlaris">
            <div class="fs-4">Monitoring Data Produk</div>
            </div>
        </div>
        <div class="table-responsive scrollable-table w-100 mt-2 flex-grow-1">
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
                <tbody id="monitoringTableBody">
                    <tr><td colspan="6" class="text-center">Loading data...</td></tr>
                </tbody>
            </table>
        </div>

        {{-- <div id="pagination-nav" class="mt-3"></div> --}}
    </section>

<script>
    let currentPage = 1;
    const itemsPerPage = 10;

    function fetchMonitoringData(page = 1) {
        const token = localStorage.getItem('authToken');
        const url = `/api/monitoring?page=${page}`;

        fetch(url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderTable(data.data);
                renderPagination(data.pagination);
            } else {
                renderTable([]);
                renderPagination(null);
            }
        })
        .catch(error => {
            console.error('Error fetching monitoring data:', error);
            renderTable([]);
            renderPagination(null);
        });
    }

    function renderTable(data) {
        const tbody = document.getElementById('monitoringTableBody');
        tbody.innerHTML = '';

        if (!data || data.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 6;
            td.className = 'text-center';
            td.textContent = 'Tidak ada data';
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        data.forEach(item => {
            if (item.status === 'open') {
                const tr = document.createElement('tr');

                const namaTokoTd = document.createElement('td');
                namaTokoTd.textContent = item.nama_toko;
                tr.appendChild(namaTokoTd);

                const waktuEdarTd = document.createElement('td');
                waktuEdarTd.textContent = item.waktu_edar;
                tr.appendChild(waktuEdarTd);

                const jumlahTd = document.createElement('td');
                jumlahTd.textContent = item.jumlah;
                tr.appendChild(jumlahTd);

                const kategoriTd = document.createElement('td');
                kategoriTd.textContent = item.kategori;
                tr.appendChild(kategoriTd);

                const hariTd = document.createElement('td');
                hariTd.textContent = item.hari;
                tr.appendChild(hariTd);

                const tanggalKeluarTd = document.createElement('td');
                tanggalKeluarTd.textContent = new Date(item.tanggal_keluar).toLocaleDateString('id-ID');
                tr.appendChild(tanggalKeluarTd);

                tbody.appendChild(tr);
            }
        });
    }

    function renderPagination(pagination) {
        let paginationNav = document.getElementById('pagination-nav');

        if (!paginationNav) {
            paginationNav = document.createElement('div');
            paginationNav.id = 'pagination-nav';
            paginationNav.className = 'mt-3 d-flex justify-content-between';
            const container = document.querySelector('.table-container');
            container.appendChild(paginationNav);
        }

        paginationNav.innerHTML = '';

        if (!pagination) return;

        const { current_page, last_page } = pagination;

        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Previous';
        prevBtn.className = 'btn btn-outline-primary me-2';
        prevBtn.disabled = current_page === 1;
        prevBtn.addEventListener('click', () => {
            if (current_page > 1) {
                currentPage = current_page - 1;
                fetchMonitoringData(currentPage);
            }
        });
        paginationNav.appendChild(prevBtn);

        const pageContainer = document.createElement('div');
        pageContainer.className = 'd-inline-flex';

        for (let i = 1; i <= last_page; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = 'btn me-2 ' + (i === current_page ? 'btn-primary' : 'btn-outline-primary');
            btn.addEventListener('click', () => {
                currentPage = i;
                fetchMonitoringData(currentPage);
            });
            pageContainer.appendChild(btn);
        }
        paginationNav.appendChild(pageContainer);

        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.className = 'btn btn-outline-primary';
        nextBtn.disabled = current_page === last_page;
        nextBtn.addEventListener('click', () => {
            if (current_page < last_page) {
                currentPage = current_page + 1;
                fetchMonitoringData(currentPage);
            }
        });
        paginationNav.appendChild(nextBtn);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchMonitoringData(currentPage);
    });
</script>
@endsection
