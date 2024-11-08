@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column justify-content-between" style="height: 100vh;">
        <div class="card-header d-flex justify-content-between bg-white position-sticky terlaris">
            <div class="fs-4">Monitoring Data Produk</div>
            </div>
        </div>
        <div class="table-responsive scrollable-table w-100 mt-2">
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
                <tbody>
                    <!-- Jika tidak ada data, tampilkan pesan "Tidak ada data yang tersedia" -->
                    @if (false) <!-- Ganti false dengan kondisi cek data jika perlu -->
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data yang tersedia</td>
                        </tr>
                    @else
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
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination di pojok bawah -->
        <div class="pagination">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
@endsection
