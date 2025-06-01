{{-- Modal Hapus Produk --}}
<div class="modal fade" id="Hapusproduk" tabindex="-1">
    <div class="modal-dialog">
        <form id="deleteProdukForm" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Hapus Produk</h5>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteProdukForm = document.querySelector('#deleteProdukForm');

    // Event delegation for deleteProduk buttons
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('deleteProduk')) {
            const id = event.target.dataset.id;
            const form = document.getElementById('deleteProdukForm');
            form.setAttribute('action', `http://127.0.0.1:8000/api/gudang/${id}`);
            // console.log('Selected product id for deletion:', id);
        }
    });

    // Saat submit form delete
    deleteProdukForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const url = this.getAttribute('action');

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Gagal menghapus produk');
                });
            }
            return response.json();
        })
        .then(data => {
            // alert(data.message || 'Produk berhasil dihapus');
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('Hapusproduk'));
            modal.hide();
            // Refresh data
            location.reload();
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });
});
</script>
