@extends('layout.owner')

@section('content')
<section class="table-container d-flex flex-column min-vh-100">
    <div class="d-flex justify-content-between mb-2 align-items-center">
        <h5 class="text-judul">Manajemen Toko</h5>
        <button class="btn btn-primary btn-tambah-toko" type="button" data-bs-toggle="modal" data-bs-target="#Tambahtoko">
            Tambah Toko
        </button>
    </div>

    <div class="table-responsive flex-grow-1 table-data">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Toko</th>
                    <th>Nama Pemilik</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tokoTableBody">
                <!-- Data toko akan di-render di sini -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav id="pagination-nav" class="mt-3 d-flex justify-content-between" aria-label="Page navigation"></nav>
</section>

<script>
    let tokoList = [];
    let currentPage = 1;
    const itemsPerPage = 10;

    document.addEventListener('DOMContentLoaded', function () {
        fetchTokoData();
    });

    function fetchTokoData() {
        const token = localStorage.getItem('authToken');
        fetch('/api/toko', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                tokoList = data.data;
                renderTable();
                renderPagination();
            })
            .catch(error => {
                console.error('Error fetching toko list:', error);
            });
    }

    function renderTable() {
        const tbody = document.getElementById('tokoTableBody');
        tbody.innerHTML = '';

        if (tokoList.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>';
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = tokoList.slice(start, end);

        pageData.forEach(toko => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${toko.name}</td>
                <td>${toko.namaPemilik}</td>
                <td>${toko.address || ''}</td>
                <td>${toko.phone_number || ''}</td>
                <td class="d-flex justify-content-center">
                    <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal"
                        data-bs-target="#Edittoko"
                        data-id="${toko.id}"
                        data-name="${toko.name}"
                        data-pemilik="${toko.namaPemilik}"
                        data-alamat="${toko.address || ''}"
                        data-kontak="${toko.phone_number || ''}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm mx-2 deleteToko" type="button" data-bs-toggle="modal"
                        data-id="${toko.id}"
                        data-bs-target="#Hapustoko">
                        Hapus
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderPagination() {
        const totalPages = Math.ceil(tokoList.length / itemsPerPage);
        const paginationNav = document.getElementById('pagination-nav');
        paginationNav.innerHTML = '';

        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Previous';
        prevBtn.className = 'btn btn-outline-primary me-2';
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            currentPage--;
            renderTable();
            renderPagination();
        };
        paginationNav.appendChild(prevBtn);

        const pageButtons = document.createElement('div');
        pageButtons.className = 'd-inline-flex';
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.textContent = i;
            pageBtn.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
            pageBtn.onclick = () => {
                currentPage = i;
                renderTable();
                renderPagination();
            };
            pageButtons.appendChild(pageBtn);
        }
        paginationNav.appendChild(pageButtons);

        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.className = 'btn btn-outline-primary';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            currentPage++;
            renderTable();
            renderPagination();
        };
        paginationNav.appendChild(nextBtn);
    }
</script>

{{-- tambah --}}
@include('component.TambahManajemenToko')

{{-- edit --}}
@include('component.EditManajemenToko')

{{-- hapus --}}
@include('component.HapusManajemenToko')
@endsection
