@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Manajemen Karyawan</h5>
            <button class="btn btn-primary btn-tambah-karyawan" type="button" data-bs-toggle="modal" data-bs-target="#Tambahkaryawan">Tambah Karyawan</button>
        </div>
        <div class="table-responsive flex-grow-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Kontak</th>
                        <th>Username</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Afriza</td>
                        <td>081212795478</td>
                        <td>afriza123</td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-warning btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Editkaryawan">Edit</button>
                            <button class="btn btn-danger btn-sm mx-2" type="button" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">Hapus</button>
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
    @include('component.TambahKaryawan')
      {{-- edit --}}
      @include('component.EditKaryawan')
      {{-- hapus --}}
      @include('component.HapusKaryawan')
@endsection
