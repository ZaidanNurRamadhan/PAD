<!-- resources/vue/components/modals/TambahManajemenToko.vue -->
<template>
    <div class="modal fade show" id="TambahToko" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Tambah Toko</h1>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </header>
          <form @submit.prevent="submitForm">
            <article class="modal-body">
              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="name">Nama Toko</label>
                  <div class="d-flex flex-column" style="width: 40vh;">
                    <input
                      type="text"
                      v-model="formData.name"
                      class="form-control"
                      placeholder="Masukkan nama toko"
                    >
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.name }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="namaPemilik">Nama Pemilik</label>
                  <div class="d-flex flex-column" style="width:40vh;">
                    <input
                      type="text"
                      v-model="formData.namaPemilik"
                      class="form-control"
                      placeholder="Masukkan nama pemilik toko"
                    >
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.namaPemilik }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="address">Alamat</label>
                  <div class="d-flex flex-column" style="width: 40vh;">
                    <input
                      type="text"
                      v-model="formData.address"
                      class="form-control"
                      placeholder="Masukkan alamat toko"
                    >
                    <small class="text-danger">{{ errors.address }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="phone_number">Kontak</label>
                  <div class="d-flex flex-column" style="width: 40vh;">
                    <input
                      type="text"
                      v-model="formData.phone_number"
                      class="form-control"
                      placeholder="Masukkan kontak toko"
                    >
                    <small class="text-danger">{{ errors.phone_number }}</small>
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
  import { ref, reactive } from 'vue';

  export default {
    name: 'TambahManajemenTokoModal',
    emits: ['close', 'added'],
    setup(props, { emit }) {
      // Data formulir
      const formData = reactive({
        name: '',
        namaPemilik: '',
        address: '',
        phone_number: ''
      });

      // Error messages
      const errors = reactive({
        name: '',
        namaPemilik: '',
        address: '',
        phone_number: ''
      });

      // Status loading
      const isLoading = ref(false);

      // Validate form
      const validateForm = () => {
        let valid = true;

        // Reset error messages
        Object.keys(errors).forEach(key => {
          errors[key] = '';
        });

        // Validate nama toko
        if (!formData.name.trim()) {
          errors.name = 'Nama toko tidak boleh kosong.';
          valid = false;
        }

        // Validate nama pemilik
        if (!formData.namaPemilik.trim()) {
          errors.namaPemilik = 'Nama pemilik tidak boleh kosong.';
          valid = false;
        }

        // Validate alamat (optional validation)
        if (!formData.address.trim()) {
          errors.address = 'Alamat tidak boleh kosong.';
          valid = false;
        }

        // Validate kontak
        if (!formData.phone_number.trim()) {
          errors.phone_number = 'Kontak tidak boleh kosong.';
          valid = false;
        } else if (isNaN(formData.phone_number.trim())) {
          errors.phone_number = 'Nomor telepon harus berupa angka.';
          valid = false;
        }

        return valid;
      };

      // Submit form
      const submitForm = async () => {
        if (!validateForm()) {
          return;
        }

        try {
          isLoading.value = true;

          // Panggil API untuk menambah toko
          const token = localStorage.getItem('auth_token')
          const response = await fetch('http://127.0.0.1:8000/api/toko', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept' : 'application/json',
              'Authorization' : 'Bearer ' + token,
            },
            body: JSON.stringify(formData)
          });

          if (!response.ok) {
            const errorData = await response.json();

            // Handle validation errors from server
            if (errorData.errors) {
              Object.keys(errorData.errors).forEach(key => {
                errors[key] = errorData.errors[key][0];
              });
              throw new Error('Validasi gagal');
            }

            throw new Error('Gagal menambahkan toko');
          }

          const newToko = await response.json();

          // Emit event added dengan toko yang baru ditambahkan
          emit('added', newToko);

          // Reset form
          Object.keys(formData).forEach(key => {
            formData[key] = '';
          });

          // Tutup modal
          emit('close');
        } catch (error) {
          console.error('Error:', error);

          // Jika bukan error validasi, tampilkan alert
          if (error.message !== 'Validasi gagal') {
            alert('Terjadi kesalahan saat menambahkan toko');
          }
        } finally {
          isLoading.value = false;
        }
      };

      return {
        formData,
        errors,
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
