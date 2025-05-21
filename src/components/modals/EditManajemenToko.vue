<!-- resources/vue/components/modals/EditManajemenToko.vue -->
<template>
    <div class="modal fade show" id="EditToko" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <main class="modal-content">
          <header class="modal-header">
            <h1 class="modal-title fs-5">Edit Toko</h1>
          </header>
          <form @submit.prevent="submitForm">
            <article class="modal-body">
              <section class="form-group d-flex justify-content-between px-3">
                <label for="toko-name">Nama Toko</label>
                <input
                  type="text"
                  id="toko-name"
                  v-model="formData.name"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan nama toko"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="toko-pemilik">Nama Pemilik</label>
                <input
                  type="text"
                  id="toko-pemilik"
                  v-model="formData.namaPemilik"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan nama pemilik toko"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="toko-alamat">Alamat</label>
                <input
                  type="text"
                  id="toko-alamat"
                  v-model="formData.address"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan alamat toko"
                  required
                >
              </section>

              <section class="form-group d-flex justify-content-between px-3 mt-4">
                <label for="toko-kontak">Kontak</label>
                <input
                  type="number"
                  id="toko-kontak"
                  v-model="formData.phone_number"
                  class="form-control"
                  style="max-width: 273px;"
                  placeholder="Masukkan kontak toko"
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
    name: 'EditManajemenTokoModal',
    props: {
      toko: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'update'],
    setup(props, { emit }) {
      // Data formulir
      const formData = ref({
        name: '',
        namaPemilik: '',
        address: '',
        phone_number: ''
      });

      // Status loading
      const isLoading = ref(false);

      // Isi formulir dengan data toko saat komponen dimount
      onMounted(() => {
        formData.value = {
          name: props.toko.name,
          namaPemilik: props.toko.namaPemilik,
          address: props.toko.address,
          phone_number: props.toko.phone_number
        };
      });

      // Pantau perubahan props untuk memperbarui formulir
      watch(() => props.toko, (newToko) => {
        formData.value = {
          name: newToko.name,
          namaPemilik: newToko.namaPemilik,
          address: newToko.address,
          phone_number: newToko.phone_number
        };
      });

      // Kirim formulir
      const submitForm = async () => {
        try {
          isLoading.value = true;

          // Panggil API untuk memperbarui toko
          const token = localStorage.getItem('auth_token');
          const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
          const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;
          const headers = {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          };
          if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
          }
          const response = await fetch(`http://127.0.0.1:8000/api/toko/${props.toko.id}`, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify({
              name: formData.value.name,
              namaPemilik: formData.value.namaPemilik,
              address: formData.value.address,
              phone_number: formData.value.phone_number
            })
          });

          if (!response.ok) {
            const errorText = await response.text();
            console.error('Update store failed:', errorText);
            throw new Error('Gagal memperbarui data toko');
          }

          const updatedToko = await response.json();

          // Emit event update dengan toko yang diperbarui
          emit('update', updatedToko);

          // Tutup modal
          emit('close');
        } catch (error) {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat memperbarui data toko');
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
