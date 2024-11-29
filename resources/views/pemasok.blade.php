@extends('layout.owner')
@section('content')
<section class="table-container d-flex flex-column min-vh-100">
    <div class="flex-grow-1 d-flex flex-column justify-content-between">
        <article class="d-flex justify-content-between align-items-center mb-3">
            <h3>Pemasok</h3>
            <button class="btn btn-primary btn-add" type="button" data-bs-toggle="modal" data-bs-target="#Tambahpemasok">Tambah Pemasok</button>
        </article>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasok as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->produkDisediakan }}</td>
                        <td>{{ $data->nomorTelepon }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Editpemasok">Edit</button>
                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                    @endforelse

                    {{-- Menambahkan baris kosong dengan border jika data kurang dari 20 --}}
                    @for ($i = count($pemasok); $i < 19; $i++)
                    <tr><td colspan="5"></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="pagination mt-auto d-flex justify-content-between">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </div>
</section>

{{-- hapus --}}
@include('component.HapusPemasok')
{{-- tambah --}}
@include('component.TambahPemasok')
{{-- edit --}}
@include('component.EditPemasok')
@endsection
