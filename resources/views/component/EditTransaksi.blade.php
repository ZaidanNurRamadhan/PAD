<section class="modal fade" id="Edittransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Transaksi</h1>
            </header>
            <form method="post" id="editTransaksiForm">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko_id">Nama Toko</label>
                        <select name="toko_id" id="toko_id" class="form-control" style="max-width: 273px;" required>
                            @foreach ($tokos as $toko)
                            <option value="{{ $toko->id }}">{{ $toko->name }}</option>
                            @endforeach
                        </select>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="produk_id">Nama Produk</label>
                        <select name="produk_id" id="produk_id" class="form-control" style="max-width: 273px;">
                            @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->name }}</option>
                            @endforeach
                        </select>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="transactionDate" class="form-control" style="max-width: 273px;">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="terjual">Terjual</label>
                        <input type="text" name="terjual" id="terjual" class="form-control" style="max-width: 273px;" placeholder="Masukkan produk terjual">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_retur">Tanggal Retur</label>
                        <input type="date" name="tanggal_retur" id="tanggal_retur" class="form-control" style="max-width: 273px;">
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
