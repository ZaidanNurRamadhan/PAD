<template>
  <section class="table-container d-flex flex-column min-vh-100 m-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="text-judul">Pemasok</h3>
      <button
        class="btn btn-primary btn-add"
        type="button"
        @click="openAddSupplierModal"
      >
        Tambah Pemasok
      </button>
    </div>

    <!-- Supplier Table -->
    <div class="table table-responsive flex-grow-1 table-data">
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Produk</th>
            <th>Kontak</th>
            <th>Email</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="paginatedSuppliers.length > 0">
            <tr v-for="supplier in paginatedSuppliers" :key="supplier.id">
              <td>{{ supplier.name }}</td>
              <td>{{ supplier.produkDisediakan }}</td>
              <td>{{ supplier.nomorTelepon }}</td>
              <td>{{ supplier.email }}</td>
              <td class="d-flex justify-content-center">
                <button class="btn btn-warning btn-sm mx-2" @click="openEditSupplierModal(supplier)">Edit</button>
                <button class="btn btn-danger btn-sm mx-2" @click="openDeleteSupplierModal(supplier)">Hapus</button>
              </td>
            </tr>
          </template>
          <tr v-else>
            <td colspan="5" class="text-center">Tidak ada data</td>
          </tr>
          <tr v-for="n in (9 - paginatedSuppliers.length)" :key="n">
            <td colspan="5"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between mt-3">
      <nav class="w-100">
        <ul class="pagination">
          <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
            <button class="page-link" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
              Previous
            </button>
          </li>
          <span>Page {{ currentPage }} of {{ totalPages }}</span>
          <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
            <button class="page-link" @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
              Next
            </button>
          </li>
        </ul>
      </nav>
    </div>

    <TambahPemasokModal
      v-if="newSupplierModalVisible"
      @close="closeAddSupplierModal"
      @added="handleAddedSupplier"
    />

    <EditPemasokModal
      v-if="editSupplierModalVisible"
      :pemasok="editedSupplier"
      @close="closeEditSupplierModal"
      @update="updateSupplier"
    />

    <HapusPemasokModal
      v-if="deleteSupplierModalVisible"
      :pemasok="supplierToDelete"
      @close="closeDeleteSupplierModal"
      @delete="handleDeletedSupplier"
    />
  </section>
</template>

<script>
import { ref, computed, reactive, onMounted } from 'vue';
import axios from 'axios';
import TambahPemasokModal from '@/components/modals/TambahPemasok.vue';
import EditPemasokModal from '@/components/modals/EditPemasok.vue';
import HapusPemasokModal from '@/components/modals/HapusPemasok.vue';
import { watch } from 'vue';

export default {
  name: 'SupplierManagement',
  components: {
    TambahPemasokModal,
    EditPemasokModal,
    HapusPemasokModal,
  },
  props: {
    searchTerm: {
      type: String,
      default: ''
    }
  },
  setup(props) {
    const suppliers = ref([]);
    const currentPage = ref(1);
    const itemsPerPage = ref(9);

    const newSupplierModalVisible = ref(false);
    const editedSupplier = reactive({ id: null, name: '', produkDisediakan: '', nomorTelepon: '', email: '' });
    const editSupplierModalVisible = ref(false);
    const supplierToDelete = reactive({ id: null, name: '', produkDisediakan: '', nomorTelepon: '', email: '' });
    const deleteSupplierModalVisible = ref(false);

    // Computed for pagination
    const totalPages = computed(() => Math.ceil(suppliers.value.length / itemsPerPage.value));
    const paginatedSuppliers = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      return suppliers.value.slice(start, start + itemsPerPage.value);
    });

    // Fetch suppliers from API
    const fetchSuppliers = async () => {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.get('http://127.0.0.1:8000/api/pemasok', {
          headers: {
            'Content-Type': 'application/json',
            'Accept' : 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        suppliers.value = response.data.data;
      } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat mengambil data pemasok');
      }
    };

    // Watch searchTerm prop to perform search
    watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'pemasok' },
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            },
          });
          suppliers.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
        } catch (error) {
          console.error('Error searching stores:', error);
        }
      } else {
        fetchSuppliers();
      }
    }, { immediate: true });

    // Page change method
    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
      }
    };

    // Handle added supplier event from modal
    const handleAddedSupplier = async (supplier) => {
      suppliers.value.push(supplier);  // Menambahkan pemasok baru secara langsung
      await fetchSuppliers();
      closeAddSupplierModal();
    };

    const updateSupplier = async (supplier) => {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/pemasok/${supplier.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
          },
          body: JSON.stringify(supplier),
        });
        if (!response.ok) {
          throw new Error('Gagal memperbarui pemasok');
        }
        const data = await response.json();
        const index = suppliers.value.findIndex(s => s.id === supplier.id);
        if (index !== -1) {
          suppliers.value[index] = data.data;
        }
        closeEditSupplierModal();
      } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat memperbarui pemasok');
      }
    };

    // Handle deleted supplier event from modal
    const handleDeletedSupplier = (deletedSupplierId) => {
      suppliers.value = suppliers.value.filter(s => s.id !== deletedSupplierId);
      closeDeleteSupplierModal();
    };

    // Modal methods
    const openAddSupplierModal = () => {
      newSupplierModalVisible.value = true;
    };

    const closeAddSupplierModal = () => {
      newSupplierModalVisible.value = false;
    };

    const openEditSupplierModal = (supplier) => {
      Object.assign(editedSupplier, supplier);
      editSupplierModalVisible.value = true;
    };

    const closeEditSupplierModal = () => {
      editSupplierModalVisible.value = false;
    };

    const openDeleteSupplierModal = (supplier) => {
      Object.assign(supplierToDelete, supplier);
      deleteSupplierModalVisible.value = true;
    };

    const closeDeleteSupplierModal = () => {
      deleteSupplierModalVisible.value = false;
    };

    // Lifecycle hook to fetch data
    onMounted(() => {
      fetchSuppliers();
    });

    return {
      suppliers,
      paginatedSuppliers,
      currentPage,
      totalPages,
      newSupplierModalVisible,
      editedSupplier,
      editSupplierModalVisible,
      supplierToDelete,
      deleteSupplierModalVisible,
      changePage,
      openAddSupplierModal,
      closeAddSupplierModal,
      openEditSupplierModal,
      closeEditSupplierModal,
      openDeleteSupplierModal,
      closeDeleteSupplierModal,
      updateSupplier,
      handleAddedSupplier,
      handleDeletedSupplier
    };
  },
};
</script>

<style scoped>
    @import '/src/assets/css/style.css';
    @import '/src/assets/css/layout.css';
</style>
