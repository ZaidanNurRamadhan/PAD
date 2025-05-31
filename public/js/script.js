function toggleDropdown(element) {
    const dropdownOptions = element.nextElementSibling;
    dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
}

function selectOption(element, value) {
    const dropdown = element.closest('.dropdown');
    const selectedText = dropdown.querySelector('.selected-text');
    selectedText.textContent = value;

    // Tutup dropdown setelah memilih
    const dropdownOptions = dropdown.querySelector('.dropdown-options');
    dropdownOptions.style.display = 'none';

    // Lakukan AJAX request ke server untuk mendapatkan data berdasarkan periode
    fetch(`/data/${value}`)
        .then(response => response.json())
        .then(data => {
            // Render data ke dalam tabel
            renderTable(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// bagian pemasok
function editPemasok(id) {
    // Ambil data pemasok dari server
    fetch(`/pemasok/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Isi form di modal dengan data pemasok
            document.getElementById('pemasok-name').value = data.name;
            document.getElementById('pemasok-produk').value = data.produkDisediakan;
            document.getElementById('pemasok-kontak').value = data.nomorTelepon;
            document.getElementById('pemasok-email').value = data.email;

            // Ubah action form sesuai dengan ID pemasok
            document.getElementById('edit-form').action = `/pemasok/${id}`;
            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('Editpemasok')).show();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

window.editTransaksi = function(id) {
    // Ambil data transaksi dengan AJAX
    fetch(`/transaksi/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            let transactionDate = new Date(data.transactionDate).toISOString().split('T')[0];
            // Isi data ke dalam form
            document.getElementById('toko_id').value = data.toko_id;
            document.getElementById('produk_id').value = data.produk_id;
            document.getElementById('transactionDate').value = transactionDate;
            document.getElementById('jumlahDibeli').value = data.jumlahDibeli;
            document.getElementById('harga').value = data.harga;
            document.getElementById('terjual').value = data.terjual;
            document.getElementById('tanggal_retur').value = data.returDate || '';
            document.getElementById('editTransaksiForm').action = `/transaksi/${data.id}`;

            // Tampilkan modal
            // console.log(data)
            new bootstrap.Modal(document.getElementById('Edittransaksi')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data transaksi!');
        });
}

// bagian gudang

// Edit Produk modal population using API fetch
const editButtons = document.querySelectorAll('.edit-btn');
editButtons.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const token = localStorage.getItem('authToken');

        // Fetch produk data from API with Bearer token
        fetch(`/api/gudang/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': 'Bearer ' + token
            }
        })
        .then(response => response.json())
        .then(produk => {
            document.querySelector('#editForm').dataset.id = id;
            document.querySelector('#editName').value = produk.name;
            document.querySelector('#editHargaBeli').value = produk.hargaBeli;
            document.querySelector('#editHargaJual').value = produk.hargaJual;
            document.querySelector('#editJumlahStok').value = produk.jumlah;
            document.querySelector('#editAmbangKritis').value = produk.batasKritis;
        })
        .catch(error => {
            console.error('Error fetching produk data:', error);
            alert('Gagal mengambil data produk untuk diedit.');
        });
    });
});

// Handle edit form submission via API using POST with method override
const editForm = document.querySelector('#editForm');
editForm.addEventListener('submit', function(event) {
    event.preventDefault();
    const id = this.dataset.id;
    const formData = {
        name: document.querySelector('#editName').value,
        hargaBeli: parseInt(document.querySelector('#editHargaBeli').value),
        hargaJual: parseInt(document.querySelector('#editHargaJual').value),
        jumlah: parseInt(document.querySelector('#editJumlahStok').value),
        batasKritis: parseInt(document.querySelector('#editAmbangKritis').value),
        _method: 'PUT' // method override for POST
    };

    fetch(`http://127.0.0.1:8000/api/gudang/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => { throw new Error(data.message || 'Gagal memperbarui produk'); });
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('Editproduk'));
        modal.hide();
        // Reload page or refresh data
        location.reload();
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});


const deletePemasok = document.querySelectorAll('.deletePemasok');
deletePemasok.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        document.querySelector('#deletePemasokForm').action = `/pemasok/${id}`;
    });
});
const deleteToko = document.querySelectorAll('.deleteToko');
deleteToko.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        document.querySelector('#deleteTokoForm').action = `/toko/destroy/${id}`;
    });
});
const deleteKaryawan = document.querySelectorAll('.deleteKaryawan');
deleteKaryawan.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        document.querySelector('#deleteKaryawanForm').action = `/karyawan/destroy/${id}`;
    });
});

// Edit Transaksi form submission using API
document.addEventListener('DOMContentLoaded', function() {
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

            fetch(`http://127.0.0.1:8000/api/transaksi/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
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
                alert(data.message);
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
});
