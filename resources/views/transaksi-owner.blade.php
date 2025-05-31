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
                <tbody id="transaksiTableBody">
                    <tr><td colspan="9" class="text-center">Loading data...</td></tr>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.getElementById('transaksiTableBody');
            const token = localStorage.getItem('authToken');

            if (!token) {
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Authentication token not found. Please login again.</td></tr>';
                return;
            }

                fetch('http://127.0.0.1:8000/api/transaksi', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept' : 'application/json'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch data: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const transaksiData = data.data ? data.data : data;
                    if (!transaksiData || transaksiData.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
                        return;
                    }

                let rows = '';
                transaksiData.forEach(item => {
                    rows += `
                        <tr colspan="9">
                            <td>${item.toko || ''}</td>
                        </tr>
                        <tr>
                            <td>Rp${Number(item.total_harga).toLocaleString('id-ID')}</td>
                            <td>${item.jumlahDibeli || ''}</td>
                            <td>${item.produk ? item.produk.name : ''}</td>
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

                // Add empty rows if less than 20
                const emptyRowsCount = 19 - transaksiData.length;
                for (let i = 0; i < emptyRowsCount; i++) {
                    rows += '<tr><td colspan="9"></td></tr>';
                }

                tableBody.innerHTML = rows;
            })
                .catch(error => {
                    tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">${error.message}</td></tr>`;
                });
        });
    </script>

    @endsection
