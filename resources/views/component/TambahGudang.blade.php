<section class="modal fade" id="Tambahproduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk</h1>
            </header>
            <form id="formTambahProduk">
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
    document.getElementById('formTambahProduk').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Clear previous error messages
        document.querySelectorAll('.text-danger').forEach(function(errorElement) {
            errorElement.innerText = '';
        });

        // Gather form data
        const data = {
            name: document.getElementById('name').value.trim(),
            hargaBeli: document.getElementById('hargaBeli').value.trim(),
            hargaJual: document.getElementById('hargaJual').value.trim(),
            jumlah: document.getElementById('jumlah').value.trim(),
            batasKritis: document.getElementById('batasKritis').value.trim(),
        };

        // Basic client-side validation
        let valid = true;
        if (!data.name) {
            document.querySelector('.error-name').innerText = 'Nama produk tidak boleh kosong.';
            valid = false;
        }
        if (!data.hargaBeli || isNaN(data.hargaBeli)) {
            document.querySelector('.error-hargaBeli').innerText = 'Harga beli harus berupa angka dan tidak boleh kosong.';
            valid = false;
        }
        if (!data.hargaJual || isNaN(data.hargaJual)) {
            document.querySelector('.error-hargaJual').innerText = 'Harga jual harus berupa angka dan tidak boleh kosong.';
            valid = false;
        }
        if (!data.jumlah || isNaN(data.jumlah)) {
            document.querySelector('.error-jumlah').innerText = 'Jumlah stok harus berupa angka dan tidak boleh kosong.';
            valid = false;
        }
        if (data.batasKritis && isNaN(data.batasKritis)) {
            document.querySelector('.error-batasKritis').innerText = 'Batas kritis harus berupa angka jika diisi.';
            valid = false;
        }

        if (!valid) {
            return;
        }

        const token = localStorage.getItem('authToken'); // Get token from localStorage

        // Send data to API endpoint
        fetch('/api/gudang', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': `Bearer ${token}` // Add Authorization header
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            if (response.ok) {
                const resData = await response.json();
                alert(resData.message);
                // Optionally reset form or close modal
                document.getElementById('formTambahProduk').reset();
                var modal = bootstrap.Modal.getInstance(document.getElementById('Tambahproduk'));
                modal.hide();
                location.reload();
                // Optionally refresh the page or update the product list dynamically
            } else if (response.status === 422) {
                const errorData = await response.json();
                if (errorData.errors) {
                    for (const [key, messages] of Object.entries(errorData.errors)) {
                        const errorElement = document.querySelector('.error-' + key);
                        if (errorElement) {
                            errorElement.innerText = messages.join(' ');
                        }
                    }
                }
            } else {
                alert('Terjadi kesalahan saat menambahkan produk.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
