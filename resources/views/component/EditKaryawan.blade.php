<section class="modal fade" id="Editkaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Karyawan</h1>
            </header>
            <form id="edit-form" method="post">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="karyawan-name">Nama Karyawan</label>
                        <input id="karyawan-name" type="text" name="name" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="karyawan-contact">Kontak</label>
                        <input id="karyawan-contact" type="number" name="contact" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="karyawan-email">Email</label>
                        <input id="karyawan-email" type="text" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4 position-relative w-auto">
                        <label for="karyawan-password">Password</label>
                        <input id="karyawan-password" type="password" name="password" class="form-control" style="max-width: 273px;" placeholder="Masukkan password">
                        <i id="toggle-icon" class="fa fa-eye position-absolute" style="top: 10px; right: 25px;" onclick="togglePassword()"></i>
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </footer>
            </form>
        </main>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('Editkaryawan');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const contact = button.getAttribute('data-contact');
        const email = button.getAttribute('data-email');

        document.getElementById('karyawan-name').value = name;
        document.getElementById('karyawan-contact').value = contact;
        document.getElementById('karyawan-email').value = email;

        const form = document.getElementById('edit-form');
        form.action = `http://127.0.0.1:8000/api/karyawan/${id}`; // Correctly update the action for the form
    });
});


    function togglePassword() {
        var passwordField = document.getElementById("karyawan-password");
        var icon = document.getElementById("toggle-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
        document.getElementById('edit-form').addEventListener('submit', function(event) {
        event.preventDefault();

        var token = localStorage.getItem('authToken');
        if (!token) {
            alert('Authentication token not found. Please login again.');
            return;
        }

        var form = this;
        var id = form.action.split('/').pop();

        var formData = {
            name: document.getElementById('karyawan-name').value.trim(),
            contact: document.getElementById('karyawan-contact').value.trim(),
            email: document.getElementById('karyawan-email').value.trim(),
            password: document.getElementById('karyawan-password').value.trim()
        };

        fetch(form.action, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.message || 'Gagal memperbarui karyawan'); });
            }
            return response.json();
        })
        .then(data => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('Editkaryawan'));
            modal.hide();
            location.reload();
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });

    function togglePassword() {
        var passwordField = document.getElementById("karyawan-password");
        var icon = document.getElementById("toggle-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
