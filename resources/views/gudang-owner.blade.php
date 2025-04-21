@extends('layout.owner')
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
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="h-100">
                    @forelse($produks as $index => $produk)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td>{{ $produk['name'] }}</td>
                            <td>Rp{{ number_format($produk['hargaBeli'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($produk['hargaJual'], 0, ',', '.') }}</td>
                            <td>{{ $produk['jumlah'] }}</td>
                            <td>{{ $produk['batasKritis'] }} Packets</td>
                            <td class="justify-content-center d-flex">
                                <button class="m-2 btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#Editproduk" data-id="{{ $produk->id }}" data-name="{{ $produk->name }}" data-hbeli="{{ $produk->hargaBeli }}" data-hjual="{{ $produk->hargaJual }}" data-jstok="{{ $produk->jumlah }}" data-astok="{{ $produk->batasKritis }}">Edit</button>
                                <button class="m-2 btn btn-danger btn-sm deleteProduk" data-id="{{ $produk->id }}" data-bs-toggle="modal" data-bs-target="#Hapusproduk">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                    @for ($i = count($produks); $i < 19; $i++)
                        <tr><td colspan="7"></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>
        {!! $produks->links('pagination::bootstrap-5') !!} <!-- This will generate the pagination links -->
    </section>
</div>
{{-- tambah --}}
    @include('component.TambahGudang')
    {{-- edit --}}
    @include('component.EditGudang')
      {{-- hapus --}}
    @include('component.HapusGudang')
@endsection
