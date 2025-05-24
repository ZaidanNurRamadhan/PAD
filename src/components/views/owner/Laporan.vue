<template>
  <div class="container-fluid p-0">
    <!-- Transaction Summary Section -->
    <section class="table-container p-3 h-auto mx-2">
      <div class="d-flex justify-content-between align-items-center border-0">
        <p class="text-white">laporannnnbbbbbb</p>
        <h3 class="align-self-end">Laporan</h3>

        <!-- Dropdown Filter -->
        <div class="dropdown align-self-start">
          <div
            class="dropdown-selected"
            @click="toggleDropdown"
          >
            <img
              src="/assets/img/kalender.png"
              alt="Calendar Icon"
              class="icon"
            >
            <span class="selected-text">
              {{ currentFilter === 'bulanan' ? 'Bulanan' : 'Harian' }}
            </span>
            <span class="arrow">▼</span>
          </div>
          <div
            class="dropdown-options"
            :class="{ 'show': isDropdownOpen }"
          >
            <div
              class="dropdown-option"
              @click="applyFilter('harian')"
            >
              Harian
            </div>
            <div
              class="dropdown-option mt-2"
              @click="applyFilter('bulanan')"
            >
              Bulanan
            </div>
          </div>
        </div>
      </div>

      <!-- Summary Metrics -->
      <div class="row mt-3">
        <div class="col text-center">
          <p class="fw-semibold" style="color: #1570EF">Jumlah Transaksi</p>
          <p>{{ transactionCount }}</p>
        </div>
        <div class="col text-center">
          <p class="fw-semibold" style="color: #E19133">Produk yang Terjual</p>
          <p>{{ soldProductsCount }}</p>
        </div>
        <div class="col text-center">
          <p class="fw-semibold" style="color: #845EBC">Produk Retur</p>
          <p>{{ returnedProductsCount }}</p>
        </div>
      </div>
    </section>

    <!-- Transaction Recap Section -->
    <section class="table-container mt-4 p-4 min-vh-100 d-flex justify-content-between flex-column mx-2 mb-4">
      <div class="d-flex justify-content-between border-0 mb-2">
        <h5 class="text-judul">Rekap Transaksi</h5>
        <div class="dropdown align-self-start w-auto">
          <button
            class="btn btn-outline-secondary dropdown-selected"
            @click="toggleDownloadDropdown"
          >
            Download
            <span class="arrow">▼</span>
          </button>
          <div
            class="dropdown-options"
            :class="{ 'show': isDownloadDropdownOpen }"
            style="min-width: 150px;"
          >
            <div
              class="dropdown-option"
              @click="downloadPDF"
            >
              Download PDF
            </div>
            <div
              class="dropdown-option mt-2"
              @click="downloadExcel"
            >
              Download Excel
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive flex-grow-1">
        <table class="table">
          <thead>
            <tr>
              <th>Total Harga</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Produk</th>
              <th class="text-center">Terjual</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Tanggal keluar</th>
              <th class="text-center">Tanggal Retur</th>
              <th class="text-center">Waktu Edar</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="closedTransactions.length > 0">
              <template
                v-for="(item, index) in closedTransactions"
                :key="index"
              >
                <tr>
                  <td>{{ item.toko }}</td>
                </tr>
                <tr>
                  <td>{{ formatCurrency(item.total_harga) }}</td>
                  <td class="text-center">{{ item.jumlahDibeli }}</td>
                  <td class="text-center">{{ item.produk }}</td>
                  <td class="text-center">{{ item.terjual }}</td>
                  <td class="text-center">{{ formatCurrency(item.harga) }}</td>
                  <td class="text-center">{{ formatDate(item.tanggal_keluar) }}</td>
                  <td class="text-center">{{ formatDate(item.tanggal_retur) }}</td>
                  <td class="text-center">{{ item.waktu_edar }}</td>
                  <td class="text-danger text-center">{{ item.status }}</td>
                </tr>
              </template>
            </template>
            <tr v-else>
              <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
            <tr
              v-for="n in (19 - closedTransactions.length)"
              :key="n"
            >
              <td colspan="9"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-between">
        <button
          class="btn btn-secondary"
          @click="prevPage"
          :disabled="currentPage === 1"
        >
          Prev
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="btn btn-secondary"
          @click="nextPage"
          :disabled="currentPage === totalPages"
        >
          Next
        </button>
      </div>
    </section>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'

