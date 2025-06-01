<section class="modal fade" id="Tambahtoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Toko</h1>
            </header>
            <form id="formTambahToko" action="#" method="post">
                @csrf
                <article class="modal-body">
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="name">Nama Toko</label>
                            <div class="d-flex flex-column" style="width: 40vh;">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama toko">
                                <small style="font-size: 0.8rem" class="text-danger error-name"></small>
                            </div>
                        </div>
                    </section>
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="namaPemilik">Nama Pemilik</label>
                            <div class="d-flex flex-column" style="width:40vh;">
                                <input type="text" id="namaPemilik" name="namaPemilik" class="form-control" placeholder="Masukkan nama pemilik toko">
                                <small style="font-size: 0.8rem" class="text-danger error-namaPemilik"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="address">Alamat</label>
                            <input type="text" id="address" name="address" class="form-control" style="width: 40vh;" placeholder="Masukkan alamat toko">
                        </div>
                        <small class="text-danger error-address"></small>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="phone_number">Kontak</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" style="width: 40vh;" placeholder="Masukkan kontak toko">
                        </div>
                        <small class="text-danger error-phone_number"></small>
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitToko">Tambah</button>
                </footer>
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

    document.querySelectorAll('.text-danger').forEach(function(errorElement) {
        errorElement.innerText = '';
    });

    if (name === '') {
        document.querySelector('.error-name').innerText = 'Nama toko tidak boleh kosong.';
        valid = false;
    }

    if (namaPemilik === '') {
        document.querySelector('.error-namaPemilik').innerText = 'Nama pemilik tidak boleh kosong.';
        valid = false;
    }

    if (phone_number !== '' && isNaN(phone_number)) {
        document.querySelector('.error-phone_number').innerText = 'Nomor telepon harus berupa angka.';
        valid = false;
    }

    if (!valid) {
        return;
    }

    fetch('http://127.0.0.1:8000/api/toko', {
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
</script>
