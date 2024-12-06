<section class="modal fade" id="Hapustoko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog">
      <main class="modal-content d-flex justify-content-center align-items-center">
        <header class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
        </header>
        <form id="deleteTokoForm" method="post">
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
       </main>
    </div>
</section>
