<section class="modal fade" id="Edittoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
        <main class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Toko</h1>
            </header>
            <form id="edit-form" method="post" action="#" onsubmit="submitEditTokoForm(event)">
                @csrf
                @method('PUT')
                <article class="modal-body">
                    <section class="form-group d-flex justify-content-between px-3">
                        <label for="toko-name">Nama Toko</label>
                        <input type="text" id="toko-name" name="tname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama toko">
                        <small class="text-danger error-name"></small>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-pemilik">Nama Pemilik</label>
                        <input type="text" id="toko-pemilik" name="pemilikname" class="form-control" style="max-width: 273px;" placeholder="Masukkan nama pemilik toko">
                        <small class="text-danger error-namaPemilik"></small>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-alamat">Alamat</label>
                        <input type="text" id="toko-alamat" name="alamat" class="form-control" style="max-width: 273px;" placeholder="Masukkan alamat toko">
                        <small class="text-danger error-address"></small>
                    </section>
                    <section class="form-group d-flex justify-content-between px-3 mt-4">
                        <label for="toko-kontak">Kontak</label>
                        <input type="number" id="toko-kontak" name="kontak" class="form-control" style="max-width: 273px;" placeholder="Masukkan kontak toko">
                        <small class="text-danger error-phone_number"></small>
                    </section>
                </article>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitEditToko">Simpan</button>
                </footer>
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

        if (phone_number !== '' && isNaN(phone_number)) {
            document.querySelector('.error-phone_number').innerText = 'Nomor telepon harus berupa angka.';
            valid = false;
        }

        if (!valid) {
            return;
        }

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

                if (typeof refreshTokoList === 'function') {
                    refreshTokoList();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