export default {
  name: 'OwnerTransactionReport',
  props: {
    initialData: {
      type: Array,
      default: () => []
    },
    searchTerm: {
      type: String,
      default: ''
    }
  },
    setup(props) {
      const data = ref(props.initialData)
      const currentPage = ref(1)
      const itemsPerPage = ref(10)
      const currentFilter = ref('harian')
      const isDropdownOpen = ref(false)
      const isDownloadDropdownOpen = ref(false)

      // Fetch transactions from API based on filter
      const fetchTransactions = async () => {
        try {
          const token = localStorage.getItem('auth_token') // Get Bearer token from localStorage
          const response = await axios.get(`http://127.0.0.1:8000/api/laporan?filter=${currentFilter.value}`, {
            headers: {
              'Authorization': `Bearer ${token}`,
              'Content-Type': 'application/json',
              'Accept': 'application/json',
            },
          })
          data.value = response.data.data // Assuming response contains 'data' key
        } catch (error) {
          console.error('Error fetching transaction data:', error)
        }
      }

      // Lifecycle hook to fetch transactions on mount
      onMounted(() => {
        fetchTransactions()
      })

      // Computed properties
      const closedTransactions = computed(() => {
        return data.value.filter(item => item.status === 'closed')
      })

      const paginatedTransactions = computed(() => {
        const start = (currentPage.value - 1) * itemsPerPage.value
        const end = start + itemsPerPage.value
        return closedTransactions.value.slice(start, end)
      })

      const totalPages = computed(() => {
        return Math.ceil(closedTransactions.value.length / itemsPerPage.value)
      })

      const transactionCount = computed(() => {
        return data.value.length
      })

      const soldProductsCount = computed(() => {
        return data.value.reduce((sum, item) => sum + (item.terjual || 0), 0)
      })

      const returnedProductsCount = computed(() => {
        return data.value.reduce((sum, item) =>
          sum + ((item.jumlahDibeli || 0) - (item.terjual || 0)),
          0
        )
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

      const formatDate = (dateString) => {
        if (!dateString) return ''
        const date = new Date(dateString)
        return date.toLocaleDateString('id-ID', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric'
        })
      }

      const toggleDropdown = () => {
        isDropdownOpen.value = !isDropdownOpen.value
      }

      const toggleDownloadDropdown = () => {
        isDownloadDropdownOpen.value = !isDownloadDropdownOpen.value
      }

      const applyFilter = (filter) => {
        currentFilter.value = filter
        isDropdownOpen.value = false
        fetchTransactions() // Fetch data based on new filter
      }

      const downloadPDF = async () => {
        try {
          const token = localStorage.getItem('auth_token')
          const response = await axios.get('http://127.0.0.1:8000/api/export-pdf', {
            headers: {
              'Authorization': `Bearer ${token}`
            },
            responseType: 'blob'
          })
          const url = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }))
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', 'Laporan_Transaksi.pdf')
          document.body.appendChild(link)
          link.click()
          link.remove()
          isDownloadDropdownOpen.value = false
        } catch (error) {
          console.error('Error downloading PDF:', error)
        }
      }

      const downloadExcel = async () => {
        try {
          const token = localStorage.getItem('auth_token')
          const response = await axios.get('http://127.0.0.1:8000/api/export-transaksi', {
            headers: {
              'Authorization': `Bearer ${token}`
            },
            responseType: 'blob'  // Pastikan response adalah blob
          })
    // Cek jika respons berupa blob
            if (response.status === 200) {
              const url = window.URL.createObjectURL(new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }))
              const link = document.createElement('a')
              link.href = url
              link.setAttribute('download', 'laporan.xlsx')  // Nama file Excel yang akan diunduh
              document.body.appendChild(link)
              link.click()
              link.remove()
              isDownloadDropdownOpen.value = false
            } else {
              throw new Error('Failed to download file')
            }
          } catch (error) {
            console.error('Error downloading Excel:', error)
            // Opsional: Tambahkan pemberitahuan atau UI error handling di sini
          }
      }

      const prevPage = () => {
        if (currentPage.value > 1) {
          currentPage.value--
        }
      }

      const nextPage = () => {
        if (currentPage.value < totalPages.value) {
          currentPage.value++
        }
      }

      // Watch searchTerm prop to perform search
      watch(() => props.searchTerm, async (newTerm) => {
        const token = localStorage.getItem('auth_token');
        if (newTerm && newTerm.trim() !== '') {
          try {
            const response = await axios.get('http://127.0.0.1:8000/api/search', {
              params: { search: newTerm, page: 'laporan' },
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
              },
            });
            data.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
          } catch (error) {
            console.error('Error searching laporan:', error);
          }
        } else {
          fetchTransactions();
        }
      }, { immediate: true });

      return {
        data,
        closedTransactions: paginatedTransactions,
        currentPage,
        totalPages,
        currentFilter,
        isDropdownOpen,
        isDownloadDropdownOpen,
        transactionCount,
        soldProductsCount,
        returnedProductsCount,
        formatCurrency,
        formatDate,
        toggleDropdown,
        toggleDownloadDropdown,
        applyFilter,
        downloadPDF,
        downloadExcel,
        prevPage,
        nextPage
      }
    }
}
</script>
<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>