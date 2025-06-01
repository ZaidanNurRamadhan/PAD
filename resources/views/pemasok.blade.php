@extends('layout.owner')
@section('content')
<section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-judul">Pemasok</h3>
            <button class="btn btn-primary btn-add" type="button" data-bs-toggle="modal" data-bs-target="#Tambahpemasok">Tambah Pemasok</button>
        </div>

        <div class="table table-responsive flex-grow-1 table-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pemasok-table-body">
                    {{-- Data will be populated by JavaScript --}}
                </tbody>
            </table>
        </div>
</section>

{{-- hapus --}}
@include('component.HapusPemasok')
{{-- tambah --}}
@include('component.TambahPemasok')
{{-- edit --}}
@include('component.EditPemasok')

<script>
document.addEventListener('DOMContentLoaded', function() {
    let pemasokIdToDelete = null;

    function fetchAndRenderPemasok() {
        const token = localStorage.getItem('authToken');

        fetch('http://127.0.0.1:8000/api/pemasok', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept' : 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch pemasok data');
            }
            return response.json();
        })
        .then(data => {
            const pemasokList = data.data;
            const tbody = document.getElementById('pemasok-table-body');
            tbody.innerHTML = '';

            if (pemasokList.length === 0) {
                const tr = document.createElement('tr');
                const td = document.createElement('td');
                td.colSpan = 6;
                td.className = 'text-center';
                td.textContent = 'Tidak ada data';
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            pemasokList.forEach((pemasok, index) => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${pemasok.name}</td>
                    <td>${pemasok.produkDisediakan}</td>
                    <td>${pemasok.nomorTelepon}</td>
                    <td>${pemasok.email}</td>
                    <td class="justify-content-center d-flex">
                        <button class="m-2 btn btn-warning btn-sm" onclick="editPemasok(${pemasok.id})">Edit</button>
                        <button class="m-2 btn btn-danger btn-sm deletePemasok" data-id="${pemasok.id}" data-bs-toggle="modal" data-bs-target="#Hapuspemasok">Hapus</button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            const deleteButtons = document.querySelectorAll('.deletePemasok');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    pemasokIdToDelete = this.dataset.id;
                });
            });
        })
        .catch(error => {
            console.error('Error fetching pemasok data:', error);
        });
    }

    // Handle delete form submission
    const deleteForm = document.getElementById('deletePemasokForm');
    deleteForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const token = localStorage.getItem('authToken');
        if (!pemasokIdToDelete) {
            console.error('No pemasok ID selected for deletion');
            return;
        }

        fetch(`http://127.0.0.1:8000/api/pemasok/${pemasokIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete pemasok');
            }
            return response.json();
        })
        .then(data => {
            // Close the modal
            const hapusModal = bootstrap.Modal.getInstance(document.getElementById('Hapuspemasok'));
            hapusModal.hide();

            // Refresh the pemasok list
            fetchAndRenderPemasok();
        })
        .catch(error => {
            console.error('Error deleting pemasok:', error);
        });
    });

    fetchAndRenderPemasok();
});
</script>
@endsection
