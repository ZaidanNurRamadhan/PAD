<section class="modal fade" id="Tambahtransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Transaksi</h1>
            </header>
            <form id="tambahTransaksiForm">
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko_id">Nama Toko</label>
                        <select name="toko_id" id="toko_id_tambah" class="form-control" style="width:60%;" required>
                            <option value="">Pilih Toko</option>
                        </select>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="produk_id">Nama Produk</label>
                        <select name="produk_id" id="produk_id_tambah" class="form-control" style="width:60%;" required>
                            <option value="">Pilih Produk</option>
                        </select>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" style="width:60%;" required>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="harga_tambah">Harga</label>
                        <input type="number" name="harga" id="harga_tambah" class="form-control" style="width:60%;" placeholder="Masukkan harga" required>
                    </section>

                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="jumlahDibeli_tambah">Jumlah</label>
                        <input type="number" name="jumlahDibeli" id="jumlahDibeli_tambah" class="form-control" style="width:60%;" placeholder="Masukkan jumlah" required>
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
@if(session('token'))
    <script>
        localStorage.setItem('authToken', "{{ session('token') }}");
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch toko data and populate select
        fetch('/api/toko', {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const tokoSelect = document.getElementById('toko_id_tambah');
                tokoSelect.innerHTML = '<option value="">Pilih Toko</option>';
                const tokoList = data.data ? data.data : data;
                tokoList.forEach(toko => {
                    const option = document.createElement('option');
                    option.value = toko.id;
                    option.textContent = toko.name;
                    tokoSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching toko data:', error);
            });

        // Fetch produk data and populate select
        fetch('/api/gudang', {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const produkSelect = document.getElementById('produk_id_tambah');
                produkSelect.innerHTML = '<option value="">Pilih Produk</option>';
                const produkList = data.produks ? data.produks : data;
                produkList.forEach(produk => {
                    const option = document.createElement('option');
                    option.value = produk.id;
                    option.textContent = produk.name;
                    produkSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching produk data:', error);
            });

        // Existing form submission handler
            document.getElementById('tambahTransaksiForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const token = localStorage.getItem('authToken');
                if (!token) {
                    alert('Authentication token not found. Please login again.');
                    return;
                }

                const formData = {
                    toko_id: document.getElementById('toko_id_tambah').value,
                    produk_id: document.getElementById('produk_id_tambah').value,
                    tanggal_keluar: document.getElementById('tanggal_keluar').value,
                    harga: parseFloat(document.getElementById('harga_tambah').value),
                    jumlahDibeli: parseInt(document.getElementById('jumlahDibeli_tambah').value),
                    terjual: document.getElementById('terjual').value ? parseInt(document.getElementById('terjual').value) : 0,
                    tanggal_retur: document.getElementById('tanggal_retur').value || null,
                };

                console.log('Submitting formData:', formData);

                fetch('/api/transaksi', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat().join('\\n');
                                throw new Error(errorMessages);
                            }
                            throw new Error(data.message || 'Failed to add transaksi');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // alert('Transaksi berhasil ditambahkan');
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('Tambahtransaksi'));
                    modal.hide();

                    // Optionally, refresh the transaksi table by reloading the page or calling a function
                    location.reload();
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                    console.error('Error details:', error);
                });
            });
    });
</script>
