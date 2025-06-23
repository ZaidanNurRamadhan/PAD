<section class="modal fade" id="Tambahtoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Toko</h1>
            </header>
            <form id="formTambahToko">
                @csrf
                <div class="modal-body">
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="name" class="form-label">Nama Toko</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input style="width:100%" type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama toko">
                                <small class="text-danger error-name" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="namaPemilik" class="form-label">Nama Pemilik</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input style="width:100%" type="text" id="namaPemilik" name="namaPemilik" class="form-control" placeholder="Masukkan nama pemilik toko">
                                <small class="text-danger error-namaPemilik" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="address" class="form-label">Alamat</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input style="width:100%" type="text" id="address" name="address" class="form-control" placeholder="Masukkan alamat toko">
                                <small class="text-danger error-address" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="phone_number" class="form-label">Kontak</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input style="width:100%" type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Masukkan kontak toko">
                                <small class="text-danger error-phone_number" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitToko" style="font-size: 0.8rem">Tambah</button>
                </div>
            </form>
        </main>
    </div>
</section>

<script>
document.getElementById('formTambahToko').addEventListener('submit', function(event) {
    event.preventDefault();

    var name = document.getElementById('name').value.trim();
    var namaPemilik = document.getElementById('namaPemilik').value.trim();
    var address = document.getElementById('address').value.trim();
    var phone_number = document.getElementById('phone_number').value.trim();

    var valid = true;

     document.querySelectorAll('.text-danger').forEach(function(el) {
        el.innerText = '';
    });

    // Validate name
    if (name === '') {
        document.querySelector('.error-name').innerText = 'Nama toko tidak boleh kosong.';
        valid = false;
    }

    // Validate nama pemilik
    if (namaPemilik === '') {
        document.querySelector('.error-namaPemilik').innerText = 'Nama pemilik tidak boleh kosong.';
        valid = false;
    }

    // Validate address
    if (address === '') {
        document.querySelector('.error-address').innerText = 'Alamat tidak boleh kosong.';
        valid = false;
    }

    // Validate phone number
    if (phone_number === '') {
        document.querySelector('.error-phone_number').innerText = 'Nomor telepon tidak boleh kosong.';
        valid = false;
    } else if (isNaN(phone_number)) {
        document.querySelector('.error-phone_number').innerText = 'Nomor telepon harus berupa angka.';
        valid = false;
    }

    if (!valid) return;

    fetch('/api/toko', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Authorization': 'Bearer ' + localStorage.getItem('authToken')
        },
        body: JSON.stringify({
            name: name,
            namaPemilik: namaPemilik,
            address: address,
            phone_number: phone_number
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            for (const key in data.errors) {
                const errorElement = document.querySelector('.error-' + key);
                if (errorElement) {
                    errorElement.innerText = data.errors[key][0];
                }
            }
        } else {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('Tambahtoko'));
            modal.hide();

            // Clear form
            document.getElementById('formTambahToko').reset();

            // Refresh toko list
            if (typeof refreshTokoList === 'function') {
                refreshTokoList();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

document.querySelector('#Tambahtoko .btn-secondary').addEventListener('click', function () {
    // Reset form
    document.getElementById('formTambahToko').reset();

    // Hapus pesan error jika ada
    document.querySelectorAll('.text-danger').forEach(function(el) {
        el.innerText = '';
    });
});
</script>
