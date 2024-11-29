<section class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center" id="logoutModalLabel">Konfirmasi Keluar</h5>
        </div>
        <div class="modal-body text-center">
          Apakah Anda yakin ingin keluar?
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmLogout" href="{{route('login')}}">Keluar</button>
        </div>
      </div>
    </div>
</section>
