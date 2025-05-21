<!-- resources/vue/components/modals/EditKaryawan.vue -->
<template>
    <div class="modal fade show" id="EditKaryawan" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Edit Karyawan</h1>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </header>
          <form @submit.prevent="submitForm">
            <article class="modal-body">
              <section class="form-group d-flex justify-content-between px-3">
                <label for="karyawan-name">Nama Karyawan</label>
                <input
                  id="karyawan-name"
                  type="text"
                  v-model="formData.name"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan nama karyawan"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="karyawan-contact">Kontak</label>
                <input
                  id="karyawan-contact"
                  type="number"
                  v-model="formData.contact"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan kontak karyawan"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="karyawan-email">Email</label>
                <input
                  id="karyawan-email"
                  type="text"
                  v-model="formData.email"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan email"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4 position-relative w-auto">
                <label for="karyawan-password">Password</label>
                <input
                  id="karyawan-password"
                  :type="showPassword ? 'text' : 'password'"
                  v-model="formData.password"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan password"
                >
                <i
                  :class="['fa', showPassword ? 'fa-eye-slash' : 'fa-eye', 'position-absolute']"
                  style="top: 10px; right: 25px; cursor: pointer;"
                  @click="togglePassword"
                ></i>
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
  import { ref, onMounted, watch } from 'vue';

  export default {
    name: 'EditKaryawanModal',
    props: {
      karyawan: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'update'],
    setup(props, { emit }) {
      // Data formulir
      const formData = ref({
        name: '',
        contact: '',
        email: '',
        password: ''
      });

      // Status loading
      const isLoading = ref(false);

      // Toggle visibility password
      const showPassword = ref(false);

      // Isi formulir dengan data karyawan saat komponen dimount
      onMounted(() => {
        formData.value = {
          name: props.karyawan.name,
          contact: props.karyawan.contact,
          email: props.karyawan.email,
          password: '' // Password field kosong secara default
        };
      });

      // Pantau perubahan props untuk memperbarui formulir
      watch(() => props.karyawan, (newKaryawan) => {
        formData.value = {
          name: newKaryawan.name,
          contact: newKaryawan.contact,
          email: newKaryawan.email,
          password: '' // Password field kosong secara default
        };
      });

      // Toggle password visibility
      const togglePassword = () => {
        showPassword.value = !showPassword.value;
      };

      // Kirim formulir
      const submitForm = async () => {
        try {
          isLoading.value = true;

          // Siapkan data untuk dikirim
          const dataToSend = {
            name: formData.value.name,
            contact: formData.value.contact,
            email: formData.value.email
          };

          // Hanya tambahkan password jika diisi
          if (formData.value.password) {
            dataToSend.password = formData.value.password;
          }

          // Panggil API untuk memperbarui karyawan
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
            method: 'PUT',
            headers: headers,
            body: JSON.stringify(dataToSend)
          });

          if (!response.ok) {
            throw new Error('Gagal memperbarui data karyawan');
          }

          const updatedKaryawan = await response.json();

          // Emit event update dengan karyawan yang diperbarui
          emit('update', updatedKaryawan);

          // Tutup modal
          emit('close');
        } catch (error) {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat memperbarui data karyawan');
        } finally {
          isLoading.value = false;
        }
      };

      return {
        formData,
        isLoading,
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
  </style>
