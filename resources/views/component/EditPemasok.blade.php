<section class="modal fade" id="Editpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemasok</h1>
            </header>
            <form id="editPemasokForm" method="post">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="pemasok-name">Nama Pemasok</label>
                        <input type="text" id="pemasok-name" name="name" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemasok" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-produk">Produk</label>
                        <input type="text" id="pemasok-produk" name="produkDisediakan" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama produk" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-kontak">Kontak</label>
                        <input type="number" id="pemasok-kontak" name="nomorTelepon" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak pemasok" required>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="pemasok-email">Email</label>
                        <input type="email" id="pemasok-email" name="email" class="form-control" style="max-width: 273px;" placeholder="Masukkan email pemasok" required>
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
<script>
(function() {
    function editPemasok(id) {
        // Ambil data pemasok dari server API endpoint
        const token = localStorage.getItem('authToken');
        fetch(`/api/pemasok/${id}`, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Data pemasok tidak ditemukan');
                }
                return response.json();
            })
            .then(data => {
                // Isi form di modal dengan data pemasok
                document.getElementById('pemasok-name').value = data.data.name;
                document.getElementById('pemasok-produk').value = data.data.produkDisediakan;
                document.getElementById('pemasok-kontak').value = data.data.nomorTelepon;
                document.getElementById('pemasok-email').value = data.data.email;

                // Simpan id pemasok di form dataset untuk submit handler
                document.getElementById('editPemasokForm').dataset.id = id;

                // Tampilkan modal
                new bootstrap.Modal(document.getElementById('Editpemasok')).show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
            });
    }

    const editFormPemasok = document.querySelector('#editPemasokForm');
    if (editFormPemasok) {
        editFormPemasok.addEventListener('submit', function(event) {
            event.preventDefault();
            const id = this.dataset.id;
            if (!id) {
                alert('ID pemasok tidak ditemukan.');
                return;
            }

            const token = localStorage.getItem('authToken');
            if (!token) {
                alert('Authentication token not found. Please login again.');
            return;
        }

        const formData = {
            name: document.getElementById('pemasok-name').value,
            produkDisediakan: document.getElementById('pemasok-produk').value,
            nomorTelepon: document.getElementById('pemasok-kontak').value,
            email: document.getElementById('pemasok-email').value,
            _method: 'PUT'
        };

        fetch(`/api/pemasok/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.message || 'Gagal memperbarui pemasok'); });
            }
            return response.json();
        })
        .then(data => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('Editpemasok'));
            modal.hide();
            location.reload();
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
        });
    };
    window.editPemasok = editPemasok;
})();
</script>
function editPemasok(id) {
    // Ambil data pemasok dari server API endpoint
    const token = localStorage.getItem('authToken');
    fetch(`/api/pemasok/${id}`, {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Data pemasok tidak ditemukan');
            }
            return response.json();
        })
        .then(data => {
            // Isi form di modal dengan data pemasok
            document.getElementById('pemasok-name').value = data.data.name;
            document.getElementById('pemasok-produk').value = data.data.produkDisediakan;
            document.getElementById('pemasok-kontak').value = data.data.nomorTelepon;
            document.getElementById('pemasok-email').value = data.data.email;

            // Simpan id pemasok di form dataset untuk submit handler
            document.getElementById('editPemasokForm').dataset.id = id;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('Editpemasok')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
}

const editFormPemasok = document.querySelector('#editPemasokForm');
if (editFormPemasok) {
    editFormPemasok.addEventListener('submit', function(event) {
        event.preventDefault();
        const id = this.dataset.id;
        if (!id) {
            alert('ID pemasok tidak ditemukan.');
            return;
        }

        const token = localStorage.getItem('authToken');
        if (!token) {
            alert('Authentication token not found. Please login again.');
        return;
    }

    const formData = {
        name: document.getElementById('pemasok-name').value,
        produkDisediakan: document.getElementById('pemasok-produk').value,
        nomorTelepon: document.getElementById('pemasok-kontak').value,
        email: document.getElementById('pemasok-email').value,
        _method: 'PUT'
    };

    fetch(`/api/pemasok/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => { throw new Error(data.message || 'Gagal memperbarui pemasok'); });
        }
        return response.json();
    })
    .then(data => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('Editpemasok'));
        modal.hide();
        location.reload();
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
    });
};
</script>
