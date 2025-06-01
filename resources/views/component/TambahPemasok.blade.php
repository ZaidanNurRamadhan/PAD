<section class="modal fade" id="Tambahpemasok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pemasok</h1>
            </header>
            <form id="formTambahPemasok">
                @csrf
                <div class="modal-body">
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="name" class="form-label">Nama Pemasok</label>
                            <div class="d-flex flex-column">
                                <input style="width:100%" type="text" name="name" class="form-control" id="name">
                                <small class="text-danger error-name" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="produkDisediakan" class="form-label">Produk</label>
                            <div class="d-flex flex-column">
                                <input style="width:100%" type="text" name="produkDisediakan" class="form-control" id="produkDisediakan">
                                <small class="text-danger error-produkDisediakan" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <div class="d-flex flex-column">
                                <input style="width:100%" type="text" name="nomorTelepon" class="form-control" id="nomorTelepon">
                                <small class="text-danger error-nomorTelepon" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="email" class="form-label">Email</label>
                            <div class="d-flex flex-column">
                                <input style="width:100%" type="email" name="email" class="form-control" id="email">
                                <small class="text-danger error-email" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitPemasok" style="font-size: 0.8rem">Tambah</button>
                </div>
            </form>
        </main>
    </div>
</section>
<script>
document.getElementById('submitPemasok').addEventListener('click', async function(event) {
    event.preventDefault(); // Prevent form from submitting immediately

    // Get form elements
    var name = document.getElementById('name');
    var produkDisediakan = document.getElementById('produkDisediakan');
    var nomorTelepon = document.getElementById('nomorTelepon');
    var email = document.getElementById('email');

    var valid = true; // Flag to check if the form is valid

    // Clear previous error messages
    document.querySelectorAll('.text-danger').forEach(function(errorElement) {
        errorElement.innerText = '';
    });

    // Validate name (required and no numbers)
    if (name.value.trim() === '') {
        document.querySelector('.error-name').innerText = 'Nama pemasok tidak boleh kosong.';
        valid = false;
    } else if (/\d/.test(name.value)) {
        document.querySelector('.error-name').innerText = 'Nama pemasok tidak boleh mengandung angka.';
        valid = false;
    }

    // Validate produkDisediakan (required and no numbers)
    if (produkDisediakan.value.trim() === '') {
        document.querySelector('.error-produkDisediakan').innerText = 'Produk yang disediakan tidak boleh kosong.';
        valid = false;
    } else if (/\d/.test(produkDisediakan.value)) {
        document.querySelector('.error-produkDisediakan').innerText = 'Produk tidak boleh mengandung angka.';
        valid = false;
    }

    // Validate nomorTelepon (required and must be numeric)
    if (nomorTelepon.value.trim() === '') {
        document.querySelector('.error-nomorTelepon').innerText = 'Nomor telepon tidak boleh kosong.';
        valid = false;
    } else if (isNaN(nomorTelepon.value.trim())) {
        document.querySelector('.error-nomorTelepon').innerText = 'Nomor telepon harus berupa angka.';
        valid = false;
    }

    // Validate email (required and must be valid format)
    if (email.value.trim() === '') {
        document.querySelector('.error-email').innerText = 'Email tidak boleh kosong.';
        valid = false;
    } else if (!validateEmail(email.value.trim())) {
        document.querySelector('.error-email').innerText = 'Format email tidak valid.';
        valid = false;
    }

    if (!valid) {
        return; // Stop submission if client validation fails
    }

    // Prepare data for API
    const data = {
        name: name.value.trim(),
        produkDisediakan: produkDisediakan.value.trim(),
        nomorTelepon: nomorTelepon.value.trim(),
        email: email.value.trim()
    };

    try {
        // Get token from localStorage or other storage
        const token = localStorage.getItem('authToken'); // Adjust key as needed

        const response = await fetch('http://127.0.0.1:8000/api/pemasok', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            // Remove credentials since using Bearer token
            body: JSON.stringify(data)
        });

        if (response.status === 201) {
            // Success
            alert('Pemasok berhasil ditambahkan.');
            // Optionally reset form and close modal
            document.getElementById('formTambahPemasok').reset();
            var modal = bootstrap.Modal.getInstance(document.getElementById('Tambahpemasok'));
            modal.hide();
            fetchAndRenderPemasok();
        } else if (response.status === 422) {
            // Validation errors from server
            const result = await response.json();
            const errors = result.errors;
            for (const field in errors) {
                if (errors.hasOwnProperty(field)) {
                    const errorElement = document.querySelector('.error-' + field);
                    if (errorElement) {
                        errorElement.innerText = errors[field][0];
                    }
                }
            }
        } else {
            alert('Terjadi kesalahan saat menambahkan pemasok.');
        }
    } catch (error) {
        alert('Gagal menghubungi server.');
    }
});

// Helper function to validate email format
function validateEmail(email) {
    var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}
</script>


