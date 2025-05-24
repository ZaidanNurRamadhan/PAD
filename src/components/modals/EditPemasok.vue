<!-- resources/vue/components/modals/EditPemasok.vue -->
<template>
    <div class="modal fade show" id="EditPemasok" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Edit Pemasok</h1>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </header>
          <form @submit.prevent="submitForm">
            <article class="modal-body">
              <section class="form-group d-flex justify-content-between px-3">
                <label for="pemasok-name">Nama Pemasok</label>
                <input
                  type="text"
                  id="pemasok-name"
                  v-model="formData.name"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan nama pemasok"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="pemasok-produk">Produk</label>
                <input
                  type="text"
                  id="pemasok-produk"
                  v-model="formData.produkDisediakan"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan nama produk"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="pemasok-kontak">Kontak</label>
                <input
                  type="text"
                  id="pemasok-kontak"
                  v-model="formData.nomorTelepon"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan kontak pemasok"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="pemasok-email">Email</label>
                <input
                  type="email"
                  id="pemasok-email"
                  v-model="formData.email"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan email pemasok"
                  required
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
  import { ref, onMounted, watch } from 'vue';

  export default {
    name: 'EditPemasokModal',
    props: {
      pemasok: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'update'],
    setup(props, { emit }) {
      // Data formulir
      const formData = ref({
        name: '',
        produkDisediakan: '',
        nomorTelepon: '',
        email: ''
      });

      // Status loading
      const isLoading = ref(false);

      // Isi formulir dengan data pemasok saat komponen dimount
      onMounted(() => {
        formData.value = {
          name: props.pemasok.name,
          produkDisediakan: props.pemasok.produkDisediakan,
          nomorTelepon: props.pemasok.nomorTelepon,
          email: props.pemasok.email
        };
      });

      // Pantau perubahan props untuk memperbarui formulir
      watch(() => props.pemasok, (newPemasok) => {
        formData.value = {
          name: newPemasok.name,
          produkDisediakan: newPemasok.produkDisediakan,
          nomorTelepon: newPemasok.nomorTelepon,
          email: newPemasok.email
        };
      });

      // Kirim formulir
      const submitForm = async () => {
        try {
          isLoading.value = true;

          // Panggil API untuk memperbarui pemasok
          const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
          const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;
          const headers = {
            'Content-Type' : 'application/json',
            'Authorization' : 'Bearer ' + localStorage.getItem('auth_token')
            };
            if (csrfToken){
              headers['X-CSRF-TOKEN'] = csrfToken
            }
          const response = await fetch(`http://127.0.0.1:8000/api/pemasok/${props.pemasok.id}`, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify({
              name: formData.value.name,
              produkDisediakan: formData.value.produkDisediakan,
              nomorTelepon: formData.value.nomorTelepon,
              email: formData.value.email
            })
          });

          if (!response.ok) {
            throw new Error('Gagal memperbarui data pemasok');
          }

          const updatedPemasok = await response.json();

          // Emit event update dengan pemasok yang diperbarui
          emit('update', updatedPemasok.data);

          // Tutup modal
          emit('close');
        } catch (error) {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat memperbarui data pemasok');
        } finally {
          isLoading.value = false;
        }
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
