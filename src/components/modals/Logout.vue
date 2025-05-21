<template>
  <div class="modal fade show" id="logoutModal" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center">Konfirmasi Keluar</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body text-center">
          Apakah Anda yakin ingin keluar?
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">
            Batal
          </button>
          <button
            type="button"
            class="btn btn-danger"
            @click="prosesLogout"
            :disabled="isLoading"
          >
            <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
            Keluar
          </button>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'LogoutModal',
  emits: ['close', 'logout'],
  setup(_, { emit }) {
    const isLoading = ref(false);

    const prosesLogout = async () => {
      try {
        isLoading.value = true;

        // Simulasi logout (opsional: panggil API di sini jika ada backend)
        await new Promise(resolve => setTimeout(resolve, 1000));

        emit('logout');
      } catch (error) {
        console.error('Logout error:', error);
        alert('Gagal logout!');
        emit('close');
      } finally {
        isLoading.value = false;
      }
    };

    return {
      isLoading,
      prosesLogout,
    };
  },
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 200px;
  left: 0;
  z-index: 1050;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
  /* background-color: rgba(0, 0, 0, 0.5); */
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  z-index: -1;
  width: 100vw;
  height: 100vh;
}
</style>
