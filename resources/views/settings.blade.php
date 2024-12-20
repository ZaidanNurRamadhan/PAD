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
                    @if($data && count($data) > 0)
                        @foreach ($data as $employee)
                            <tr>
                                <td>{{ $employee['name'] }}</td>
                                <td>{{ $employee['contact'] }}</td>
                                <td>{{ $employee['email'] }}</td>
                                <td class="d-flex justify-content-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm mx-2"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#Editkaryawan"
                                        data-id="{{ $employee['id'] }}"
                                        data-name="{{ $employee['name'] }}"
                                        data-contact="{{ $employee['contact'] }}"
                                        data-username="{{ $employee['email'] }}">
                                        Edit
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger btn-sm mx-2 deleteKaryawan" type="button" data-id="{{ $employee['id'] }}" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                    @endif

                    {{-- Menambahkan baris kosong jika data kurang dari 20 --}}
                    @for ($i = count($data); $i < 19; $i++)
                        <tr><td colspan="4"></td></tr>
                    @endfor
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
