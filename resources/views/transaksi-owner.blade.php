@extends('layout.owner')

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
            <tbody id="transaksiTableBody">
                <tr><td colspan="9" class="text-center">Loading data...</td></tr>
            </tbody>
        </table>
    </div>
    <nav id="pagination-nav" class="mt-3 d-flex justify-content-between"></nav>
</section>

@include('component.EditTransaksi')
@include('component.TambahTransaksi')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.getElementById('transaksiTableBody');
        const token = localStorage.getItem('authToken');
        const itemsPerPage = 10;
        let transaksiData = [];
        let currentPage = 1;

        if (!token) {
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Authentication token not found. Please login again.</td></tr>';
            return;
        }

        fetch('/api/transaksi', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            transaksiData = data.data ? data.data : data;
            renderTable();
            renderPagination();
        })
        .catch(error => {
            tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">${error.message}</td></tr>`;
        });

        function renderTable() {
            tableBody.innerHTML = '';
            if (transaksiData.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
                return;
            }

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = transaksiData.slice(startIndex, endIndex);

            let rows = '';
            pageData.forEach(item => {
                rows += `
                    <tr><td colspan="9">${item.toko || ''}</td></tr>
                    <tr>
                        <td>Rp${Number(item.total_harga).toLocaleString('id-ID')}</td>
                        <td>${item.jumlahDibeli || ''}</td>
                        <td>${item.produk || ''}</td>
                        <td>${item.terjual || ''}</td>
                        <td>Rp${Number(item.harga).toLocaleString('id-ID')}</td>
                        <td>${new Date(item.tanggal_keluar).toLocaleDateString('id-ID')}</td>
                        <td>${item.tanggal_retur || ''}</td>
                        <td>${item.waktu_edar || ''}</td>
                        <td class="text-center">
                            <span class="${item.status === 'closed' ? 'text-danger' : 'text-success'}">
                                ${item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : ''}
                            </span>
                            <a class="btn btn-sm p-0 m-0" onclick="editTransaksi(${item.id})">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </td>
                    </tr>
                `;
            });

            tableBody.innerHTML = rows;
        }

        function renderPagination() {
            const nav = document.getElementById('pagination-nav');
            nav.innerHTML = '';

            const totalPages = Math.ceil(transaksiData.length / itemsPerPage);
            if (totalPages <= 1) return;

            const prevBtn = document.createElement('button');
            prevBtn.textContent = 'Previous';
            prevBtn.className = 'btn btn-outline-primary me-2';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    renderPagination();
                }
            };
            nav.appendChild(prevBtn);

            const pageButtonsContainer = document.createElement('div');
            pageButtonsContainer.className = 'd-inline-flex';

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
                btn.onclick = () => {
                    currentPage = i;
                    renderTable();
                    renderPagination();
                };
                pageButtonsContainer.appendChild(btn);
            }

            nav.appendChild(pageButtonsContainer);

            const nextBtn = document.createElement('button');
            nextBtn.textContent = 'Next';
            nextBtn.className = 'btn btn-outline-primary';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    renderPagination();
                }
            };
            nav.appendChild(nextBtn);
        }

        window.editTransaksi = function(id) {
            const transaksi = transaksiData.find(item => item.id === id);
            if (!transaksi) {
                alert('Data transaksi tidak ditemukan');
                return;
            }

            document.getElementById('toko_id').value = transaksi.toko_id || '';
            document.getElementById('produk_id').value = transaksi.produk_id || '';
            document.getElementById('transactionDate').value = transaksi.tanggal_keluar ? new Date(transaksi.tanggal_keluar).toISOString().split('T')[0] : '';
            document.getElementById('harga').value = transaksi.harga || '';
            document.getElementById('jumlahDibeli').value = transaksi.jumlahDibeli || '';
            document.getElementById('terjual').value = transaksi.terjual || '';
            document.getElementById('tanggal_retur').value = transaksi.tanggal_retur || '';

            const editForm = document.getElementById('editTransaksiForm');
            editForm.action = `http://127.0.0.1:8000/transaksi/${id}`;

            const editModal = new bootstrap.Modal(document.getElementById('Edittransaksi'));
            editModal.show();
        };
    });
</script>

@endsection
