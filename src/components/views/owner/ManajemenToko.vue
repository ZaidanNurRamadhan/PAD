<template>
  <section class="table-container d-flex flex-column min-vh-100 m-2">
    <!-- Header -->
    <div class="d-flex justify-content-between mb-2 align-items-center">
      <h5 class="text-judul">Manajemen Toko</h5>
      <button
        class="btn btn-primary btn-tambah-toko"
        type="button"
        @click="showAddModal = true"
      >
        Tambah Toko
      </button>
    </div>

    <!-- Store Table -->
    <div class="table-responsive flex-grow-1 table-data">
      <table class="table">
        <thead>
          <tr>
            <th>Nama Toko</th>
            <th>Nama Pemilik</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="paginatedStores.length > 0">
            <tr v-for="toko in paginatedStores" :key="toko.id">
              <td>{{ toko.name }}</td>
              <td>{{ toko.namaPemilik }}</td>
              <td>{{ toko.address }}</td>
              <td>{{ toko.phone_number }}</td>
              <td class="d-flex justify-content-center">
                <button
                  class="btn btn-warning btn-sm mx-2"
                  type="button"
                  @click="openEditStoreModal(toko)"
                >
                  Edit
                </button>
                <button
                  class="btn btn-danger btn-sm mx-2"
                  type="button"
                  @click="openDeleteStoreModal(toko)"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </template>
          <tr v-else>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="n in (10 - paginatedStores.length)" :key="n">
              <td colspan="7"></td>
            </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between mt-3">
      <nav class="w-100">
        <ul class="pagination">
          <li
            class="page-item"
            :class="{ 'disabled': currentPage === 1 }"
          >
            <button
              class="page-link"
              @click="changePage(currentPage - 1)"
              :disabled="currentPage === 1"
            >
              Previous
            </button>
          </li>
          <span>Page {{ currentPage }} of {{ totalPages }}</span>
          <li
            class="page-item"
            :class="{ 'disabled': currentPage === totalPages }"
          >
            <button
              class="page-link"
              @click="changePage(currentPage + 1)"
              :disabled="currentPage === totalPages"
            >
              Next
            </button>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Imported Modals -->
    <TambahManajemenToko
      v-if="showAddModal"
      :new-store="newStore"
      @close="closeAddStoreModal"
      @added="addStore"
    />
    <EditManajemenToko
      v-if="showEditModal"
      :toko="editedStore"
      @close="closeEditStoreModal"
      @update="updateStore"
    />
    <HapusManajemenToko
      v-if="showDeleteModal"
      :toko="storeToDelete"
      @close="closeDeleteStoreModal"
      @delete="deleteStore"
    />
  </section>
</template>

<script>
import { ref, reactive, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import TambahManajemenToko from '@/components/modals/TambahManajemenToko.vue'
import EditManajemenToko from '@/components/modals/EditManajemenToko.vue'
import HapusManajemenToko from '@/components/modals/HapusManajemenToko.vue'

export default {
  name: 'ManajemenToko',
  components: {
    TambahManajemenToko,
    EditManajemenToko,
    HapusManajemenToko
  },
  props: {
    searchTerm: {
      type: String,
      default: ''
    }
  },
  setup(props) {
    const stores = ref([]) // State for stores
    const currentPage = ref(1)
    const itemsPerPage = ref(9)

    // Modal visibility state
    const showAddModal = ref(false)
    const showEditModal = ref(false)
    const showDeleteModal = ref(false)

    // Store forms
    const newStore = reactive({
      name: '',
      namaPemilik: '',
      address: '',
      phone_number: ''
    })

    const editedStore = reactive({
      id: null,
      name: '',
      namaPemilik: '',
      address: '',
      phone_number: ''
    })

    const storeToDelete = ref({})

    // Computed pagination
    const totalPages = computed(() => {
      return Math.ceil(stores.value.length / itemsPerPage.value)
    })

    const paginatedStores = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return stores.value.slice(start, end)
    })

    // Fetch data from API
    const fetchStores = async () => {
      try {
        const token = localStorage.getItem('auth_token')
        const response = await axios.get('http://127.0.0.1:8000/api/toko', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        })
        stores.value = response.data.data
      } catch (error) {
        console.error('Error fetching stores:', error)
      }
    }

    // Lifecycle hook to fetch stores on mounted
    onMounted(() => {
      fetchStores()
    })

    // Watch searchTerm prop to perform search
    watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'manajemen-toko' },
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            },
          });
          stores.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
        } catch (error) {
          console.error('Error searching stores:', error);
        }
      } else {
        fetchStores();
      }
    }, { immediate: true });

    // Pagination methods
    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
      }
    }

    // Modal open/close methods
    const openAddStoreModal = () => {
      showAddModal.value = true
    }

    const closeAddStoreModal = () => {
      showAddModal.value = false
      // Reset form
      newStore.name = ''
      newStore.namaPemilik = ''
      newStore.address = ''
      newStore.phone_number = ''
    }

    const openEditStoreModal = (store) => {
      Object.assign(editedStore, store)
      showEditModal.value = true
    }

    const closeEditStoreModal = () => {
      showEditModal.value = false
    }

    const openDeleteStoreModal = (store) => {
      storeToDelete.value = store
      showDeleteModal.value = true
    }

    const closeDeleteStoreModal = () => {
      showDeleteModal.value = false
    }

    const addStore = (newToko) => {
      stores.value.push(newToko.data)
      fetchStores()
      closeAddStoreModal()
    }

    const updateStore = (updatedToko) => {
      const index = stores.value.findIndex(s => s.id === updatedToko.data.id)
      if (index !== -1) {
        stores.value[index] = updatedToko.data
      }
      closeEditStoreModal()
    }

    const deleteStore = (deletedId) => {
      stores.value = stores.value.filter(s => s.id !== deletedId)
      closeDeleteStoreModal()
    }

    return {
      stores,
      currentPage,
      itemsPerPage,
      showAddModal,
      showEditModal,
      showDeleteModal,
      newStore,
      editedStore,
      storeToDelete,
      totalPages,
      paginatedStores,
      changePage,
      openAddStoreModal,
      closeAddStoreModal,
      openEditStoreModal,
      closeEditStoreModal,
      openDeleteStoreModal,
      closeDeleteStoreModal,
      addStore,
      updateStore,
      deleteStore
    }
  }
}
</script>
<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>