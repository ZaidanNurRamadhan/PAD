<template>
    <section
      class="table-container d-flex flex-column justify-content-between"
      style="height: 100vh;"
    >
      <!-- Header -->
      <div class="card-header d-flex justify-content-between bg-white position-sticky terlaris">
        <div class="fs-4">Monitoring Data Produk</div>
      </div>

      <!-- Table -->
      <div class="table-responsive scrollable-table w-100 mt-2 flex-grow-1">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Nama Toko</th>
              <th>Waktu Edar</th>
              <th>Jumlah</th>
              <th>Kategori</th>
              <th>Hari</th>
              <th>Tanggal Keluar</th>
              <th>status</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="monitoringData.length > 0">
              <tr
                v-for="item in paginatedTransactions"
                :key="item.id"
              >
                <td>{{ item.nama_toko }}</td>
                <td>{{ item.waktu_edar }}</td>
                <td>{{ item.jumlah }}</td>
                <td>{{ item.kategori }}</td>
                <td>{{ item.hari }}</td>
                <td>{{ formatDate(item.tanggal_keluar) }}</td>
                <td :class="item.status === 'closed' ? 'text-danger' : 'text-success'">{{ item.status }}</td>
              </tr>
            </template>
            <tr v-else>
              <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            <tr
              v-for="n in (10 - paginatedTransactions.length)"
              :key="n"
            >
              <td colspan="6"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3">
        <nav>
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
            <li
              v-for="page in totalPages"
              :key="page"
              class="page-item"
              :class="{ 'active': page === currentPage }"
            >
              <button
                class="page-link"
                @click="changePage(page)"
              >
                {{ page }}
              </button>
            </li>
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
  </template>

  <script>
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';

export default {
  name: 'ProductMonitoring',
  setup() {
    const data = ref([]);
    const currentPage = ref(1);
    const itemsPerPage = ref(10);

    const monitoringData = computed(() => {
      return data.value;
    });

    const paginatedTransactions = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      const end = start + itemsPerPage.value;
      return monitoringData.value.slice(start, end);
    });

    const totalPages = computed(() => {
      return Math.ceil(monitoringData.value.length / itemsPerPage.value);
    });

    const formatDate = (dateString) => {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      });
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
      }
    };

    const fetchMonitoringData = () => {
      const token = localStorage.getItem('auth_token');
      if (!token) {
        console.error('Token tidak ditemukan.');
        return;
      }

      axios.get('http://127.0.0.1:8000/api/dashboard', {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(res => {
        data.value = res.data.monitoring_data || [];
      })
      .catch(err => {
        console.error('Gagal ambil data monitoring:', err);
      });
    };

    onMounted(() => {
      fetchMonitoringData();
    });

    return {
      data,
      monitoringData,
      paginatedTransactions,
      currentPage,
      totalPages,
      formatDate,
      changePage
    };
  }
};
  </script>

<style scoped>
    @import '/src/assets/css/style.css';
    @import '/src/assets/css/layout.css';
</style>
