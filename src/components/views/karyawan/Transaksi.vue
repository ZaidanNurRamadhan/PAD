<template>
  <section class="table-container d-flex flex-column vh-min-100 m-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Transaksi</h3>
      <button
        class="btn btn-primary"
        type="button"
        @click="openAddTransactionModal"
      >
        Tambah Transaksi
      </button>
    </div>

    <!-- Transaction Table -->
    <div class="table-responsive flex-grow-1">
      <table class="table">
        <thead>
          <tr>
            <th>Total Harga</th>
            <th>Jumlah</th>
            <th>Produk</th>
            <th>Terjual</th>
            <th>Harga</th>
            <th>Tanggal keluar</th>
            <th>Tanggal Retur</th>
            <th>Waktu Edar</th>
            <th class="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="paginatedTransactions.length > 0">
            <template v-for="item in paginatedTransactions" :key="item.id">
              <tr>
                <td colspan="9">{{ item.toko }}</td>
              </tr>
              <tr>
                <td>{{ formatCurrency(item.total_harga) }}</td>
                <td>{{ item.jumlahDibeli }}</td>
                <td>{{ item.produk }}</td>
                <td>{{ item.terjual }}</td>
                <td>{{ formatCurrency(item.harga) }}</td>
                <td>{{ formatDate(item.tanggal_keluar) }}</td>
                <td>{{ formatDate(item.tanggal_retur) }}</td>
                <td>{{ item.waktu_edar }}</td>
                <td class="text-center">
                  <span :class="item.status === 'closed' ? 'text-danger' : 'text-success'">
                    {{ formatStatus(item.status) }}
                  </span>
                  <button class="btn btn-sm p-0 m-0" @click="openEditTransactionModal(item)">
                    <font-awesome-icon :icon="['fas', 'angle-right']" style="margin-left: 5px;"/>
                  </button>
                </td>
              </tr>
            </template>
          </template>
          <tr v-else>
            <td colspan="9" class="text-center">Tidak ada data</td>
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

    <TambahTransaksi
      :isVisible="newTransactionModalVisible"
      :tokos="tokos"
      :produks="produks"
      @close="closeAddTransactionModal"
      @add-transaction="addTransaction"
    />

    <EditTransaksiModal
      v-if="editTransactionModalVisible"
      :transaksi="editedTransaction"
      :tokos="tokos"
      :produks="produks"
      @close="closeEditTransactionModal"
      @update="updateTransaction"
    />
  </section>
</template>

<script>
import axios from 'axios';
import { ref, computed, reactive, onMounted, watch } from 'vue';
import TambahTransaksi from '@/components/modals/TambahTransaksi.vue';
import EditTransaksiModal from '@/components/modals/EditTransaksi.vue';

