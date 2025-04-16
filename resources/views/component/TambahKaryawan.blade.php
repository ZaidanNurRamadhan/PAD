<section class="modal fade" id="Tambahkaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
            </header>
            <form id="formTambahKaryawan" action="{{ route('karyawan.store') }}" method="POST">
                @csrf
                <article class="modal-body">
                    <section class="form-group px-3">
                        <div class="d-flex justify-content-between">
                            <label for="name">Nama Karyawan</label>
                            <div class="d-flex flex-column">
                                <input type="text" name="name" class="form-control" style="width:100%" placeholder="Masukkan nama karyawan">
                                <small style="font-size: 0.8rem" class="text-danger error-name"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="contact">Kontak</label>
                            <div class="d-flex flex-column">
                                <input type="text" name="contact" class="form-control" style="width:100%" placeholder="Masukkan kontak karyawan">
                                <small style="font-size: 0.8rem" class="text-danger error-contact"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="email">Email</label>
                            <div class="d-flex flex-column">
                                <input type="email" name="email" class="form-control" style="width:100%" placeholder="Masukkan email">
                                <small style="font-size: 0.8rem" class="text-danger error-email"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="password">Password</label>
                            <div class="d-flex flex-column position-relative">
                                <input type="password" id="password" name="password" class="form-control" style="width:100%" placeholder="Masukkan password">
                                <i id="toggle-icon" class="fa fa-eye position-absolute" style="top: 10px; right: 10px;" onclick="togglePassword()"></i>
                                <small style="font-size: 0.8rem" class="text-danger error-password"></small>
                            </div>
                        </div>
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </footer>
            </form>
            <div id="success-message" class="d-none alert alert-success" role="alert">Karyawan berhasil ditambahkan!</div>
        </main>
    </div>
</section>
<script>
    document.getElementById('formTambahKaryawan').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form langsung disubmit

        // Ambil elemen form
        var name = document.querySelector('[name="name"]');
        var contact = document.querySelector('[name="contact"]');
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');

        var valid = true;

        // Clear error messages
        document.querySelectorAll('.text-danger').forEach(function(errorElement) {
            errorElement.innerText = '';
        });

        // Validasi Nama Karyawan
        if (name.value.trim() === '') {
            document.querySelector('.error-name').innerText = 'Nama karyawan tidak boleh kosong.';
            valid = false;
        }

        // Validasi Kontak
        if (contact.value.trim() === '') {
            document.querySelector('.error-contact').innerText = 'Kontak tidak boleh kosong.';
            valid = false;
        } else if (isNaN(contact.value.trim())) {
            document.querySelector('.error-contact').innerText = 'Kontak harus berupa angka.';
            valid = false;
        }

        // Validasi Email
        if (email.value.trim() === '') {
            document.querySelector('.error-email').innerText = 'Email tidak boleh kosong.';
            valid = false;
        } else if (!validateEmail(email.value.trim())) {
            document.querySelector('.error-email').innerText = 'Format email tidak valid.';
            valid = false;
        }

        // Validasi Password
        if (password.value.trim() === '') {
            document.querySelector('.error-password').innerText = 'Password tidak boleh kosong.';
            valid = false;
        } else if (password.value.trim().length < 8) {
            document.querySelector('.error-password').innerText = 'Password harus memiliki minimal 8 karakter.';
            valid = false;
        }

        // Jika validasi sukses, submit form
        if (valid) {
            var form = document.getElementById('formTambahKaryawan');
            form.submit();

            // Menampilkan pesan sukses setelah form disubmit
            document.getElementById('success-message').classList.remove('d-none');
        }
    });

    // Fungsi untuk validasi email
    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

        function togglePassword() {
        var passwordField = document.getElementById("password");
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

    // Example of using AJAX to submit the form for both Add and Edit actions
    $(document).ready(function() {
    // Saat form disubmit
    $('#formTambahKaryawan').submit(function(e) {
        e.preventDefault(); // Mencegah form disubmit secara biasa

        var formData = new FormData(this); // Ambil semua data form

        // Debugging: Menampilkan data form yang dikirim ke server
        for (var [key, value] of formData.entries()) {
            console.log(key + ': ' + value); // Menampilkan key dan value untuk setiap input
        }

        $.ajax({
            url: $(this).attr('action'), // Arahkan ke route yang benar
            method: 'POST',
            data: formData, // Data yang akan dikirim
            processData: false,
            contentType: false,
            success: function(response) {
                // Menangani jika berhasil
                alert('Karyawan berhasil ditambahkan!');
                $('#Tambahkaryawan').modal('hide'); // Tutup modal setelah berhasil
                location.reload(); // Reload halaman untuk menampilkan data terbaru
            },
            error: function(xhr) {
                // Debugging: Menampilkan error di konsol
                console.log(xhr.responseJSON);

                // Menangani jika terjadi error (misalnya validasi gagal)
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        alert(value); // Menampilkan pesan error
                    });
                }
            }
        });
    });
});
</script>
