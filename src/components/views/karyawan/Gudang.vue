<template>
  <div class="container-fluid">
    <!-- Stock Summary Section -->
    <section class="table-container h-auto p-4" style="z-index: 10;">
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
    <section class="mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column table-container">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Produk</h5>
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
            </tr>
          </thead>
          <tbody>
            <template v-if="produks.length > 0">
              <tr v-for="(produk, index) in paginatedProduks" :key="produk.id">
                <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                <td>{{ produk.name }}</td>
                <td>{{ formatCurrency(produk.hargaBeli) }}</td>
                <td>{{ formatCurrency(produk.hargaJual) }}</td>
                <td>{{ produk.jumlah }}</td>
                <td>{{ produk.batasKritis }} Packets</td>
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
    </section>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'

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
  setup(props) {
    // Reactive state
    const produks = ref(props.initialProduks)
    const currentPage = ref(1)
    const itemsPerPage = ref(9)

    // Fetching products data from API
    const fetchProduks = async () => {
      try {
        const token = localStorage.getItem('auth_token');  // Get token from localStorage
        const response = await axios.get('http://127.0.0.1:8000/api/gudang-karyawan', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,  // Add Bearer token to header
          },
        });

        const data = response.data;
        produks.value = data.produks;
      } catch (error) {
        if (error.response) {
          console.error('Error fetching produk data:', error.response.data.message || 'Cannot fetch product data');
        } else {
          console.error('Error fetching produk data:', error.message);
        }
      }
    };

    watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'gudang-karyawan' },
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

    return {
      produks,
      currentPage,
      itemsPerPage,
      kategoriesCount,
      totalProdukCount,
      lowStockProdukCount,
      totalPages,
      paginatedProduks,
      formatCurrency,
      changePage
    }
  }
}
</script>

<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>
