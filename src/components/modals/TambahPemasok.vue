<!-- resources/vue/components/modals/TambahPemasok.vue -->
<template>
    <div class="modal fade show" id="TambahPemasok" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Tambah Pemasok</h1>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </header>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="name" class="form-label">Nama Pemasok</label>
                  <div class="d-flex flex-column">
                    <input
                      style="width:100%"
                      type="text"
                      v-model="formData.name"
                      class="form-control"
                    >
                    <small class="text-danger" style="font-size: 0.8rem">{{ errors.name }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="produkDisediakan" class="form-label">Produk</label>
                  <div class="d-flex flex-column">
                    <input
                      style="width:100%"
                      type="text"
                      v-model="formData.produkDisediakan"
                      class="form-control"
                    >
                    <small class="text-danger" style="font-size: 0.8rem">{{ errors.produkDisediakan }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                  <div class="d-flex flex-column">
                    <input
                      style="width:100%"
                      type="text"
                      v-model="formData.nomorTelepon"
                      class="form-control"
                    >
                    <small class="text-danger" style="font-size: 0.8rem">{{ errors.nomorTelepon }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label for="email" class="form-label">Email</label>
                  <div class="d-flex flex-column">
                    <input
                      style="width:100%"
                      type="email"
                      v-model="formData.email"
                      class="form-control"
                    >
                    <small class="text-danger" style="font-size: 0.8rem">{{ errors.email }}</small>
                  </div>
                </div>
              </section>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
              <button
                type="submit"
                class="btn btn-primary"
                style="font-size: 0.8rem"
                :disabled="isLoading"
              >
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Tambah
              </button>
            </div>
          </form>
        </main>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </template>

  <script>
  import { ref, reactive } from 'vue';

  export default {
    name: 'TambahPemasokModal',
    emits: ['close', 'added', 'submit'],
    setup(props, { emit }) {
      // Data formulir
      const formData = reactive({
        name: '',
        produkDisediakan: '',
        nomorTelepon: '',
        email: ''
      });

      // Error messages
      const errors = reactive({
        name: '',
        produkDisediakan: '',
        nomorTelepon: '',
        email: ''
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

        // Validate name (required and no numbers)
        if (!formData.name.trim()) {
          errors.name = 'Nama pemasok tidak boleh kosong.';
          valid = false;
        } else if (/\d/.test(formData.name)) {
          errors.name = 'Nama pemasok tidak boleh mengandung angka.';
          valid = false;
        }

        // Validate produkDisediakan (required and no numbers)
        if (!formData.produkDisediakan.trim()) {
          errors.produkDisediakan = 'Produk yang disediakan tidak boleh kosong.';
          valid = false;
        } else if (/\d/.test(formData.produkDisediakan)) {
          errors.produkDisediakan = 'Produk tidak boleh mengandung angka.';
          valid = false;
        }

        // Validate nomorTelepon (required and must be numeric)
        if (!formData.nomorTelepon.trim()) {
          errors.nomorTelepon = 'Nomor telepon tidak boleh kosong.';
          valid = false;
        } else if (isNaN(formData.nomorTelepon.trim())) {
          errors.nomorTelepon = 'Nomor telepon harus berupa angka.';
          valid = false;
        }

        // Validate email (required and must be valid format)
        if (!formData.email.trim()) {
          errors.email = 'Email tidak boleh kosong.';
          valid = false;
        } else if (!validateEmail(formData.email.trim())) {
          errors.email = 'Format email tidak valid.';
          valid = false;
        }

        return valid;
      };

      // Helper function to validate email
      const validateEmail = (email) => {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
      };

      // Submit form
      const submitForm = async () => {
        if (!validateForm()) {
          return;
        }

        try {
          isLoading.value = true;

          // Panggil API untuk menambah pemasok
          const response = await fetch('http://127.0.0.1:8000/api/pemasok', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '',
              'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
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

            throw new Error('Gagal menambahkan pemasok');
          }

          const newPemasok = await response.json();

          // Emit event added dengan pemasok yang baru ditambahkan
          emit('added', newPemasok.data ? newPemasok.data : newPemasok);

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
            alert('Terjadi kesalahan saat menambahkan pemasok');
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
