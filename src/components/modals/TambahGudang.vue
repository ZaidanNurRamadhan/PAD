<!-- resources/vue/components/modals/TambahGudang.vue -->
<template>
  <div class="modal fade show" id="TambahGudang" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
      <main class="modal-content">
        <header class="modal-header">
          <h1 class="modal-title fs-5">Tambah Produk</h1>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </header>
        <form @submit.prevent="submitForm">
          <article class="modal-body">
            <section class="form-group px-3">
              <div class="d-flex justify-content-between">
                <label for="name">Nama Produk</label>
                <div class="d-flex flex-column" style="width: 60%">
                  <select
                    v-model="formData.name"
                    id="name"
                    class="form-control"
                    required
                  >
                    <option value="" disabled>Pilih Nama Produk</option>
                      <option
                      v-for="pemasok in pemasokList"
                        :key="pemasok.id"
                        :value="pemasok.produkDisediakan"
                      >
                        {{ pemasok.produkDisediakan }}
                      </option>
                  </select>
                  <small class="text-danger">{{ errors.name }}</small>
                </div>
              </div>
            </section>

            <section class="form-group px-3 mt-4">
              <div class="d-flex justify-content-between">
                <label for="hargaBeli">Harga Beli</label>
                <div class="d-flex flex-column" style="width: 60%">
                  <input
                    type="number"
                    v-model.number="formData.hargaBeli"
                    id="hargaBeli"
                    class="form-control"
                    placeholder="Masukkan harga beli"
                    required
                  />
                  <small class="text-danger">{{ errors.hargaBeli }}</small>
                </div>
              </div>
            </section>

            <section class="form-group px-3 mt-4">
              <div class="d-flex justify-content-between">
                <label for="hargaJual">Harga Jual</label>
                <div class="d-flex flex-column" style="width: 60%">
                  <input
                    type="number"
                    v-model.number="formData.hargaJual"
                    id="hargaJual"
                    class="form-control"
                    placeholder="Masukkan harga jual"
                    required
                  />
                  <small class="text-danger">{{ errors.hargaJual }}</small>
                </div>
              </div>
            </section>

            <section class="form-group px-3 mt-4">
              <div class="d-flex justify-content-between">
                <label for="jumlah">Stok</label>
                <div class="d-flex flex-column" style="width: 60%">
                  <input
                    type="number"
                    v-model.number="formData.jumlah"
                    id="jumlah"
                    class="form-control"
                    placeholder="Masukkan jumlah stok"
                    required
                  />
                  <small class="text-danger">{{ errors.jumlah }}</small>
                </div>
              </div>
            </section>

            <section class="form-group px-3 mt-4">
              <div class="d-flex justify-content-between">
                <label for="batasKritis">Batas Kritis</label>
                <div class="d-flex flex-column" style="width: 60%">
                  <input
                    type="number"
                    v-model.number="formData.batasKritis"
                    id="batasKritis"
                    class="form-control"
                    placeholder="Masukkan ambang kritis"
                    required
                  />
                  <small class="text-danger">{{ errors.batasKritis }}</small>
                </div>
              </div>
            </section>
          </article>

          <footer class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
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
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'TambahGudangModal',
  emits: ['close', 'added'],
  setup(props, { emit }) {
    const pemasokList = ref([]);

    // Fetching suppliers data from API
    const fetchPemasok = async () => {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.get('http://127.0.0.1:8000/api/gudang', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        const data = response.data;
        pemasokList.value = data.pemasoks;
        // console.log(pemasokList.value);
      } catch (error) {
        console.error('Error fetching pemasok data:', error);
      }
    };

    onMounted(() => {
      fetchPemasok();
    });

    // Data formulir
    const formData = reactive({
      name: '',
      hargaBeli: '',
      hargaJual: '',
      jumlah: '',
      batasKritis: ''
    });

    // Status loading
    const isLoading = ref(false);

    // Error messages
    const errors = reactive({
      name: '',
      hargaBeli: '',
      hargaJual: '',
      jumlah: '',
      batasKritis: ''
    });

    // Validate form
    const validateForm = () => {
      let valid = true;

      // Reset error messages
      Object.keys(errors).forEach(key => {
        errors[key] = '';
      });

      // Validate Nama Produk
      if (!formData.name.trim()) {
        errors.name = 'Nama produk tidak boleh kosong.';
        valid = false;
      }

      // Validate Harga Beli
      if (formData.hargaBeli === '' || formData.hargaBeli === null) {
        errors.hargaBeli = 'Harga beli tidak boleh kosong.';
        valid = false;
      } else if (isNaN(formData.hargaBeli)) {
        errors.hargaBeli = 'Harga beli harus berupa angka.';
        valid = false;
      }

      // Validate Harga Jual
      if (formData.hargaJual === '' || formData.hargaJual === null) {
        errors.hargaJual = 'Harga jual tidak boleh kosong.';
        valid = false;
      } else if (isNaN(formData.hargaJual)) {
        errors.hargaJual = 'Harga jual harus berupa angka.';
        valid = false;
      }

      // Validate Jumlah Stok
      if (formData.jumlah === '' || formData.jumlah === null) {
        errors.jumlah = 'Jumlah stok tidak boleh kosong.';
        valid = false;
      } else if (isNaN(formData.jumlah)) {
        errors.jumlah = 'Jumlah stok harus berupa angka.';
        valid = false;
      }

      // Validate Batas Kritis
      if (formData.batasKritis === '' || formData.batasKritis === null) {
        errors.batasKritis = 'Batas kritis tidak boleh kosong.';
        valid = false;
      } else if (isNaN(formData.batasKritis)) {
        errors.batasKritis = 'Batas kritis harus berupa angka.';
        valid = false;
      }

      return valid;
    };

    // Submit form
    const submitForm = () => {
      if (!validateForm()) {
        return;
      }

      // Emit event added dengan data produk baru
      emit('added', {
        name: formData.name,
        hargaBeli: formData.hargaBeli,
        hargaJual: formData.hargaJual,
        jumlah: formData.jumlah,
        batasKritis: formData.batasKritis
      });

      // Reset form
      Object.keys(formData).forEach(key => {
        formData[key] = '';
      });

      // Tutup modal
      emit('close');
    };

    return {
      formData,
      errors,
      isLoading,
      submitForm,
      pemasokList
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
