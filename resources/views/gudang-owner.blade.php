@extends('layout.owner')
@section('content')
<div class="container-fluid">
    <section class="card p-4">
        <h3 class="text-center">Stok Keseluruhan</h3>
        <div class="row mt-4">
            <div class="col text-center">
                <h5 style="color: #1570EF" class="fw-semibold">Kategori</h5>
                <p class="fw-semibold">{{ $produks->groupBy('category')->count() }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #E19133" class="fw-semibold">Total Produk</h5>
                <p class="fw-semibold">{{ $produks->count() }}</p>
            </div>
            <div class="col text-center">
                <h5 style="color: #F36960" class="fw-semibold">Produk Menipis</h5>
                <p class="fw-semibold">{{ $produks->where('batas_kritis', '>', 0)->count() }}</p>
            </div>
        </div>
    </section>
    <section class="card mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Produk</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahproduk">
                Tambah Produk
              </button>
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
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="h-100">
                    @foreach($data as $produk)
                        <tr>
                            <td>{{ $produk['id'] }}</td>
                            <td>{{ $produk['name'] }}</td>
                            <td>Rp{{ number_format($produk['harga_beli'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($produk['harga_jual'], 0, ',', '.') }}</td>
                            <td>{{ $produk['stok'] }}</td>
                            <td>{{ $produk['batas_kritis'] }} Packets</td>
                            <td class="justify-content-center d-flex">
                                <button class="m-2 btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Edit">Edit</button>
                                <button class="m-2 btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
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
{{-- tambah --}}
    @include('component.TambahGudang')
    {{-- edit --}}
    @include('component.EditGudang')
      {{-- hapus --}}
    @include('component.HapusGudang')
@endsection
