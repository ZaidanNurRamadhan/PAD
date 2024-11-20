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
                    <tr>
                        <td>Zaidan Punya</td>
                        <td>Zaidan</td>
                        <td>Sindangruang</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sinar Mas</td>
                        <td>Farhan</td>
                        <td>Yogyakarta</td>
                        <td>9867545368</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jaya Abadi</td>
                        <td>Salman</td>
                        <td>Yogyakarta</td>
                        <td>7687764556</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Edittoko">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapustoko">Hapus</button>
                        </td>
                    </tr>
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
