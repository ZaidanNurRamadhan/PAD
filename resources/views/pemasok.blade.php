@extends('layout.owner')
@section('content')
<section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-judul">Pemasok</h3>
            <button class="btn btn-primary btn-add" type="button" data-bs-toggle="modal" data-bs-target="#Tambahpemasok">Tambah Pemasok</button>
        </div>

        <div class="table table-responsive flex-grow-1 table-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pemasok-table-body">
                    {{-- Data will be populated by JavaScript --}}
                </tbody>
            </table>
        </div>
</section>

{{-- hapus --}}
@include('component.HapusPemasok')
{{-- tambah --}}
@include('component.TambahPemasok')
{{-- edit --}}
@include('component.EditPemasok')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('pemasok-table-body');
    let pemasokIdToDelete = null;
    let pemasokList = [];
    let currentPage = 1;
    const itemsPerPage = 10;

    function fetchAndRenderPemasok() {
        const token = localStorage.getItem('authToken');

        if (!token) {
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Authentication token not found. Please login again.</td></tr>';
            return;
        }

        fetch('http://127.0.0.1:8000/api/pemasok', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept' : 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch pemasok data');
            }
            return response.json();
        })
        .then(data => {
            pemasokList = data.data;
            renderPemasokTable();
            renderPagination();
        })
        .catch(error => {
            console.error('Error fetching pemasok data:', error);
        });
    }

    function renderPemasokTable() {
        const tbody = document.getElementById('pemasok-table-body');
        tbody.innerHTML = '';

        if (pemasokList.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 6;
            td.className = 'text-center';
            td.textContent = 'Tidak ada data';
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = pemasokList.slice(startIndex, endIndex);

        pageData.forEach((pemasok, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${startIndex + index + 1}</td>
                <td>${pemasok.name}</td>
                <td>${pemasok.produkDisediakan}</td>
                <td>${pemasok.nomorTelepon}</td>
                <td>${pemasok.email}</td>
                <td class="justify-content-center d-flex">
                    <button class="m-2 btn btn-warning btn-sm" onclick="editPemasok(${pemasok.id})">Edit</button>
                    <button class="m-2 btn btn-danger btn-sm deletePemasok" data-id="${pemasok.id}" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.querySelectorAll('.deletePemasok').forEach(button => {
            button.addEventListener('click', function() {
                pemasokIdToDelete = this.dataset.id;
            });
        });
    }

    function renderPagination() {
        let paginationNav = document.getElementById('pagination-nav');
        if (!paginationNav) {
            paginationNav = document.createElement('nav');
            paginationNav.id = 'pagination-nav';
            paginationNav.className = 'mt-3 d-flex justify-content-between';
            const container = document.querySelector('.table-container');
            container.appendChild(paginationNav);
        }

        paginationNav.innerHTML = '';

        const totalPages = Math.ceil(pemasokList.length / itemsPerPage);
        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Previous';
        prevBtn.className = 'btn btn-outline-primary me-2';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => {
            currentPage--;
            renderPemasokTable();
            renderPagination();
        });
        paginationNav.appendChild(prevBtn);

        const pageContainer = document.createElement('div');
        pageContainer.className = 'd-inline-flex';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
            btn.addEventListener('click', () => {
                currentPage = i;
                renderPemasokTable();
                renderPagination();
            });
            pageContainer.appendChild(btn);
        }
        paginationNav.appendChild(pageContainer);

        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.className = 'btn btn-outline-primary';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', () => {
            currentPage++;
            renderPemasokTable();
            renderPagination();
        });
        paginationNav.appendChild(nextBtn);
    }

    const deleteForm = document.getElementById('deletePemasokForm');
    deleteForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const token = localStorage.getItem('authToken');
        if (!pemasokIdToDelete) return;

        fetch(`http://127.0.0.1:8000/api/pemasok/${pemasokIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(() => {
            const hapusModal = bootstrap.Modal.getInstance(document.getElementById('Hapuspemasok'));
            hapusModal.hide();
            fetchAndRenderPemasok();
        })
        .catch(error => console.error('Error deleting pemasok:', error));
    });

    fetchAndRenderPemasok();
});
</script>

@endsection
