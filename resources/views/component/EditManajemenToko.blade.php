<section class="modal fade" id="Edittoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Toko</h1>
            </header>
            <form id="edit-form" onsubmit="submitEditTokoForm(event)">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="toko-name" class="form-label">Nama Toko</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input type="text" id="toko-name" name="name" class="form-control" placeholder="Masukkan nama toko">
                                <small class="text-danger error-name" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="toko-pemilik" class="form-label">Nama Pemilik</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input type="text" id="toko-pemilik" name="namaPemilik" class="form-control" placeholder="Masukkan nama pemilik toko">
                                <small class="text-danger error-namaPemilik" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="toko-alamat" class="form-label">Alamat</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input type="text" id="toko-alamat" name="address" class="form-control" placeholder="Masukkan alamat toko">
                                <small class="text-danger error-address" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>

                    <section class="form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="toko-kontak" class="form-label">Kontak</label>
                            <div class="d-flex flex-column" style="width: 300px;">
                                <input type="text" id="toko-kontak" name="phone_number" class="form-control" placeholder="Masukkan kontak toko">
                                <small class="text-danger error-phone_number" style="font-size: 0.8rem"></small>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitEditToko" style="font-size: 0.8rem">Simpan</button>
                </div>
            </form>
        </main>
    </div>
</section>

<script>
    let currentId = null;

    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('Edittoko');

        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            currentId = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const pemilik = button.getAttribute('data-pemilik');
            const alamat = button.getAttribute('data-alamat');
            const phone_number = button.getAttribute('data-kontak');

            document.getElementById('toko-name').value = name;
            document.getElementById('toko-pemilik').value = pemilik;
            document.getElementById('toko-alamat').value = alamat;
            document.getElementById('toko-kontak').value = phone_number;

            document.querySelectorAll('.text-danger').forEach(function(errorElement) {
                errorElement.innerText = '';
            });
        });

        // Reset form saat tombol batal ditekan
        document.querySelector('#Edittoko .btn-secondary').addEventListener('click', function () {
            document.getElementById('edit-form').reset();
            document.querySelectorAll('.text-danger').forEach(function(el) {
                el.innerText = '';
            });
        });
    });

    function submitEditTokoForm(event) {
        event.preventDefault();

        var name = document.getElementById('toko-name').value.trim();
        var namaPemilik = document.getElementById('toko-pemilik').value.trim();
        var address = document.getElementById('toko-alamat').value.trim();
        var phone_number = document.getElementById('toko-kontak').value.trim();

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

        if (address === '') {
            document.querySelector('.error-address').innerText = 'Alamat tidak boleh kosong.';
            valid = false;
        }

        if (phone_number === '') {
            document.querySelector('.error-phone_number').innerText = 'Nomor telepon tidak boleh kosong.';
            valid = false;
        } else if (isNaN(phone_number)) {
            document.querySelector('.error-phone_number').innerText = 'Nomor telepon harus berupa angka.';
            valid = false;
        }

        if (!valid) return;

        fetch('/api/toko/' + currentId, {
            method: 'PUT',
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
                var modal = bootstrap.Modal.getInstance(document.getElementById('Edittoko'));
                modal.hide();
                document.getElementById('edit-form').reset();

                if (typeof refreshTokoList === 'function') {
                    refreshTokoList();
                } else {
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
