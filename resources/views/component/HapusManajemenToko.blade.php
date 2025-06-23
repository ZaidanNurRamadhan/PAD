<section class="modal fade" id="Hapustoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
      <main class="modal-content d-flex justify-content-center align-items-center">
        <header class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
        </header>
<form id="deleteTokoForm" method="post" action="#" onsubmit="submitDeleteTokoForm(event)">
    @csrf
    @method('DELETE')
    <article class="modal-body justify-content-center">
        Anda yakin ingin menghapus toko ini?
    </article>
    <footer class="modal-footer m-0 justify-content-center">
        <button type="button" style="width: 100px;" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" style="width: 100px;" class="btn btn-danger">Ya</button>
      </footer>
</form>
<script>
    let deleteId = null;

    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('Hapustoko');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            deleteId = button.getAttribute('data-id');
        });
    });

    function submitDeleteTokoForm(event) {
        event.preventDefault();

        fetch('/api/toko/' + deleteId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            }
        })
        .then(response => response.json())
        .then(data => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('Hapustoko'));
            modal.hide();

            if (typeof refreshTokoList === 'function') {
                refreshTokoList();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
       </main>
    </div>
</section>
