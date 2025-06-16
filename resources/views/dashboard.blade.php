@extends('layout.owner')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    table th{
        z-index: 0;
    }
</style>
<section class="container-fluid d-flex row h-100">
    <article class="card mt-2 monitoring">
        <div class="card-header d-flex justify-content-between bg-white position-sticky">
            <h5 class="text-judul align-self-center mb-0 py-2">Monitoring Penyebaran Produk</h5>
            <a class="text-decoration-none text-judul text-end align-self-center" href="{{route('monitoring.index')}}" style="line-height: 1.2">Lihat Semua</a>
        </div>
        <div class="card-body scrollable-table table-responsive" style="padding-top: 0">
            <table class="table" id="monitoring-table">
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
                <tbody>
                    <tr><td colspan="6" class="text-center">Loading data...</td></tr>
                </tbody>
            </table>
        </div>
    </article>

    <section class="row mt-4 equal-height flex-grow-1">
        <section class="col-12 col-xxl-8 table-terhubung">
            <article class="card chartnya flex-grow-1">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="align-self-center text-judul mb-0">Penjualan &amp; Retur</h5>
                    <div class="dropdown">
                        <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                            <span class="selected-text" id="sales-filter-text">Harian</span>
                            <span class="arrow">▼</span>
                        </div>
                        <div class="dropdown-options">
                            <div class="dropdown-option" onclick="applySalesFilter('harian')">Harian</div>
                            <div class="dropdown-option" onclick="applySalesFilter('bulanan')">Bulanan</div>
                        </div>
                    </div>
                </div>
                <div class="card-body chart">
                    <canvas id="myChart" height="100%" width="100%"></canvas>
                </div>
            </article>

            <article class="card mt-4 isi-table flex-grow-1">
                <div class="card-header d-flex justify-content-between bg-white position-sticky terlaris">
                    <h5 class="align-self-center text-judul mb-0">Terlaris</h5>
                    <div class="dropdown">
                        <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                            <span class="selected-text" id="bestseller-filter-text">Harian</span>
                            <span class="arrow">▼</span>
                        </div>
                        <div class="dropdown-options">
                            <div class="dropdown-option" onclick="applyBestSellerFilter('harian')">Harian</div>
                            <div class="dropdown-option" onclick="applyBestSellerFilter('bulanan')">Bulanan</div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-terlaris px-3 p-0 table-responsive">
                    <table class="table" id="best-sellers-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Produk Keluar</th>
                                <th>Produk Tersisa</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4" class="text-center">Loading data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
        <section class="col-xxl-4 col-12 flex-grow-1">
            <article class="card flex-grow-1 table-menipis">
                <div class="card-header d-flex justify-content-between align-items-center bg-white position-sticky">
                    <h5 class="text-judul">Produk Menipis</h5>
                    <a class="text-decoration-none text-judul" href="{{route('gudang-owner')}}">Lihat Semua</a>
                </div>
                <div class="card-body scrollable-list">
                    <ul class="list-group" id="produk-menipis-list">
                        <li class="list-group-item d-flex justify-content-between flex-column">
                            <span>Loading data...</span>
                        </li>
                    </ul>
                </div>
            </article>
        </section>
    </section>
</section>

