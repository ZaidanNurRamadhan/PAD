<section class="modal fade" id="Tambahtransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Transaksi</h1>
            </header>
            <form action="{{ route('transaksi.store') }}" method="post">
                @csrf
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko_id">Nama Toko</label>
                        <select name="toko_id" id="toko_id" class="form-control" style="width:60%;" required>
                            <option value="">Pilih Toko</option>
                            @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}">{{ $toko->name }}</option>
                            @endforeach
                        </select>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="produk_id">Nama Produk</label>
                        <select name="produk_id" id="produk_id" class="form-control" style="width:60%;" required>
                            <option value="">Pilih Produk</option>
                            @foreach($produks as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" style="width:60%;" required>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" style="width:60%;" placeholder="Masukkan harga" required>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="harga">Jumlah</label>
                        <input type="number" name="jumlahDibeli" id="jumlahDibeli" class="form-control" style="width:60%;" placeholder="Masukkan jumlah" required>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="terjual">Terjual</label>
                        <input type="number" name="terjual" id="terjual" class="form-control" style="width:60%;" placeholder="Masukkan produk terjual">
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_retur">Tanggal Retur</label>
                        <input type="date" name="tanggal_retur" id="tanggal_retur" class="form-control" style="width:60%;">
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </footer>
            </form>
        </main>
    </div>
</section>
