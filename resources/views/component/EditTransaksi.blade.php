<section class="modal fade" id="Edittransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Transaksi</h1>
            </header>
            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="post">
                @csrf
                @method('PUT') <!-- Gunakan PUT untuk update -->
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko_id">Nama Toko</label>
                        <select name="toko_id" id="toko_id" class="form-control" style="max-width: 273px;" required>
                            @foreach ($tokos as $toko)
                                <option value="{{ $toko->id }}" {{ $transaksi->toko_id == $toko->id ? 'selected' : '' }}>
                                    {{ $toko->nama_toko }}
                                </option>
                            @endforeach
                        </select>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="produk_id">Nama Produk</label>
                        <select name="produk_id" id="produk_id" class="form-control" style="max-width: 273px;">
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" {{ $produk->id == $transaksi->produk_id ? 'selected' : '' }}>
                                    {{ $produk->nama }}
                                </option>
                            @endforeach
                        </select>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" style="max-width: 273px;" value="{{ $transaksi->transactionDate }}">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control" style="max-width: 273px;" placeholder="Masukkan harga" value="{{ $transaksi->amount }}">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="terjual">Terjual</label>
                        <input type="text" name="terjual" id="terjual" class="form-control" style="max-width: 273px;" placeholder="Masukkan produk terjual" value="{{ $transaksi->terjual }}">
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_retur">Tanggal Retur</label>
                        <input type="date" name="tanggal_retur" id="tanggal_retur" class="form-control" style="max-width: 273px;" value="{{ $transaksi->returDate }}">
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