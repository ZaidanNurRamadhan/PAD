<template>
  <div class="modal fade show" id="EditTransaksi" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
      <main class="modal-content">
        <header class="modal-header">
          <h1 class="modal-title fs-5">Edit Transaksi</h1>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </header>
        <form @submit.prevent="submitForm">
          <article class="modal-body">
            <section class="form-group d-flex justify-content-between px-3">
              <label for="toko_id">Nama Toko</label>
              <select
                id="toko_id"
                v-model="formData.toko_id"
                class="form-control"
                style="max-width: 273px;"
                required
              >
                <option v-for="toko in tokos" :key="toko.id" :value="toko.id">
                  {{ toko.name }}
                </option>
              </select>
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="produk_id">Nama Produk</label>
              <select
                id="produk_id"
                v-model="formData.produk_id"
                class="form-control"
                style="max-width: 273px;"
                required
              >
                <option v-for="produk in produks" :key="produk.id" :value="produk.id">
                  {{ produk.name }}
                </option>
              </select>
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="tanggal_keluar">Tanggal Keluar</label>
              <input
                type="date"
                id="tanggal_keluar"
                v-model="formData.tanggal_keluar"
                class="form-control"
                style="max-width: 273px;"
                required
              >
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="harga">Harga</label>
              <input
                type="number"
                id="harga"
                v-model="formData.harga"
                class="form-control"
                style="max-width: 273px;"
                placeholder="Masukkan harga"
                required
              >
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="jumlahDibeli">Jumlah</label>
              <input
                type="number"
                id="jumlahDibeli"
                v-model="formData.jumlahDibeli"
                class="form-control"
                style="max-width: 273px;"
                placeholder="Masukkan jumlah"
                required
              >
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="terjual">Terjual</label>
              <input
                type="number"
                id="terjual"
                v-model="formData.terjual"
                class="form-control"
                style="max-width: 273px;"
                placeholder="Masukkan produk terjual"
                required
              >
            </section>

            <section class="form-group d-flex justify-content-between px-3 mt-4">
              <label for="tanggal_retur">Tanggal Retur</label>
              <input
                type="date"
                id="tanggal_retur"
                v-model="formData.tanggal_retur"
                class="form-control"
                style="max-width: 273px;"
              >
            </section>
          </article>

          <footer class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Simpan
            </button>
          </footer>
        </form>
      </main>
    </div>
    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import { ref, watch, reactive } from 'vue';

export default {
  name: 'EditTransaksiModal',
  props: {
    transaksi: {
      type: Object,
      required: true
    },
    tokos: {
      type: Array,
      required: true
    },
    produks: {
      type: Array,
      required: true
    }
  },
  emits: ['close', 'update'],
  setup(props, { emit }) {
    const isLoading = ref(false);

    const formData = reactive({
      id: '',
      toko_id: '',
      produk_id: '',
      jumlahDibeli: '',
      terjual: '',
      harga: '',
      total_harga: '',
      tanggal_keluar: '',
      tanggal_retur: '',
    });

    // Watch perubahan props.transaksi dan update formData
    watch(
      () => props.transaksi,
      (newVal) => {
        if (newVal) {
          formData.id = newVal.id;
          formData.toko_id = newVal.toko_id;
          formData.produk_id = newVal.produk_id;
          formData.jumlahDibeli = newVal.jumlahDibeli;
          formData.terjual = newVal.terjual;
          formData.harga = newVal.harga;
          formData.total_harga = newVal.total_harga;
          formData.tanggal_keluar = formatDate(newVal.tanggal_keluar);
          formData.tanggal_retur = newVal.tanggal_retur ? formatDate(newVal.tanggal_retur) : '';
        }
      },
      { immediate: true, deep: true }
    );

    function formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }


    const submitForm = () => {
      isLoading.value = true;

      // Hitung total_harga
      formData.total_harga = Number(formData.harga) * Number(formData.jumlahDibeli);

      // Emit update ke parent
      emit('update', { ...formData });

      setTimeout(() => {
        isLoading.value = false;
      }, 500); // simulasikan loading
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
