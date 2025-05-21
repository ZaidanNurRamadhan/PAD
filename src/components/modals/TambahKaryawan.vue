<!-- resources/vue/components/modals/TambahKaryawan.vue -->
<template>
    <div class="modal fade show" id="TambahKaryawan" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Tambah Karyawan</h1>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </header>
          <form @submit.prevent="submitForm">
            <article class="modal-body">
              <section class="form-group px-3">
                <div class="d-flex justify-content-between">
                  <label for="name">Nama Karyawan</label>
                  <div class="d-flex flex-column">
                    <input
                      type="text"
                      v-model="formData.name"
                      class="form-control"
                      style="width:100%"
                      placeholder="Masukkan nama karyawan"
                    >
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.name }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group px-3 mt-4">
                <div class="d-flex justify-content-between">
                  <label for="contact">Kontak</label>
                  <div class="d-flex flex-column">
                    <input
                      type="text"
                      v-model="formData.contact"
                      class="form-control"
                      style="width:100%"
                      placeholder="Masukkan kontak karyawan"
                    >
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.contact }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group px-3 mt-4">
                <div class="d-flex justify-content-between">
                  <label for="email">Email</label>
                  <div class="d-flex flex-column">
                    <input
                      type="email"
                      v-model="formData.email"
                      class="form-control"
                      style="width:100%"
                      placeholder="Masukkan email"
                    >
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.email }}</small>
                  </div>
                </div>
              </section>

              <section class="form-group px-3 mt-4">
                <div class="d-flex justify-content-between">
                  <label for="password">Password</label>
                  <div class="d-flex flex-column position-relative">
                    <input
                      :type="showPassword ? 'text' : 'password'"
                      v-model="formData.password"
                      class="form-control"
                      style="width:100%"
                      placeholder="Masukkan password"
                    >
                    <i
                      :class="['fa', showPassword ? 'fa-eye-slash' : 'fa-eye', 'position-absolute']"
                      style="top: 10px; right: 10px; cursor: pointer;"
                      @click="togglePassword"
                    ></i>
                    <small style="font-size: 0.8rem" class="text-danger">{{ errors.password }}</small>
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

          <div v-if="successMessage" class="alert alert-success" role="alert">
            {{ successMessage }}
          </div>
        </main>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </template>

  <script>
  import { ref, reactive } from 'vue';

  export default {
    name: 'TambahKaryawanModal',
    emits: ['close', 'added'],
    setup(props, { emit }) {
      // Data formulir
      const formData = reactive({
        name: '',
        contact: '',
        email: '',
        password: ''
      });

      // Error messages
      const errors = reactive({
        name: '',
        contact: '',
        email: '',
        password: ''
      });

      // Status loading dan success
      const isLoading = ref(false);
      const successMessage = ref('');
      const showPassword = ref(false);

      // Toggle password visibility
      const togglePassword = () => {
        showPassword.value = !showPassword.value;
      };

      // Validate form
      const validateForm = () => {
        let valid = true;

        // Reset error messages
        Object.keys(errors).forEach(key => {
          errors[key] = '';
        });

        // Validate name
        if (!formData.name.trim()) {
          errors.name = 'Nama karyawan tidak boleh kosong.';
          valid = false;
        }

        // Validate contact
        if (!formData.contact.trim()) {
          errors.contact = 'Kontak tidak boleh kosong.';
          valid = false;
        } else if (isNaN(formData.contact.trim())) {
          errors.contact = 'Kontak harus berupa angka.';
          valid = false;
        }

        // Validate email
        if (!formData.email.trim()) {
          errors.email = 'Email tidak boleh kosong.';
          valid = false;
        } else if (!validateEmail(formData.email.trim())) {
          errors.email = 'Format email tidak valid.';
          valid = false;
        }

        // Validate password
        if (!formData.password.trim()) {
          errors.password = 'Password tidak boleh kosong.';
          valid = false;
        } else if (formData.password.trim().length < 8) {
          errors.password = 'Password harus memiliki minimal 8 karakter.';
          valid = false;
        }

        return valid;
      };

      // Helper function untuk validasi email
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

          // Panggil API untuk menambah karyawan
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
          const response = await fetch('http://127.0.0.1:8000/api/karyawan', {
            method: 'POST',
            headers: headers,
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

            throw new Error('Gagal menambahkan karyawan');
          }

          const newKaryawan = await response.json();

          // Tampilkan pesan sukses
          successMessage.value = 'Karyawan berhasil ditambahkan!';

          // Emit event added dengan karyawan yang baru ditambahkan
          emit('added', newKaryawan);

          // Reset form
          Object.keys(formData).forEach(key => {
            formData[key] = '';
          });

          // Tutup modal setelah jeda waktu
          setTimeout(() => {
            emit('close');
          }, 1500);
        } catch (error) {
          console.error('Error:', error);

          // Jika bukan error validasi, tampilkan alert
          if (error.message !== 'Validasi gagal') {
            alert('Terjadi kesalahan saat menambahkan karyawan');
          }
        } finally {
          isLoading.value = false;
        }
      };

      return {
        formData,
        errors,
        isLoading,
        successMessage,
        showPassword,
        togglePassword,
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

  .alert {
    margin: 1rem;
  }
  </style>
