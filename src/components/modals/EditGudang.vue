<!-- resources/vue/components/modals/EditGudang.vue -->
<template>
    <div class="modal fade show" id="EditProduk" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <form @submit.prevent="submitForm" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Produk</h5>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="editName" class="form-label">Nama Produk</label>
              <input
                type="text"
                id="editName"
                v-model="formData.name"
                class="form-control"
                required
              >
            </div>
            <div class="mb-3">
              <label for="editHargaBeli" class="form-label">Harga Beli</label>
              <input
                type="number"
                id="editHargaBeli"
                v-model="formData.hargaBeli"
                class="form-control"
                required
              >
            </div>
            <div class="mb-3">
              <label for="editHargaJual" class="form-label">Harga Jual</label>
              <input
                type="number"
                id="editHargaJual"
                v-model="formData.hargaJual"
                class="form-control"
                required
              >
            </div>
            <div class="mb-3">
              <label for="editJumlahStok" class="form-label">Jumlah Stok</label>
              <input
                type="number"
                id="editJumlahStok"
                v-model="formData.jumlah"
                class="form-control"
                required
              >
            </div>
            <div class="mb-3">
              <label for="editAmbangKritis" class="form-label">Batas Kritis</label>
              <input
                type="number"
                id="editAmbangKritis"
                v-model="formData.batasKritis"
                class="form-control"
                required
              >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Simpan
            </button>
          </div>
        </form>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </template>

  <script>
  import { ref, onMounted, watch } from 'vue';

  export default {
    name: 'EditGudangModal',
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'update'],
    setup(props, { emit }) {
      // Data formulir
      const formData = ref({
        name: '',
        hargaBeli: '',
        hargaJual: '',
        jumlah: '',
        batasKritis: ''
      });

      // Status loading
      const isLoading = ref(false);

      // Isi formulir dengan data produk saat komponen dimount
      onMounted(() => {
        formData.value = {
          name: props.product.name,
          hargaBeli: props.product.hargaBeli,
          hargaJual: props.product.hargaJual,
          jumlah: props.product.jumlah,
          batasKritis: props.product.batasKritis
        };
      });

      // Pantau perubahan props untuk memperbarui formulir
      watch(() => props.product, (newProduct) => {
        formData.value = {
          name: newProduct.name,
          hargaBeli: newProduct.hargaBeli,
          hargaJual: newProduct.hargaJual,
          jumlah: newProduct.jumlah,
          batasKritis: newProduct.batasKritis
        };
      });

      // Kirim formulir
      const submitForm = () => {
        // Emit event update dengan data produk yang diperbarui
        emit('update', {
          id: props.product.id,
          name: formData.value.name,
          hargaBeli: formData.value.hargaBeli,
          hargaJual: formData.value.hargaJual,
          jumlah: formData.value.jumlah,
          batasKritis: formData.value.batasKritis
        });

        // Tutup modal
        emit('close');
      };

      return {
        formData,
        isLoading,
        submitForm
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
