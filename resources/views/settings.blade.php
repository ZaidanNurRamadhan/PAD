@extends('layout.owner')
@section('content')
<div class="container-fluid">
    <section class="card p-4 min-vh-100 d-flex flex-column">
        <div class="card-header d-flex justify-content-between align-items-center border-0 px-0">
            <h5 class="align-self-end text-judul">Manajemen Karyawan</h5>
            <button class="btn btn-primary btn-tambah-karyawan" type="button" data-bs-toggle="modal" data-bs-target="#Tambahkaryawan">Tambah Karyawan</button>
        </div>
        <div class="table-responsive flex-grow-1 table-data">
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

        <nav class="mt-3 d-flex justify-content-between" id="pagination-nav">
            <!-- Pagination controls will be rendered here -->
        </nav>
    </section>

    {{-- Modals --}}
    @include('component.TambahKaryawan')
    @include('component.EditKaryawan')
    @include('component.HapusKaryawan')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = localStorage.getItem('authToken');
        if (!token) {
            alert('Authentication token not found. Please login again.');
            return;
        }

        const employeeTableBody = document.getElementById('employee-table-body');
        const paginationNav = document.getElementById('pagination-nav');
        let currentPage = 1;
        let lastPage = 1;

        function fetchEmployees(page = 1) {
            fetch(`/api/karyawan?page=${page}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch employee data');
                return response.json();
            })
            .then(data => {
                currentPage = data.current_page;
                lastPage = data.last_page;
                renderEmployees(data.data);
                renderPagination();
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
                        <button class="btn btn-warning btn-sm mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#Editkaryawan"
                            data-id="${employee.id}" data-name="${employee.name}"
                            data-contact="${employee.contact}" data-email="${employee.email}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm mx-2 deleteKaryawan" type="button"
                            data-id="${employee.id}" data-bs-toggle="modal" data-bs-target="#Hapuskaryawan">
                            Hapus
                        </button>
                    </td>
                `;
                employeeTableBody.appendChild(tr);
            });

            document.querySelectorAll('.deleteKaryawan').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    document.querySelector('#deleteKaryawanForm').action = `/karyawan/destroy/${id}`;
                });
            });
        }

        function renderPagination() {
            paginationNav.innerHTML = '';

            if (lastPage <= 1) return;

            // Previous Button
            const prevBtn = document.createElement('button');
            prevBtn.textContent = 'Previous';
            prevBtn.className = 'btn btn-outline-primary me-2';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchEmployees(currentPage);
                }
            });
            paginationNav.appendChild(prevBtn);

            // Page Buttons
            const pageContainer = document.createElement('div');
            pageContainer.className = 'd-inline-flex';
            for (let i = 1; i <= lastPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                pageBtn.className = 'btn me-2 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
                pageBtn.addEventListener('click', () => {
                    currentPage = i;
                    fetchEmployees(currentPage);
                });
                pageContainer.appendChild(pageBtn);
            }
            paginationNav.appendChild(pageContainer);

            // Next Button
            const nextBtn = document.createElement('button');
            nextBtn.textContent = 'Next';
            nextBtn.className = 'btn btn-outline-primary';
            nextBtn.disabled = currentPage === lastPage;
            nextBtn.addEventListener('click', () => {
                if (currentPage < lastPage) {
                    currentPage++;
                    fetchEmployees(currentPage);
                }
            });
            paginationNav.appendChild(nextBtn);
        }

        fetchEmployees();
    });
</script>
@endsection