<script>
    let currentSalesFilter = 'harian';
    let currentBestSellerFilter = 'harian';

    function toggleDropdown(element) {
        element.nextElementSibling.classList.toggle('show');
    }

    function applySalesFilter(filter) {
        document.getElementById('sales-filter-text').textContent = capitalize(filter);
        currentSalesFilter = filter;
        fetchSalesChartData(filter);
    }

    function applyBestSellerFilter(filter) {
        document.getElementById('bestseller-filter-text').textContent = capitalize(filter);
        currentBestSellerFilter = filter;
        fetchBestSellersTable(filter);
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    async function fetchDashboardData() {
        const token = localStorage.getItem('authToken');
        const response = await fetch('/api/dashboard', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        });
        const data = await response.json();

        // Update Monitoring Table
        const monitoringBody = document.querySelector('#monitoring-table tbody');
        if (data.monitoring_data && Array.isArray(data.monitoring_data)) {
            monitoringBody.innerHTML = data.monitoring_data.map(item => `
                    <tr>
                        <td>${item.nama_toko}</td>
                        <td>${item.waktu_edar}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.kategori}</td>
                        <td>${item.hari}</td>
                        <td>${
                            (() => {
                                const date = new Date(item.tanggal_keluar);
                                if (isNaN(date)) return item.tanggal_keluar;
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const year = String(date.getFullYear()).slice(-2);
                                return `${day}-${month}-${year}`;
                            })()
                        }</td>
                    </tr>
            `).join('');
        } else {
            monitoringBody.innerHTML = '<tr><td colspan="6" class="text-center">No monitoring data available</td></tr>';
        }

        // Update Produk Menipis
        const produkList = document.getElementById('produk-menipis-list');
        if (data.produk_menipis && Array.isArray(data.produk_menipis)) {
            produkList.innerHTML = data.produk_menipis.map(p => `
                <li class="list-group-item d-flex justify-content-between flex-column">
                    <span>${p.name}</span>
                    <span>${p.jumlah} pcs <span class="badge badge-danger">Rendah</span></span>
                </li>
            `).join('');
        } else {
            produkList.innerHTML = '<li class="list-group-item">No produk menipis data available</li>';
        }
    }

    async function fetchSalesChartData(filter) {
        const token = localStorage.getItem('authToken');
        const response = await fetch('/api/dashboard?filter=' + filter, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        });
        const data = await response.json();

        const salesData = data.sales_data ? data.sales_data : { labels: [], sales: [], returns: [] };

        const ctx = document.getElementById('myChart');
        if (!ctx) return;
        const context = ctx.getContext('2d');

        // Buat gradient untuk Penjualan
        const gradientPenjualan = context.createLinearGradient(0, 0, 0, ctx.height);
        gradientPenjualan.addColorStop(0, '#79D0F1');
        gradientPenjualan.addColorStop(0.5, '#74B0FA');
        gradientPenjualan.addColorStop(1, '#817AF3');

        // Buat gradient untuk Retur
        const gradientRetur = context.createLinearGradient(0, 0, 0, ctx.height);
        gradientRetur.addColorStop(0, '#57DA65');
        gradientRetur.addColorStop(0.5, '#51CC5D');
        gradientRetur.addColorStop(1, '#46A46C');

        if (window.myChart && typeof window.myChart.destroy === 'function') {
            window.myChart.destroy();
        }

        window.myChart = new Chart(context, {
            type: 'bar',
            data: {
                labels: salesData.labels,
                datasets: [
                    {
                        label: 'Penjualan',
                        data: salesData.sales,
                        backgroundColor: gradientPenjualan
                    },
                    {
                        label: 'Retur',
                        data: salesData.returns,
                        backgroundColor: gradientRetur
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }


    async function fetchBestSellersTable(filter) {
        // Use the main dashboard API to get bestsellers data to avoid 404
        const token = localStorage.getItem('authToken');
        const response = await fetch('/api/dashboard?filter=' + filter, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        });
        const data = await response.json();

        // Defensive check for bestsellers data
        const bestsellers = data.produk_terlaris ? data.produk_terlaris : [];

        const tbody = document.querySelector('#best-sellers-table tbody');
        if (!tbody) return; // Defensive check for tbody element
        if (Array.isArray(bestsellers) && bestsellers.length > 0) {
            tbody.innerHTML = bestsellers.map(p => `
                <tr>
                    <td>${p.produk ? p.produk.name : 'N/A'}</td>
                    <td>${p.total_terjual}</td>
                    <td>${p.produk.jumlah}</td>
                    <td>${p.produk.hargaJual}</td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No bestsellers data available</td></tr>';
        }
    }

    fetchDashboardData();
    fetchSalesChartData(currentSalesFilter);
    fetchBestSellersTable(currentBestSellerFilter);
</script>
@endsection
