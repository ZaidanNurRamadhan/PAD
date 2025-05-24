<template>
  <section class="container-fluid d-flex row h-100">
    <!-- Monitoring Section -->
    <article class="table-container m-2 monitoring">
      <div class="d-flex justify-content-between position-sticky">
        <h5 class="text-judul align-self-center mb-0 py-2">Monitoring Penyebaran Produk</h5>
        <a class="text-decoration-none text-judul text-end align-self-center" href="#" @click="viewAllMonitoring">Lihat Semua</a>
      </div>
      <div class="scrollable-table table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Nama Toko</th>
              <th>Waktu Edar</th>
              <th>Jumlah</th>
              <th>Kategori</th>
              <th>Hari</th>
              <th>Tanggal Keluar</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(monitoring, index) in monitoring" :key="index" v-if="monitoring">
              <td>{{ monitoring.nama_toko }}</td>
              <td>{{ monitoring.waktu_edar }}</td>
              <td>{{ monitoring.jumlah }}</td>
              <td>{{ monitoring.kategori }}</td>
              <td>{{ monitoring.hari }}</td>
              <td>{{ formatDate(monitoring.tanggal_keluar) }}</td>
              <td :class="monitoring.status === 'closed' ? 'text-danger' : 'text-success'">{{ monitoring.status }}</td>
            </tr>
            <tr v-if="monitoring.length === 0">
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
          </tbody>
        </table>
      </div>
    </article>

    <section class="row mt-4 equal-height flex-grow-1">
      <section class="col-12 col-xxl-8 table-terhubung">
        <!-- Penjualan & Retur Section -->
        <article class="table-container chartnya flex-grow-1 h-auto">
          <div class="d-flex justify-content-between bg-white">
            <h5 class="align-self-center text-judul mb-0">Penjualan & Retur</h5>
            <div class="dropdown">
              <div class="dropdown-selected bg-white" @click="toggleDropdown">
                <img src="@/assets/img/kalender.png" alt="Calendar Icon" class="icon" />
                <span class="selected-text">{{ selectedPeriod }}</span>
                <span class="arrow">▼</span>
              </div>
              <div v-show="dropdownVisible" class="dropdown-options">
                <div class="dropdown-option" @click="selectOption('Harian')">Harian</div>
                <div class="dropdown-option" @click="selectOption('Bulanan')">Bulanan</div>
              </div>
            </div>
          </div>
          <div class="chart">
            <canvas id="myChart"></canvas>
          </div>
        </article>

        <!-- Terlaris Section -->
        <article class="table-container mt-4 isi-table flex-grow-1 h-auto">
          <div class="d-flex justify-content-between bg-white sticky terlaris">
            <h5 class="align-self-center text-judul mb-0">Terlaris</h5>
            <div class="dropdown" @click.stop="toggleDropdownTerlaris">
              <div class="dropdown-selected bg-white">
                <img src="/assets/img/kalender.png" alt="Calendar Icon" class="icon" />
                <span class="selected-text">{{ selectedOption }}</span>
                <span class="arrow">▼</span>
              </div>
              <div class="dropdown-options" v-if="dropdownOpen">
                <div class="dropdown-option" @click.stop="selectOptionTerlaris('Harian')">Harian</div>
                <div class="dropdown-option" @click.stop="selectOptionTerlaris('Bulanan')">Bulanan</div>
              </div>
            </div>
          </div>

          <div class="card-body table-terlaris px-3 p-0 table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Nama Produk</th>
                  <th>Produk Keluar</th>
                  <th>Produk Tersisa</th>
                  <th>Harga</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="bestSellers.length === 0">
                  <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
                <tr v-for="(item, index) in bestSellers" :key="index">
                  <td>{{ item.produk.name }}</td>
                  <td>{{ item.total_terjual }}</td>
                  <td>{{ item.produk.jumlah - item.total_terjual }}</td>
                  <td>Rp {{ formatHarga(item.produk.hargaJual) }}</td>
                </tr>
                <tr v-for="i in (10 - bestSellers.length)" :key="'empty-' + i">
                  <td colspan="4"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>
      </section>

      <!-- Produk Menipis Section -->
      <section class="col-xxl-4 col-12 flex-grow-1">
        <article class="table-container flex-grow-1 table-menipis">
          <div class="d-flex justify-content-between align-items-center bg-white position-sticky">
            <h5 class="text-judul">Produk Menipis</h5>
            <a class="text-decoration-none text-judul" href="#" @click="viewAllProducts">Lihat Semua</a>
          </div>
          <div class="scrollable-list">
            <ul class="list-group">
              <li v-for="(produk, index) in produkMenipis" :key="index" class="list-group-item d-flex justify-content-between flex-column">
                <span>{{ produk.name }}</span>
                <span>Produk Tersisa: {{ produk.jumlah }} <span class="badge badge-danger">Rendah</span></span>
              </li>
              <li v-if="!produkMenipis.length" class="list-group-item d-flex justify-content-between flex-column">
                <span>Data tidak tersedia</span>
              </li>
            </ul>
          </div>
        </article>
      </section>
    </section>
  </section>
