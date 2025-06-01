<section class="modal fade" id="Editpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemasok</h1>
            </header>
            <form id="editPemasokForm" method="post">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="pemasok-name">Nama Pemasok</label>
                        <input type="text" id="pemasok-name" name="name" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemasok" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-produk">Produk</label>
                        <input type="text" id="pemasok-produk" name="produkDisediakan" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-kontak">Kontak</label>
                        <input type="number" id="pemasok-kontak" name="nomorTelepon" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak pemasok" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-email">Email</label>
                        <input type="email" id="pemasok-email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email pemasok" required>
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
