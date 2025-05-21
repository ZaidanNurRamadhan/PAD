<!-- resources/vue/components/modals/HapusGudang.vue -->
<template>
    <div class="modal fade show" id="HapusProduk" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hapus Produk</h5>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </div>
          <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus produk ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
            <button
              type="button"
              class="btn btn-danger"
              @click="confirmDelete"
              :disabled="isLoading"
            >
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Ya
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
    name: 'HapusGudangModal',
    props: {
      produk: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'delete'],
    setup(props, { emit }) {
      const isLoading = ref(false);

      // Konfirmasi dan proses penghapusan
      const confirmDelete = () => {
        isLoading.value = true;
        // Emit event product-deleted untuk memberitahu komponen induk
        emit('product-deleted', props.produk.id);

        // Tutup modal
        emit('close');
        isLoading.value = false;
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
