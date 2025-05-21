<template>
  <div v-if="isVisible" class="modal fade show" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
      <main class="modal-content">
        <header class="modal-header">
          <h1 class="modal-title fs-5">Tambah Transaksi</h1>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </header>
        <form @submit.prevent="addTransaction">
          <article class="modal-body">
            <!-- Form fields -->
            <section class="form-group d-flex justify-content-between px-3">
              <label for="toko_id">Nama Toko</label>
              <select
                v-model="formData.toko_id"
                class="form-control"
                style="width:60%;"
                required
              >
                <option value="">Pilih Toko</option>
                <option
                  v-for="toko in tokos"
                  :key="toko.id"
                  :value="toko.id"
                >
                  {{ toko.name }}
                </option>
              </select>
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="produk_id">Nama Produk</label>
              <select
                v-model="formData.produk_id"
                class="form-control"
                style="width:60%;"
                required
              >
                <option value="">Pilih Produk</option>
                <option
                  v-for="produk in produks"
                  :key="produk.id"
                  :value="produk.id"
                >
                  {{ produk.name }}
                </option>
              </select>
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="tanggal_keluar">Tanggal Keluar</label>
              <input
                type="date"
                v-model="formData.tanggal_keluar"
                class="form-control"
                style="width:60%;"
                required
              />
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="harga">Harga</label>
              <input
                type="number"
                v-model="formData.harga"
                class="form-control"
                style="width:60%;"
                placeholder="Masukkan harga"
                required
              />
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="jumlahDibeli">Jumlah</label>
              <input
                type="number"
                v-model="formData.jumlahDibeli"
                class="form-control"
                style="width:60%;"
                placeholder="Masukkan jumlah"
                required
              />
            </section>
          </article>

          <footer class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Tambah
            </button>
          </footer>
        </form>
      </main>
    </div>
    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'TambahTransaksi',
  props: {
    tokos: {
      type: Array,
      required: true
    },
    produks: {
      type: Array,
      required: true
    },
    isVisible: {
      type: Boolean,
      required: true
    }
  },
  emits: ['close', 'add-transaction'],
  setup(props, { emit }) {
    const formData = ref({
      toko_id: '',
      produk_id: '',
      tanggal_keluar: '',
      harga: '',
      jumlahDibeli: '',
      terjual: '',
      tanggal_retur: ''
    });

    const isLoading = ref(false);

    // Close modal
    const closeModal = () => {
      emit('close');
    };

    // Add transaction
    const addTransaction = async () => {
      try {
        isLoading.value = true;
        // Simulate API call to add transaction
        const newTransaction = { ...formData.value, id: Date.now() }; // Temporary ID
        emit('add-transaction', newTransaction);
        closeModal();
        // Reset form
        formData.value = {
          toko_id: '',
          produk_id: '',
          tanggal_keluar: '',
          harga: '',
          jumlahDibeli: '',
          terjual: '',
          tanggal_retur: ''
        };
      } catch (error) {
        console.error('Error:', error);
      } finally {
        isLoading.value = false;
      }
    };

    return {
      formData,
      isLoading,
      closeModal,
      addTransaction
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
