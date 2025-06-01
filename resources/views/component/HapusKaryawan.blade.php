<section class="modal fade" id="Hapuskaryawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
      <main class="modal-content d-flex justify-content-center align-items-center">
        <header class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Karyawan</h1>
        </header>
        <form id="deleteKaryawanForm" method="post">
            @csrf
            @method('DELETE')
            <article class="modal-body">
                Anda yakin ingin menghapus informasi karyawan ini?
            </article>
            <footer class="modal-footer m-0 justify-content-center">
                <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" style="width: 100px;" class="btn btn-danger">Ya</button>
            </footer>
        </form>
      </main>
    </div>
</section>
<script>
    let deleteId = null;

    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('Hapuskaryawan');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            deleteId = button.getAttribute('data-id');
        });
    });

    document.getElementById('deleteKaryawanForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var token = localStorage.getItem('authToken');
        if (!token) {
            alert('Authentication token not found. Please login again.');
            return;
        }

        fetch('http://127.0.0.1:8000/api/karyawan/' + deleteId, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.message || 'Gagal menghapus karyawan'); });
            }
            return response.json();
        })
        .then(data => {
            alert('Karyawan berhasil dihapus!');
            var modal = bootstrap.Modal.getInstance(document.getElementById('Hapuskaryawan'));
            modal.hide();
            location.reload();
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });
</script>
