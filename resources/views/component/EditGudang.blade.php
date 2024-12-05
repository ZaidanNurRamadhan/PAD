<div class="modal fade" id="Editproduk" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editName" class="form-label">Nama Produk</label>
                    <input type="text" id="editName" name="pname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="editHargaBeli" class="form-label">Harga Beli</label>
                    <input type="number" id="editHargaBeli" name="hbeli" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="editHargaJual" class="form-label">Harga Jual</label>
                    <input type="number" id="editHargaJual" name="hjual" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="editJumlahStok" class="form-label">Jumlah Stok</label>
                    <input type="number" id="editJumlahStok" name="jstok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="editAmbangKritis" class="form-label">Batas Kritis</label>
                    <input type="number" id="editAmbangKritis" name="astok" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