export default {
  name: 'OwnerTransactionView',
  props: {
    searchTerm: {
      type: String,
      default: ''
    }
  },
  components: {
    TambahTransaksi,
    EditTransaksiModal,
  },
  setup(props) {
    const transactions = ref([]);
    const tokos = ref([]);
    const produks = ref([]);
    const currentPage = ref(1);
    const itemsPerPage = ref(10);
    const totalPages = computed(() => Math.ceil(transactions.value.length / itemsPerPage.value));
    const paginatedTransactions = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      return transactions.value.slice(start, start + itemsPerPage.value);
    });

    const newTransactionModalVisible = ref(false);
    const editTransactionModalVisible = ref(false);

    const newTransaction = reactive({
      // Define properties as needed, example:
      toko: '',
      produk: '',
      jumlahDibeli: 0,
      harga: 0,
      tanggal_keluar: '',
      tanggal_retur: '',
      waktu_edar: '',
      status: 'open',
    });

    const editedTransaction = reactive({
      id: null,
      toko: '',
      produk: '',
      jumlahDibeli: 0,
      harga: 0,
      tanggal_keluar: '',
      tanggal_retur: '',
      waktu_edar: '',
      status: 'open',
    });

    const fetchTransactions = async () => {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.get('http://127.0.0.1:8000/api/transaksi-karyawan', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        transactions.value = Array.isArray(response.data.data) ? response.data.data : [];
      } catch (error) {
        console.error('Error fetching transaksi:', error);
      }
    };

    // const fetchTokos = async () => {
    //   try {
    //     const token = localStorage.getItem('auth_token');
    //     const response = await axios.get('http://127.0.0.1:8000/api/toko', {
    //       headers: {
    //         'Content-Type': 'application/json',
    //         'Accept': 'application/json',
    //         'Authorization': `Bearer ${token}`,
    //       },
    //     });
    //     tokos.value = Array.isArray(response.data.data) ? response.data.data : [];
    //   } catch (error) {
    //     console.error('Error fetching tokos:', error);
    //   }
    // };

    // const fetchProduks = async () => {
    //   try {
    //     const token = localStorage.getItem('auth_token');
    //     const response = await axios.get('http://127.0.0.1:8000/api/produk', {
    //       headers: {
    //         'Content-Type': 'application/json',
    //         'Accept': 'application/json',
    //         'Authorization': `Bearer ${token}`,
    //       },
    //     });
    //     produks.value = Array.isArray(response.data.data) ? response.data.data : [];
    //   } catch (error) {
    //     console.error('Error fetching produks:', error);
    //   }
    // };

    // Watch searchTerm prop to perform search
    
    watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'transaksi-karyawan' },
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            },
          });
          transactions.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
        } catch (error) {
          console.error('Error searching transaksi:', error);
        }
      } else {
        fetchTransactions();
      }
    }, { immediate: true });

    onMounted(() => {
      fetchTransactions();
      // fetchTokos();
      // fetchProduks();
    });

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
      }
    };

    const openAddTransactionModal = () => {
      newTransactionModalVisible.value = true;
    };

    const closeAddTransactionModal = () => {
      newTransactionModalVisible.value = false;
    };

    const openEditTransactionModal = (transaction) => {
      Object.assign(editedTransaction, transaction);
      editTransactionModalVisible.value = true;
    };

    const closeEditTransactionModal = () => {
      editTransactionModalVisible.value = false;
    };

    const addTransaction = async (transaction) => {
      try {
        await axios.post('http://127.0.0.1:8000/api/transaksi', transaction, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
        await fetchTransactions();
        closeAddTransactionModal();
      } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat menambahkan transaksi');
      }
    };

    const updateTransaction = async (transaction) => {
      try {
        const response = await axios.put(`http://127.0.0.1:8000/api/transaksi/${transaction.id}`, transaction, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });

        // Update transaksi di frontend tanpa perlu memuat ulang halaman
        const index = transactions.value.findIndex(t => t.id === transaction.id);
        if (index !== -1) {
          transactions.value[index] = response.data.data; // Ganti data transaksi dengan yang baru
        }

        closeEditTransactionModal(); // Tutup modal setelah update selesai
        await fetchTransactions();
      } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat memperbarui transaksi');
      }
    };

    
    const formatCurrency = (value) => {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(value);
    };

    const formatDate = (dateString) => {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID');
    };

    const formatStatus = (status) => {
      if (status === 'closed') return 'Tutup';
      if (status === 'open') return 'Buka';
      return status;
    };

    return {
      transactions,
      tokos,
      produks,
      paginatedTransactions,
      currentPage,
      totalPages,
      newTransaction,
      editedTransaction,
      changePage,
      openAddTransactionModal,
      closeAddTransactionModal,
      openEditTransactionModal,
      closeEditTransactionModal,
      addTransaction,
      updateTransaction,
      formatCurrency,
      formatDate,
      formatStatus,
      newTransactionModalVisible,
      editTransactionModalVisible,
    };
  },
};

</script>

<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>
