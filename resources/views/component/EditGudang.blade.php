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
                    <select id="editName" name="name" class="form-control" required>
                        <option value="" disabled selected>Pilih Nama Produk</option>
                    </select>
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

// Fetch pemasok list and populate dropdown
async function populateEditDropdown(selectedValue = '') {
    const token = localStorage.getItem('authToken');
    try {
        const response = await fetch('/api/pemasok', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        const result = await response.json();
        const select = document.getElementById('editName');
        select.innerHTML = '<option value="" disabled selected>Pilih Nama Produk</option>';

        result.data.forEach(p => {
            const option = document.createElement('option');
            option.value = p.produkDisediakan;
            option.textContent = `${p.produkDisediakan} (${p.name})`;
            if (selectedValue && selectedValue === p.produkDisediakan) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching pemasok:', error);
    }
}

// Open modal and set form values
function openEditModal(produk) {
    currentEditId = produk.id;

    populateEditDropdown(produk.name); // Fill and select dropdown option

    document.getElementById('editHargaBeli').value = produk.hargaBeli;
    document.getElementById('editHargaJual').value = produk.hargaJual;
    document.getElementById('editJumlahStok').value = produk.jumlah;
    document.getElementById('editAmbangKritis').value = produk.batasKritis;

    const modal = new bootstrap.Modal(document.getElementById('Editproduk'));
    modal.show();
}

// Form submission
document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Clear errors
    document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');

    const data = {
        name: document.getElementById('editName').value.trim(),
        hargaBeli: document.getElementById('editHargaBeli').value.trim(),
        hargaJual: document.getElementById('editHargaJual').value.trim(),
        jumlah: document.getElementById('editJumlahStok').value.trim(),
        batasKritis: document.getElementById('editAmbangKritis').value.trim()
    };

    let valid = true;
    if (!data.name) {
        document.querySelector('.error-name').innerText = 'Nama produk tidak boleh kosong.';
        valid = false;
    }
    if (!data.hargaBeli || isNaN(data.hargaBeli)) {
        document.querySelector('.error-hargaBeli').innerText = 'Harga beli harus berupa angka.';
        valid = false;
    }
    if (!data.hargaJual || isNaN(data.hargaJual)) {
        document.querySelector('.error-hargaJual').innerText = 'Harga jual harus berupa angka.';
        valid = false;
    }
    if (!data.jumlah || isNaN(data.jumlah)) {
        document.querySelector('.error-jumlah').innerText = 'Jumlah stok harus berupa angka.';
        valid = false;
    }
    if (data.batasKritis && isNaN(data.batasKritis)) {
        document.querySelector('.error-batasKritis').innerText = 'Batas kritis harus berupa angka.';
        valid = false;
    }

    if (!valid) return;

    const token = localStorage.getItem('authToken');

    fetch(`/api/gudang/${currentEditId}`, {
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
            const res = await response.json();
            alert(res.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('Editproduk'));
            modal.hide();
            location.reload();
        } else if (response.status === 422) {
            const res = await response.json();
            for (const [key, messages] of Object.entries(res.errors || {})) {
                const el = document.querySelector(`.error-${key}`);
                if (el) el.innerText = messages.join(' ');
            }
        } else {
            alert('Terjadi kesalahan saat memperbarui produk.');
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
