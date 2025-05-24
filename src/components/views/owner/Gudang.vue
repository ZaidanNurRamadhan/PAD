<template>
  <div class="container-fluid p-0">
    <!-- Stock Summary Section -->
    <section class="table-container h-auto p-4 mx-2">
      <h3 class="text-center">Stok Keseluruhan</h3>
      <div class="row mt-4">
        <div class="col text-center">
          <h5 class="fw-semibold" style="color: #1570EF">Kategori</h5>
          <p class="fw-semibold">{{ kategoriesCount }}</p>
        </div>
        <div class="col text-center">
          <h5 class="fw-semibold" style="color: #E19133">Total Produk</h5>
          <p class="fw-semibold">{{ totalProdukCount }}</p>
        </div>
        <div class="col text-center">
          <h5 class="fw-semibold" style="color: #F36960">Produk Menipis</h5>
          <p class="fw-semibold">{{ lowStockProdukCount }}</p>
        </div>
      </div>
    </section>

    <!-- Product Management Section -->
    <section class="mt-4 p-4 h-auto d-flex justify-content-between flex-column table-container">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Produk</h5>
        <button
          type="button"
          class="btn btn-primary"
          @click="openAddProductModal"
        >
          Tambah Produk
        </button>
      </div>

      <div class="table table-responsive flex-grow-1 table-data">
        <table class="table">
          <thead style="z-index: 1500">
            <tr>
              <th>ID</th>
              <th>Produk</th>
              <th>Harga Beli</th>
              <th>Harga Jual</th>
              <th>Stok</th>
              <th>Batas Kritis</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="paginatedProduks.length > 0">
              <tr v-for="(produk, index) in paginatedProduks" :key="produk.id">
                <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                <td>{{ produk.name }}</td>
                <td>{{ formatCurrency(produk.hargaBeli) }}</td>
                <td>{{ formatCurrency(produk.hargaJual) }}</td>
                <td>{{ produk.jumlah }}</td>
                <td>{{ produk.batasKritis }} Packets</td>
                <td class="justify-content-center d-flex">
                  <button
                    class="m-2 btn btn-warning btn-sm edit-btn"
                    @click="openEditProductModal(produk)"
                  >
                    Edit
                  </button>
                  <button
                    class="m-2 btn btn-danger btn-sm"
                    @click="openDeleteProductModal(produk)"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
            </template>
            <tr v-else>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="n in (10 - produks.length)" :key="n">
              <td colspan="7"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        <nav class="w-100">
          <ul class="pagination">
            <!-- Previous Button -->
            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
              <button
                class="page-link"
                @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1"
              >
                Prev
              </button>
            </li>

              <span>Page {{ currentPage }} of {{ totalPages }}</span>
            
            <!-- Next Button -->
            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
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

    </section>
  </div>

  <!-- Add Product Modal -->
  <TambahGudang
    v-if="isAddModalVisible"
    :pemasokList="pemasokList"
    :productOption="productOption"
    @close="closeAddProductModal"
    @added="handleProductAdded"
  />

  <!-- Edit Product Modal -->
  <EditGudang
    v-if="isEditModalVisible"
    :product="editedProduct"
    @close="closeEditProductModal"
    @update="handleProductUpdated"
  />

  <!-- Delete Product Modal -->
  <HapusGudang
    v-if="isDeleteModalVisible"
    :produk="productToDelete"
    @close="closeDeleteProductModal"
    @product-deleted="handleProductDeleted"
  />
</template>

<script>
import { ref, computed, reactive, onMounted, watch } from 'vue'
import axios from 'axios'
import TambahGudang from '@/components/modals/TambahGudang.vue'
import EditGudang from '@/components/modals/EditGudang.vue'
import HapusGudang from '@/components/modals/HapusGudang.vue'

