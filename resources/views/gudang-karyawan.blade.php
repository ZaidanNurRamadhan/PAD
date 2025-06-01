@extends('layout.karyawan')
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Produk</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahproduk">
                Tambah Produk
              </button>
        </div>
        <div class="table table-responsive flex-grow-1 table-data">
            <table class="table">
                <thead style="z-index: 1500">
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Batas Kritis</th>
                    </tr>
                </thead>
                <tbody id="produk-table-body">
                    <tr><td colspan="6" class="text-center">Loading data...</td></tr>
                </tbody>
            </table>
        </div>
        <nav id="pagination-nav" aria-label="Page navigation" class="mt-3">
            <!-- Pagination buttons will be inserted here -->
        </nav>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
function fetchProdukData() {
        const kategoriCountEl = document.getElementById('kategori-count');
        const totalProdukCountEl = document.getElementById('total-produk-count');
        const produkMenipisCountEl = document.getElementById('produk-menipis-count');
        const produkTableBody = document.getElementById('produk-table-body');
        const paginationNav = document.getElementById('pagination-nav');
        const token = localStorage.getItem('authToken'); // Adjust this as needed to get the actual token
        fetch('http://127.0.0.1:8000/api/gudang-karyawan', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept' : 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const produks = data.produks;

                // Calculate counts
                const kategoriCount = new Set(produks.map(p => p.name)).size;
                const totalProdukCount = produks.length;
                const produkMenipisCount = produks.filter(p => p.batasKritis > p.jumlah).length;

                // Update counts in UI
                kategoriCountEl.textContent = kategoriCount;
                totalProdukCountEl.textContent = totalProdukCount;
                produkMenipisCountEl.textContent = produkMenipisCount;

                // Clear table body
                produkTableBody.innerHTML = '';

                if (produks.length === 0) {
                    produkTableBody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                    return;
                }

                // Render produk rows
                produks.forEach((produk, index) => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${produk.name}</td>
                        <td>Rp${Number(produk.hargaBeli).toLocaleString('id-ID')}</td>
                        <td>Rp${Number(produk.hargaJual).toLocaleString('id-ID')}</td>
                        <td>${produk.jumlah}</td>
                        <td>${produk.batasKritis} Packets</td>
                    `;

                    produkTableBody.appendChild(tr);
                });
                // TODO: Implement pagination if API supports it
            })
            .catch(error => {
                produkTableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>';
                console.error('Error fetching produk data:', error);
            });
    }

    // Initial fetch
    fetchProdukData();
});
</script>
@endsection
