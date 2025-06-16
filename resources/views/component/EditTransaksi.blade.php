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
                        </select>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="produk_id">Nama Produk</label>
                        <select name="produk_id" id="produk_id" class="form-control" style="max-width: 273px;">
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
                        <label for="harga">Jumlah</label>
                        <input type="text" name="jumlahDibeli" id="jumlahDibeli" class="form-control" style="max-width: 273px;" placeholder="Masukkan jumlah">
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
@if(session('token'))
    <script>
        localStorage.setItem('authToken', "{{ session('token') }}");
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('authToken');
        // Fetch toko data and populate select
        fetch('/api/toko', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const tokoSelect = document.getElementById('toko_id');
                tokoSelect.innerHTML = '';
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
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const produkSelect = document.getElementById('produk_id');
                produkSelect.innerHTML = '';
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
    });
    const editTransaksiForm = document.getElementById('editTransaksiForm');
    if (editTransaksiForm !== null) {
        editTransaksiForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const token = localStorage.getItem('authToken');
            if (!token) {
                alert('Authentication token not found. Please login again.');
                return;
            }

            const form = event.target;
            const id = form.action.split('/').pop();

            const formData = {
                toko_id: document.getElementById('toko_id').value,
                produk_id: document.getElementById('produk_id').value,
                tanggal_keluar: document.getElementById('transactionDate').value,
                harga: parseFloat(document.getElementById('harga').value),
                jumlahDibeli: parseInt(document.getElementById('jumlahDibeli').value),
                terjual: parseInt(document.getElementById('terjual').value),
                tanggal_retur: document.getElementById('tanggal_retur').value || null,
            };

            fetch(`/api/transaksi/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Gagal memperbarui transaksi');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('Edittransaksi'));
                modal.hide();
                // Reload page or refresh data
                location.reload();
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    }
</script>
