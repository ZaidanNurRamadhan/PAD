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
    <section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
        <div class="mb-3">
            <h5>Produk</h5>
        </div>
        <div class="table table-responsive flex-grow-1">
            <table class="table h-100">
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
                    @forelse($produks as $produk)
                        <tr>
                            <td>{{ $produk['id'] }}</td>
                            <td>{{ $produk['name'] }}</td>
                            <td>Rp{{ number_format($produk['hargaBeli'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($produk['hargaJual'], 0, ',', '.') }}</td>
                            <td>{{ $produk['jumlah'] }}</td>
                            <td>{{ $produk['batasKritis'] }} Packets</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                    @for ($i = count($produks); $i < 19; $i++)
                        <tr><td colspan="6"></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary">Prev</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>
</div>
@endsection
