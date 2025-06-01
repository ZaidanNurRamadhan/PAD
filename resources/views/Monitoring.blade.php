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

        <nav aria-label="Page navigation" class="mt-3">
            <ul class="pagination justify-content-center" id="paginationControls">
                <!-- Pagination buttons will be rendered here -->
            </ul>
        </nav>
    </section>

<script>
    let currentPage = 1;
    const itemsPerPage = 10;

    function fetchMonitoringData(page = 1) {
        const token = localStorage.getItem('authToken');
        const url = `http://127.0.0.1:8000/api/monitoring?page=${page}`;

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
        const paginationControls = document.getElementById('paginationControls');
        paginationControls.innerHTML = '';

        if (!pagination) return;

        const { current_page, last_page } = pagination;

        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = 'page-item' + (current_page === 1 ? ' disabled' : '');
        const prevLink = document.createElement('a');
        prevLink.className = 'page-link';
        prevLink.href = '#';
        prevLink.textContent = 'Previous';
        prevLink.addEventListener('click', (e) => {
            e.preventDefault();
            if (current_page > 1) {
                currentPage = current_page - 1;
                fetchMonitoringData(currentPage);
            }
        });
        prevLi.appendChild(prevLink);
        paginationControls.appendChild(prevLi);

        // Page numbers
        for (let i = 1; i <= last_page; i++) {
            const pageLi = document.createElement('li');
            pageLi.className = 'page-item' + (i === current_page ? ' active' : '');
            const pageLink = document.createElement('a');
            pageLink.className = 'page-link';
            pageLink.href = '#';
            pageLink.textContent = i;
            pageLink.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                fetchMonitoringData(currentPage);
            });
            pageLi.appendChild(pageLink);
            paginationControls.appendChild(pageLi);
        }

        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = 'page-item' + (current_page === last_page ? ' disabled' : '');
        const nextLink = document.createElement('a');
        nextLink.className = 'page-link';
        nextLink.href = '#';
        nextLink.textContent = 'Next';
        nextLink.addEventListener('click', (e) => {
            e.preventDefault();
            if (current_page < last_page) {
                currentPage = current_page + 1;
                fetchMonitoringData(currentPage);
            }
        });
        nextLi.appendChild(nextLink);
        paginationControls.appendChild(nextLi);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchMonitoringData(currentPage);
    });
</script>
@endsection
