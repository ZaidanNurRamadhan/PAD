<section class="modal fade" id="Tambahproduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk</h1>
            </header>
            <form id="formTambahProduk" action="{{ route('gudang.store') }}" method="post">
                @csrf
                <article class="modal-body">
                    <section class="form-group px-3">
                        <div class="d-flex justify-content-between">
                            <label for="name">Nama Produk</label>
                            <div class="d-flex flex-column" style="width: 60%">
                                <select name="name" id="name" class="form-control" required>
                                    <option value="" disabled selected>Pilih Nama Produk</option>
                                    @foreach($pemasok as $p)
                                        <optgroup label="{{ $p->name }}">
                                            <option value="{{ $p->produkDisediakan }}">{{ $p->produkDisediakan }}</option>
                                        </optgroup>
                                    @endforeach
                                </select>
                                <small class="text-danger error-name"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="hargaBeli">Harga Beli</label>
                            <div class="d-flex-flex-colum" style="width: 60%">
                                <input type="number" name="hargaBeli" id="hargaBeli" class="form-control" placeholder="Masukkan harga beli" required>
                                <small class="text-danger error-hargaBeli"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="hargaJual">Harga Jual</label>
                            <div class="d-flex-flex-colum" style="width: 60%">
                                <input type="number" name="hargaJual" id="hargaJual" class="form-control" placeholder="Masukkan harga jual" required>
                                <small class="text-danger error-hargaJual"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="jumlah">Stok</label>
                            <div class="d-flex-flex-colum" style="width: 60%">
                                <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan jumlah stok" required>
                                <small class="text-danger error-jumlah"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group px-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <label for="batasKritis">Batas Kritis</label>
                            <div class="d-flex-flex-colum" style="width: 60%">
                                <input type="text" name="batasKritis" id="batasKritis" class="form-control" placeholder="Masukkan ambang kritis">
                                <small class="text-danger error-batasKritis"></small>
                            </div>
                        </div>
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitProduk">Tambah</button>
                </footer>
            </form>
        </main>
    </div>
</section>
<script>
    document.getElementById('submitProduk').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form from submitting immediately

        // Get form elements
        var name = document.getElementById('name');
        var hargaBeli = document.getElementById('hargaBeli');
        var hargaJual = document.getElementById('hargaJual');
        var jumlah = document.getElementById('jumlah');
        var batasKritis = document.getElementById('batasKritis');

        var valid = true; // Flag to check if the form is valid

        // Clear previous error messages
        document.querySelectorAll('.text-danger').forEach(function(errorElement) {
            errorElement.innerText = '';
        });

        // Validate Nama Produk (select dropdown)
        if (name.value.trim() === '') {
            document.querySelector('.error-name').innerText = 'Nama produk tidak boleh kosong.';
            valid = false;
        }

        // Validate Harga Beli (required and must be numeric)
        if (hargaBeli.value.trim() === '') {
            document.querySelector('.error-hargaBeli').innerText = 'Harga beli tidak boleh kosong.';
            valid = false;
        } else if (isNaN(hargaBeli.value.trim())) {
            document.querySelector('.error-hargaBeli').innerText = 'Harga beli harus berupa angka.';
            valid = false;
        }

        // Validate Harga Jual (required and must be numeric)
        if (hargaJual.value.trim() === '') {
            document.querySelector('.error-hargaJual').innerText = 'Harga jual tidak boleh kosong.';
            valid = false;
        } else if (isNaN(hargaJual.value.trim())) {
            document.querySelector('.error-hargaJual').innerText = 'Harga jual harus berupa angka.';
            valid = false;
        }

        // Validate Jumlah Stok (required and must be numeric)
        if (jumlah.value.trim() === '') {
            document.querySelector('.error-jumlah').innerText = 'Jumlah stok tidak boleh kosong.';
            valid = false;
        } else if (isNaN(jumlah.value.trim())) {
            document.querySelector('.error-jumlah').innerText = 'Jumlah stok harus berupa angka.';
            valid = false;
        }

        // Validate Ambang Kritis (optional, can be text or numeric)
        if (batasKritis.value.trim() === '') {
            document.querySelector('.error-batasKritis').innerText = 'Batas Kritis tidak boleh kosong.';
            valid = false;
        }else if (batasKritis.value.trim() !== '' && isNaN(batasKritis.value.trim())) {
            document.querySelector('.error-batasKritis').innerText = 'Batas kritis harus berupa angka jika diisi.';
            valid = false;
        }

        // If form is valid, submit it
        if (valid) {
            var form = document.getElementById('formTambahProduk');
            form.submit(); // Submit the form if valid
        }
    });
</script>
