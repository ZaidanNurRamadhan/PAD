<section class="modal fade" id="Edittoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Toko</h1>
            </header>
            <form id="edit-form" method="post">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko-name">Nama Toko</label>
                        <input type="text" id="toko-name" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-pemilik">Nama Pemilik</label>
                        <input type="text" id="toko-pemilik" name="pemilikname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemilik toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-alamat">Alamat</label>
                        <input type="text" id="toko-alamat" name="alamat" class="form-control" style="max-width: 273px;" placeholder="Masukkan alamat toko">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-kontak">Kontak</label>
                        <input type="number" id="toko-kontak" name="kontak" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak toko">
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
        const editModal = document.getElementById('Edittoko');
        editModal.addEventListener('show.bs.modal', function (event) {
            // Tombol yang diklik
            const button = event.relatedTarget;

            // Ambil data dari atribut tombol
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const pemilik = button.getAttribute('data-pemilik');
            const alamat = button.getAttribute('data-alamat');
            const kontak = button.getAttribute('data-kontak');

            // Masukkan data ke dalam input modal
            document.getElementById('toko-name').value = name;
            document.getElementById('toko-pemilik').value = pemilik;
            document.getElementById('toko-alamat').value = alamat;
            document.getElementById('toko-kontak').value = kontak;

            // Update action form dengan ID
            const form = document.getElementById('edit-form');
            form.action = `/toko/${id}`;
        });
    });
</script>
