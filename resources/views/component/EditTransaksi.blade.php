<section class="modal fade" id="Edittransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
      <main class="modal-content">
        <header class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Transaksi</h1>
        </header>
        <form action="" method="post">
            <article class="modal-body">
                <section class="form-group d-flex justify-content-between px-3">
                    <label for="">Nama Toko</label>
                    <input type="text" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                </section>
                <section class="form-group d-flex justify-content-between px-3 mt-4">
                    <label for="">Nama Produk</label>
                    <input type="text" name="pname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk">
                </section>
                <section class="form-group d-flex justify-content-between px-3 mt-4">
                    <label for="">Tanggal Keluar</label>
                    <input type="date" name="tglkeluar" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
                </section>
                <section class="form-group d-flex justify-content-between px-3 mt-4">
                    <label for="">Harga</label>
                    <input type="text" name="harga" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga">
                </section>
                <section class="form-group d-flex justify-content-between px-3 mt-4">
                    <label for="">Terjual</label>
                    <input type="text" name="jstok" class="form-control" style="max-width: 273px;" placeholder="Masukkan produk terjual">
                </section>
                <section class="form-group d-flex justify-content-between px-3 mt-4">
                    <label for="">Tanggal Retur</label>
                    <input type="date" name="tglretur" class="form-control" style="max-width: 273px;" placeholder="dd/mm/yyyy">
                </section>
            </article>
        </form>
        <footer class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary">Simpan</button>
        </footer>
    </main>
    </div>
  </section>
