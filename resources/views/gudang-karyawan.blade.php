@extends('layout.karyawan')
@section('content')
<div class="container-fluid">
    <section class="card p-4">
        <h3 class="text-center">Stok Keseluruhan</h3>
        <div class="row mt-4">
            <div class="col text-center">
                <h5 style="color: #1570EF" class="fw-semibold">Kategori</h5>
                <p class="fw-semibold">{{ $produks->groupBy('name')->count() }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #E19133" class="fw-semibold">Total Produk</h5>
                <p class="fw-semibold">{{ $produks->where('jumlah')->count() }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #F36960" class="fw-semibold">Produk Menipis</h5>
                <p class="fw-semibold">{{ $produks->filter(function ($produk) {
        return $produk->batasKritis > $produk->jumlah;
    })->count() }}</p>
            </div>
        </div>
    </section>
<<<<<<< HEAD
    <section class="table-container mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
=======
    <section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
>>>>>>> 02498b75d1746540a66a8a5579d7bb8492a6eeda
        <div class="mb-3">
            <h5>Produk</h5>
        </div>
        <div class="table table-responsive flex-grow-1 table-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Batas Kritis</th>
                    </tr>
                </thead>
                <tbody class="h-100">
<<<<<<< HEAD
                    @forelse($produks as $index => $produk)
=======
                    @forelse($produks as $produk)
>>>>>>> 02498b75d1746540a66a8a5579d7bb8492a6eeda
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $produk['name'] }}</td>
                            <td>Rp{{ number_format($produk['hargaBeli'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($produk['hargaJual'], 0, ',', '.') }}</td>
                            <td>{{ $produk['jumlah'] }}</td>
                            <td>{{ $produk['batasKritis'] }} Packets</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
<<<<<<< HEAD
                    @for ($i = count($produks); $i < 9; $i++)
=======
                    @for ($i = count($produks); $i < 19; $i++)
>>>>>>> 02498b75d1746540a66a8a5579d7bb8492a6eeda
                        <tr><td colspan="6"></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>
        {!! $produks->links('pagination::bootstrap-5') !!} <!-- This will generate the pagination links -->
    </section>
</div>
@endsection
