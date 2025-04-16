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
</script>