export default {
  name: 'OwnerStockManagement',
  props: {
    initialProduks: {
      type: Array,
      default: () => []
    },
    initialPemasoks: {
      type: Array,
      default: () => []
    },
    searchTerm: {
      type: String,
      default: ''
    }
  },
  components: {
    TambahGudang,
    EditGudang,
    HapusGudang
  },
  setup(props) {
    // Reactive state
    const produks = ref(props.initialProduks)
    const currentPage = ref(1)
    const itemsPerPage = ref(9)

    // Supplier list state
    const pemasokList = ref(props.initialPemasoks)

    // Product options for TambahGudang modal
    const productOption = computed(() => {
      // Flatten all produkDisediakan arrays from pemasokList into one array
      return pemasokList.value.flatMap(pemasok => pemasok.produkDisediakan || [])
    })

    // Modal visibility state
    const isAddModalVisible = ref(false)
    const isEditModalVisible = ref(false)
    const isDeleteModalVisible = ref(false)

    // Product forms
    const newProduct = reactive({
      name: '',
      hargaBeli: '',
      hargaJual: '',
      jumlah: '',
      batasKritis: ''
    })

    const editedProduct = reactive({
      id: null,
      name: '',
      hargaBeli: '',
      hargaJual: '',
      jumlah: '',
      batasKritis: ''
    })

    const productToDelete = ref(null)

    // Fetching products data from API
    const fetchProduks = async () => {
      try {
        const token = localStorage.getItem('auth_token');  // Ambil token dari localStorage

        const response = await axios.get('http://127.0.0.1:8000/api/gudang', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,  // Menambahkan Bearer token ke header
          },
        });

        const data = response.data;

        // Update data produk jika berhasil
        produks.value = Array.isArray(data.produks) ? data.produks : (data.data || []);
      } catch (error) {
        if (error.response) {
          console.error('Error fetching produk data:', error.response.data.message || 'Tidak dapat mengambil data produk');
        } else {
          console.error('Error fetching produk data:', error.message);
        }
      }
    };

    // Fetching suppliers data from API
    const fetchPemasok = async () => {
      try {
        const token = localStorage.getItem('auth_token');
        // Corrected API endpoint for pemasok
        const response = await axios.get('http://127.0.0.1:8000/api/gudang', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        const data = response.data;
        pemasokList.value = data.pemasoks || [];
      } catch (error) {
        console.error('Error fetching pemasok data:', error);
      }
    };

    // Watch searchTerm prop to perform search
      watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'gudang-owner' },
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            },
          });
          // Assign the paginated produk data from response
          produks.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
        } catch (error) {
          console.error('Error searching produk:', error);
        }
      } else {
        // If search term is empty, fetch all produk
        fetchProduks();
      }
    }, { immediate: true });

    onMounted(() => {
      fetchProduks()
      fetchPemasok()
    })

    // Computed properties for summary
    const kategoriesCount = computed(() => {
      return new Set(produks.value.map(p => p.name)).size
    })

    const totalProdukCount = computed(() => {
      return produks.value.filter(p => p.jumlah > 0).length
    })

    const lowStockProdukCount = computed(() => {
      return produks.value.filter(p => p.batasKritis > p.jumlah).length
    })

    // Computed pagination
    const totalPages = computed(() => {
      return Math.ceil(produks.value.length / itemsPerPage.value)
    })

    // Pagination slice
    const paginatedProduks = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return produks.value.slice(start, end)
    })

    // Methods
    const formatCurrency = (value) => {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      }).format(value)
    }

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
      }
    }

    // Modal methods
    const openAddProductModal = () => {
      isAddModalVisible.value = true
    }

    const closeAddProductModal = () => {
      isAddModalVisible.value = false
      // Reset form
      newProduct.name = ''
      newProduct.hargaBeli = ''
      newProduct.hargaJual = ''
      newProduct.jumlah = ''
      newProduct.batasKritis = ''
    }

    const openEditProductModal = (produk) => {
      // Populate edit form
      Object.assign(editedProduct, {
        id: produk.id,
        name: produk.name,
        hargaBeli: produk.hargaBeli || produk.harga_beli,
        hargaJual: produk.hargaJual || produk.harga_jual,
        jumlah: produk.jumlah || produk.jumlah_stok,
        batasKritis: produk.batasKritis || produk.batas_kritis
      });
      isEditModalVisible.value = true
    }

    const closeEditProductModal = () => {
      isEditModalVisible.value = false
    }

    const openDeleteProductModal = (produk) => {
      productToDelete.value = produk
      isDeleteModalVisible.value = true
    }

    const closeDeleteProductModal = () => {
      isDeleteModalVisible.value = false
      productToDelete.value = null
    }

    // Event handlers for modal events
    const handleProductAdded = async (newProduct) => {
      try {
        const token = localStorage.getItem('auth_token');
        await axios.post('http://127.0.0.1:8000/api/gudang', newProduct, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        await fetchProduks();
        closeAddProductModal();
      } catch (error) {
        console.error('Error adding product:', error);
        alert('Terjadi kesalahan saat menambahkan produk');
      }
    };

    const handleProductUpdated = async (updatedProduct) => {
      try {
        const token = localStorage.getItem('auth_token');
        await axios.put(`http://127.0.0.1:8000/api/gudang/${updatedProduct.id}`, updatedProduct, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        await fetchProduks();
        closeEditProductModal();
      } catch (error) {
        console.error('Error updating product:', error);
        alert('Terjadi kesalahan saat memperbarui produk');
      }
    };

    const handleProductDeleted = async (productId) => {
      try {
        const token = localStorage.getItem('auth_token');
        await axios.delete(`http://127.0.0.1:8000/api/gudang/${productId}`, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        await fetchProduks();
        closeDeleteProductModal();
      } catch (error) {
        console.error('Error deleting product:', error);
        alert('Terjadi kesalahan saat menghapus produk');
      }
    };

    return {
      produks,
      currentPage,
      itemsPerPage,
      isAddModalVisible,
      isEditModalVisible,
      isDeleteModalVisible,
      newProduct,
      editedProduct,
      productToDelete,
      kategoriesCount,
      totalProdukCount,
      lowStockProdukCount,
      totalPages,
      paginatedProduks,
      formatCurrency,
      changePage,
      openAddProductModal,
      closeAddProductModal,
      openEditProductModal,
      closeEditProductModal,
      openDeleteProductModal,
      closeDeleteProductModal,
      handleProductAdded,
      handleProductUpdated,
      handleProductDeleted,
      editedProduct
    }
  }
}
</script>

<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>
