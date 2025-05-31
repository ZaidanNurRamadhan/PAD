<div class="modal fade" id="Editproduk" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editName" class="form-label">Nama Produk</label>
                    <input type="text" id="editName" name="name" class="form-control" required>
                    <small class="text-danger error-name"></small>
                </div>
                <div class="mb-3">
                    <label for="editHargaBeli" class="form-label">Harga Beli</label>
                    <input type="number" id="editHargaBeli" name="hargaBeli" class="form-control" required>
                    <small class="text-danger error-hargaBeli"></small>
                </div>
                <div class="mb-3">
                    <label for="editHargaJual" class="form-label">Harga Jual</label>
                    <input type="number" id="editHargaJual" name="hargaJual" class="form-control" required>
                    <small class="text-danger error-hargaJual"></small>
                </div>
                <div class="mb-3">
                    <label for="editJumlahStok" class="form-label">Jumlah Stok</label>
                    <input type="number" id="editJumlahStok" name="jumlah" class="form-control" required>
                    <small class="text-danger error-jumlah"></small>
                </div>
                <div class="mb-3">
                    <label for="editAmbangKritis" class="form-label">Batas Kritis</label>
                    <input type="number" id="editAmbangKritis" name="batasKritis" class="form-control" required>
                    <small class="text-danger error-batasKritis"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentEditId = null;

    // Function to open modal and populate form with product data
    function openEditModal(produk) {
        currentEditId = produk.id;
        document.getElementById('editName').value = produk.name;
        document.getElementById('editHargaBeli').value = produk.hargaBeli;
        document.getElementById('editHargaJual').value = produk.hargaJual;
        document.getElementById('editJumlahStok').value = produk.jumlah;
        document.getElementById('editAmbangKritis').value = produk.batasKritis;

        var editModal = new bootstrap.Modal(document.getElementById('Editproduk'));
        editModal.show();
    }

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Clear previous error messages
        document.querySelectorAll('.text-danger').forEach(function(errorElement) {
            errorElement.innerText = '';
        });

        // Gather form data
        const data = {
            name: document.getElementById('editName').value.trim(),
            hargaBeli: document.getElementById('editHargaBeli').value.trim(),
            hargaJual: document.getElementById('editHargaJual').value.trim(),
            jumlah: document.getElementById('editJumlahStok').value.trim(),
            batasKritis: document.getElementById('editAmbangKritis').value.trim(),
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

        // Send data to API endpoint
        const token = localStorage.getItem('authToken'); // Get bearer token from localStorage
        fetch(`http://127.0.0.1:8000/api/gudang/${currentEditId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': token ? `Bearer ${token}` : ''
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            if (response.ok) {
                const resData = await response.json();
                alert(resData.message);
                var editModal = bootstrap.Modal.getInstance(document.getElementById('Editproduk'));
                editModal.hide();
                fetchProdukData();
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
                alert('Terjadi kesalahan saat memperbarui produk.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    });
</script>
