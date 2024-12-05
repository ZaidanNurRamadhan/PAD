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
                        <input id="karyawan-name" type="text" name="kname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="karyawan-contact">Kontak</label>
                        <input id="karyawan-contact" type="number" name="contact" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak karyawan">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="karyawan-username">Username</label>
                        <input id="karyawan-username" type="text" name="username" class="form-control" style="max-width: 273px;" placeholder="Masukkan username">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="karyawan-password">Password</label>
                        <input id="karyawan-password" type="text" name="password" class="form-control" style="max-width: 273px;" placeholder="Masukkan password">
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
            // Tombol yang diklik
            const button = event.relatedTarget;

            // Ambil data dari atribut tombol
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const contact = button.getAttribute('data-contact');
            const username = button.getAttribute('data-username');

            // Masukkan data ke dalam input modal
            document.getElementById('karyawan-name').value = name;
            document.getElementById('karyawan-contact').value = contact;
            document.getElementById('karyawan-username').value = username;

            // Update action form dengan ID
            const form = document.getElementById('edit-form');
            form.action = `/karyawan/${id}`;
        });
    });
</script>
