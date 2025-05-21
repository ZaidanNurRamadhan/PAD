<!-- resources/vue/components/modals/HapusKaryawan.vue -->
<template>
    <div class="modal fade show" id="HapusKaryawan" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content d-flex justify-content-center align-items-center">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Hapus Karyawan</h1>
          </header>
          <article class="modal-body">
            Anda yakin ingin menghapus informasi karyawan ini?
          </article>
          <footer class="modal-footer m-0 justify-content-center">
            <button
              type="button"
              style="width: 100px;"
              class="btn btn-secondary"
              @click="$emit('close')"
            >
              Batal
            </button>
            <button
              type="button"
              style="width: 100px;"
              class="btn btn-danger"
              @click="confirmDelete"
              :disabled="isLoading"
            >
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Ya
            </button>
          </footer>
        </main>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </template>

  <script>
  import { ref } from 'vue';

  export default {
    name: 'HapusKaryawanModal',
    props: {
      karyawan: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'delete'],
    setup(props, { emit }) {
      const isLoading = ref(false);

      // Konfirmasi dan proses penghapusan
      const confirmDelete = async () => {
        try {
          isLoading.value = true;

          // Panggil API untuk menghapus karyawan
          const token = localStorage.getItem('auth_token');
          const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
          const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;
          const headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          };
          if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
          }
          const response = await fetch(`http://127.0.0.1:8000/api/karyawan/${props.karyawan.id}`, {
            method: 'DELETE',
            headers: headers
          });

          if (!response.ok) {
            throw new Error('Gagal menghapus karyawan');
          }

          // Emit event delete untuk memberitahu komponen induk
          emit('delete', props.karyawan.id);

          // Tutup modal
          emit('close');
        } catch (error) {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menghapus karyawan');
        } finally {
          isLoading.value = false;
        }
      };

      return {
        isLoading,
        confirmDelete
      };
    }
  };
  </script>

  <style scoped>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
    background-color: rgba(0, 0, 0, 0.5);
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
