@extends('layout.owner')
@section('content')
<div class="container-fluid">
    <section class="card p-4">
        <h3 class="text-center">Stok Keseluruhan</h3>
        <div class="row mt-4">
            <div class="col text-center">
                <h5 style="color: #1570EF" class="fw-semibold">Kategori</h5>
                <p class="fw-semibold" id="kategori-count">0</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #E19133" class="fw-semibold">Total Produk</h5>
                <p class="fw-semibold" id="total-produk-count">0</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #F36960" class="fw-semibold">Produk Menipis</h5>
                <p class="fw-semibold" id="produk-menipis-count">0</p>
            </div>
        </div>
    </section>
    <section class="mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column table-container">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-judul">Produk</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahproduk">
                Tambah Produk
            </button>
        </div>
        <div class="table-responsive flex-grow-1 table-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Batas Kritis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-table-body">
                    <tr><td colspan="7" class="text-center">Loading data...</td></tr>
                </tbody>
            </table>
        </div>
        <nav id="pagination-nav" class="mt-3 d-flex justify-content-between" aria-label="Page navigation"></nav>
    </section>
</div>

{{-- tambah --}}
@include('component.TambahGudang')
{{-- edit --}}
@include('component.EditGudang')
{{-- hapus --}}
@include('component.HapusGudang')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategoriCountEl = document.getElementById('kategori-count');
    const totalProdukCountEl = document.getElementById('total-produk-count');
    const produkMenipisCountEl = document.getElementById('produk-menipis-count');
    const produkTableBody = document.getElementById('produk-table-body');
    const paginationNav = document.getElementById('pagination-nav');
    const itemsPerPage = 10;
    let produks = [];
    let currentPage = 1;

    function fetchProdukData() {
        const token = localStorage.getItem('authToken');
        fetch('/api/gudang', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept' : 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            produks = data.produks;

            const kategoriCount = new Set(produks.map(p => p.name)).size;
            const totalProdukCount = produks.length;
            const produkMenipisCount = produks.filter(p => p.batasKritis > p.jumlah).length;

            kategoriCountEl.textContent = kategoriCount;
            totalProdukCountEl.textContent = totalProdukCount;
            produkMenipisCountEl.textContent = produkMenipisCount;

            renderTable();
            renderPagination();
        })
        .catch(error => {
            produkTableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>';
            console.error('Error fetching produk data:', error);
        });
    }

    function renderTable() {
        produkTableBody.innerHTML = '';

        if (produks.length === 0) {
            produkTableBody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = produks.slice(startIndex, endIndex);

        pageData.forEach((produk, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${startIndex + index + 1}</td>
                <td>${produk.name}</td>
                <td>Rp${Number(produk.hargaBeli).toLocaleString('id-ID')}</td>
                <td>Rp${Number(produk.hargaJual).toLocaleString('id-ID')}</td>
                <td>${produk.jumlah}</td>
                <td>${produk.batasKritis} Packets</td>
                <td class="justify-content-center d-flex">
                    <button class="m-2 btn btn-warning btn-sm edit-btn">Edit</button>
                    <button class="m-2 btn btn-danger btn-sm deleteProduk" data-id="${produk.id}" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                </td>
            `;
            produkTableBody.appendChild(tr);

            tr.querySelector('.edit-btn').addEventListener('click', () => {
                openEditModal(produk);
            });
        });

        document.querySelectorAll('.deleteProduk').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const form = document.getElementById('deleteProdukForm');
                form.setAttribute('action', `http://127.0.0.1:8000/api/gudang/${id}`);
            });
        });
    }

    function renderPagination() {
        paginationNav.innerHTML = '';
        const totalPages = Math.ceil(produks.length / itemsPerPage);

        if (totalPages <= 1) return;

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

        const pageButtonsContainer = document.createElement('div');
        pageButtonsContainer.className = 'd-inline-flex';

        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.textContent = i;
            pageBtn.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
            pageBtn.addEventListener('click', () => {
                currentPage = i;
                renderTable();
                renderPagination();
            });
            pageButtonsContainer.appendChild(pageBtn);
        }
        paginationNav.appendChild(pageButtonsContainer);

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

    fetchProdukData();
});
</script>
@endsection