</template>

<script>
import axios from 'axios';
import {
  Chart,
  CategoryScale,
  LinearScale,
  BarController,
  BarElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js';

export default {
  data() {
    return {
      monitoring: [],
      salesData: { labels: [], sales: [], returns: [] },
      bestSellers: [],
      produkMenipis: [],
      selectedPeriod: 'Harian',
      selectedOption: 'Harian',
      dropdownVisible: false,
      dropdownOpen: false,
      chartInstance: null
    };
  },
  mounted() {
    this.fetchDashboardData();
    this.fetchProdukTerlaris();
  },
  methods: {
    fetchDashboardData() {
      const token = localStorage.getItem('auth_token');
      if (!token) {
        console.error('Token tidak ditemukan.');
        return;
      }

      axios.get('http://127.0.0.1:8000/api/dashboard', {
        params: { filter: this.selectedPeriod.toLowerCase() },
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(res => {
          this.monitoring = res.data.monitoring_data || [];
          this.salesData = res.data.sales_data || { labels: [], sales: [], returns: [] };
          this.produkMenipis = res.data.produk_menipis || [];
          this.renderChart();
        })
        .catch(err => {
          console.error('Gagal ambil dashboard:', err);
        });
    },

    fetchProdukTerlaris() {
      const token = localStorage.getItem('auth_token');
      if (!token) {
        console.error('Token tidak ditemukan.');
        return;
      }

      axios.get('http://127.0.0.1:8000/api/dashboard?filter', {
        params: { filter: this.selectedOption.toLowerCase() },
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(res => {
          this.bestSellers = res.data.produk_terlaris || [];
        })
        .catch(err => {
          console.error('Gagal ambil produk terlaris:', err);
        });
    },

    toggleDropdown() {
      this.dropdownVisible = !this.dropdownVisible;
    },

    toggleDropdownTerlaris() {
      this.dropdownOpen = !this.dropdownOpen;
    },

    selectOption(period) {
      this.selectedPeriod = period;
      this.dropdownVisible = false;
      this.fetchDashboardData();
    },

    selectOptionTerlaris(option) {
      this.selectedOption = option;
      this.dropdownOpen = false;
      this.fetchProdukTerlaris();
    },

    renderChart() {
      Chart.register(CategoryScale, LinearScale, BarController, BarElement, Title, Tooltip, Legend);
      if (!this.salesData.labels.length) return;

      const ctx = document.getElementById('myChart').getContext('2d');
      if (this.chartInstance) this.chartInstance.destroy();

      this.chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: this.salesData.labels,
          datasets: [
            {
              label: 'Penjualan',
              data: this.salesData.sales,
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Retur',
              data: this.salesData.returns,
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    },

    formatDate(date) {
      const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
      return new Date(date).toLocaleDateString(undefined, options);
    },

    formatHarga(amount) {
      return amount.toLocaleString('id-ID');
    },

    viewAllMonitoring() {
      this.$router.push({ path: '/monitoring', state: { monitoring: this.monitoring } });
    },
    viewAllBestSellers() {},
    viewAllProducts() {
      this.$router.push({ path: '/gudang-owner', state: { products: this.products } });
    }
  }
};
</script>

<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>
