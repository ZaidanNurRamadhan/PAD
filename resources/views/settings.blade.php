@extends('layout.owner')
@section('content')
    <section class="table-container d-flex flex-column min-vh-100">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Manajemen Karyawan</h5>
            <button class="btn btn-primary btn-tambah-karyawan" type="button" data-bs-toggle="modal" data-bs-target="#Tambahkaryawan">Tambah Karyawan</button>
        </div>
        <div class="table-responsive flex-grow-1 overflow-auto table-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="employee-table-body">
                    <tr><td colspan="4" class="text-center">Loading data...</td></tr>
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center" id="pagination-links">
                <!-- Pagination links will be rendered here -->
            </ul>
        </nav>

    </section>
    {{-- tambah --}}
    @include('component.TambahKaryawan')
    {{-- edit --}}
    @include('component.EditKaryawan')
    {{-- hapus --}}
    @include('component.HapusKaryawan')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            alert('Authentication token not found. Please login again.');
            return;
        }

        const employeeTableBody = document.getElementById('employee-table-body');
        const paginationLinks = document.getElementById('pagination-links');

        function fetchEmployees(page = 1) {
            fetch(`http://127.0.0.1:8000/api/karyawan?page=${page}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch employee data');
                }
                return response.json();
            })
            .then(data => {
                renderEmployees(data.data);
                renderPagination(data);
            })
            .catch(error => {
                employeeTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">${error.message}</td></tr>`;
            });
        }

        function renderEmployees(employees) {
            if (employees.length === 0) {
                employeeTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                return;
            }
            employeeTableBody.innerHTML = '';
            employees.forEach(employee => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${employee.name}</td>
                    <td>${employee.contact}</td>
                    <td>${employee.email}</td>
                    <td class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm mx-2"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#Editkaryawan"
                            data-id="${employee.id}"
                            data-name="${employee.name}"
                            data-contact="${employee.contact}"
                            data-email="${employee.email}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm mx-2 deleteKaryawan" type="button" data-id="${employee.id}" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">Hapus</button>
                    </td>
                `;
                employeeTableBody.appendChild(tr);
            });

            // Re-attach event listeners for delete buttons
            document.querySelectorAll('.deleteKaryawan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    document.querySelector('#deleteKaryawanForm').action = `/karyawan/destroy/${id}`;
                });
            });
        }

        function renderPagination(data) {
            paginationLinks.innerHTML = '';

            if (!data.last_page || data.last_page <= 1) {
                return; // No pagination needed
            }

            for (let page = 1; page <= data.last_page; page++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                if (page === data.current_page) {
                    li.classList.add('active');
                }
                const a = document.createElement('a');
                a.classList.add('page-link');
                a.href = '#';
                a.textContent = page;
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchEmployees(page);
                });
                li.appendChild(a);
                paginationLinks.appendChild(li);
            }
        }

        fetchEmployees();
    });
</script>
@endsection
