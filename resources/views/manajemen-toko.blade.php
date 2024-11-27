@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between mb-2 align-items-center">
            <h5 class="text-judul">Manajemen Toko</h5>
        <button class="btn btn-primary btn-tambah-toko" type="button" data-bs-toggle="modal" data-bs-target="#Tambahtoko">Tambah Toko</button>
        </div>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tokoList as $toko)
                        <tr>
                            <td>{{ $toko->name }}</td>
                            <td>{{ $ownerNames[array_rand($ownerNames)] }}</td>
                            <td>{{ $toko->address }}</td>
                            <td>{{ $toko->phone_number }}</td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                                <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button class="btn btn-secondary">Previous</button>
            <span>Page 1 of 10</span>
            <button class="btn btn-secondary">Next</button>
        </div>
    </section>

    {{-- tambah --}}
    @include('component.TambahManajemenToko')
    {{-- edit --}}
    @include('component.EditManajemenToko')
    {{-- hapus --}}
    @include('component.HapusManajemenToko')

@endsection
