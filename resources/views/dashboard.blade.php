@extends('layout.owner')
@section('content')
<section class="container-fluid d-flex row h-100">
    <article class="card mt-2">
        <div class="card-header d-flex justify-content-between bg-white position-sticky">
            <h5 class="text-judul align-self-center mb-0">Monitoring Penyebaran Produk</h5>
            <a class="text-decoration-none text-judul text-end align-self-center    " href="{{route('monitoring')}}" style="line-height: 1.2">Lihat Semua</a>
        </div>
        <div class="card-body scrollable-table table-responsive">
            <table class="table">
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
                    <tr>
                    <td>Budi Punya</td>
                    <td>30</td>
                    <td>12</td>
                    <td>Kripik</td>
                    <td>Minggu</td>
                    <td>06/10/2024</td>
                    </tr>
                    <tr>
                    <td>Jaya Kemenangan</td>
                    <td>21</td>
                    <td>15</td>
                    <td>Pangpang</td>
                    <td>Senin</td>
                    <td>08/12/2024</td>
                    </tr>
                    <tr>
                    <td>Sinar Mas</td>
                    <td>19</td>
                    <td>17</td>
                    <td>Makaron</td>
                    <td>Rabu</td>
                    <td>12/08/2024</td>
                    </tr>
                    <tr>
                    <td>Warmin Asep</td>
                    <td>19</td>
                    <td>17</td>
                    <td>Makaron</td>
                    <td>Jumat</td>
                    <td>20/10/2024</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>

    <section class="row mt-4">
        <div>
            <article class="card chartnya">
                <div class="card-header d-flex justify-content-between bg-white">
                    <div class="fs-4 align-self-end">Penjualan &amp; Retur</div>
                    <div class="dropdown">
                        <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                            <span class="selected-text">Harian</span>
                            <span class="arrow">▼</span>
                        </div>
                        <div class="dropdown-options" class="dropdown-options">
                            <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
                            <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
                        </div>
                    </div>
                </div>
                <div class="card-body scrollable-table table-responsive px-3 p-0">
                    <table class="table">
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
                            <tr>
                            <td>Budi Punya</td>
                            <td>30</td>
                            <td>12</td>
                            <td>Kripik</td>
                            <td>Minggu</td>
                            <td>06/10/2024</td>
                            </tr>
                            <tr>
                            <td>Jaya Kemenangan</td>
                            <td>21</td>
                            <td>15</td>
                            <td>Pangpang</td>
                            <td>Senin</td>
                            <td>08/12/2024</td>
                            </tr>
                            <tr>
                            <td>Sinar Mas</td>
                            <td>19</td>
                            <td>17</td>
                            <td>Makaron</td>
                            <td>Rabu</td>
                            <td>12/08/2024</td>
                            </tr>
                            <tr>
                            <td>Warmin Asep</td>
                            <td>19</td>
                            <td>17</td>
                            <td>Makaron</td>
                            <td>Jumat</td>
                            <td>20/10/2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
    <section class="row mt-4 equal-height flex-grow-1">
        <section class="col-12 col-xxl-8 table-terhubung">
            <article class="card chartnya flex-grow-1">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="align-self-center text-judul mb-0">Penjualan &amp; Retur</h5>
                    <div class="dropdown">
                        <div class="dropdown-selected bg-white" onclick="toggleDropdown(this)">
                            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
                            <span class="selected-text">Harian</span>
                            <span class="arrow">▼</span>
                        </div>
                        <div class="dropdown-options" class="dropdown-options">
                                <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>                                    <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
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
                            <span class="selected-text">Harian</span>
                            <span class="arrow">▼</span>
                        </div>
                            <div class="dropdown-options" class="dropdown-options">
                                <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
                                <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-terlaris px-3 p-0 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Nama Produk</th>
                                <th>Produk Keluar</th>
                                <th>Produk Tersisa</th>
                                <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>Surf Excel</td>
                                <td>30</td>
                                <td>12</td>
                                <td>Rp 300.000</td>
                                </tr>
                                <tr>
                                <td>Rin</td>
                                <td>21</td>
                                <td>15</td>
                                <td>Rp 207.000</td>
                                </tr>
                                <tr>
                                <td>Parle G</td>
                                <td>19</td>
                                <td>17</td>
                                <td>Rp 105.000</td>
                                </tr>
                                <tr>
                                    <td>Surf Excel</td>
                                    <td>30</td>
                                    <td>12</td>
                                    <td>Rp 300.000</td>
                                </tr>
                                <tr>
                                    <td>Rin</td>
                                    <td>21</td>
                                    <td>15</td>
                                    <td>Rp 207.000</td>
                                </tr>
                                <tr>
                                    <td>Parle G</td>
                                    <td>19</td>
                                    <td>17</td>
                                    <td>Rp 105.000</td>
                                </tr>
                                <tr>
                                    <td>Surf Excel</td>
                                    <td>30</td>
                                    <td>12</td>
                                    <td>Rp 300.000</td>
                                </tr>
                                <tr>
                                    <td>Rin</td>
                                    <td>21</td>
                                    <td>15</td>
                                    <td>Rp 207.000</td>
                                </tr>
                                <tr>
                                    <td>Parle G</td>
                                    <td>19</td>
                                    <td>17</td>
                                    <td>Rp 105.000</td>
                                </tr>
                                <tr>
                                    <td>Surf Excel</td>
                                    <td>30</td>
                                    <td>12</td>
                                    <td>Rp 300.000</td>
                                </tr>
                                <tr>
                                    <td>Rin</td>
                                    <td>21</td>
                                    <td>15</td>
                                    <td>Rp 207.000</td>
                                </tr>
                                <tr>
                                    <td>Parle G</td>
                                    <td>19</td>
                                    <td>17</td>
                                    <td>Rp 105.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
        </section>
        <section class="col-xxl-4 col-12 table-menipis flex-grow-1">
                <article class="card flex-grow-1">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white position-sticky">
                        <h5 class="text-judul">Produk Menipis</h5>
                        <a class="text-decoration-none text-judul" href="{{route('gudang-owner')}}">Lihat Semua</a>
                    </div>
                    <div class="card-body scrollable-list">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between flex-column">
                                <span class="">Lays</span>
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                                Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Lays
                                <span>Produk Tersisa: 15 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-column">
                            Garuda
                                <span>Produk Tersisa: 10 Packet <span class="badge badge-danger">Rendah</span></span>
                            </li>
                        </ul>
                    </div>
                </article>
            </div>

        </section>
    </section>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label: 'Penjualan',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Retur',
                    data: [2, 3, 1, 4, 5, 3, 2],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false, // Membiarkan tinggi mengikuti ukuran container
    scales: {
        y: {
            beginAtZero: true
        }
    }
}
    });
</script>
@endsection