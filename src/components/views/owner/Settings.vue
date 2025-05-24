<template>
  <section class="table-container d-flex flex-column min-vh-100 m-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="text-judul">Manajemen Karyawan</h5>
      <button
        class="btn btn-primary btn-tambah-karyawan"
        type="button"
        @click="showAddModal = true"
      >
        Tambah Karyawan
      </button>
    </div>

    <!-- Employee Table -->
    <div class="table-responsive flex-grow-1 overflow-auto table-data">
      <table class="table">
        <thead>
          <tr>
            <th>Nama Karyawan</th>
            <th>Kontak</th>
            <th>Email</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="paginatedEmployees.length > 0">
            <tr
              v-for="employee in paginatedEmployees"
              :key="employee.id"
            >
              <td>{{ employee.name }}</td>
              <td>{{ employee.contact }}</td>
              <td>{{ employee.email }}</td>
              <td class="d-flex justify-content-center">
                <button
                  class="btn btn-warning btn-sm mx-2"
                  type="button"
                  @click="openEditEmployeeModal(employee)"
                >
                  Edit
                </button>
                <button
                  class="btn btn-danger btn-sm mx-2"
                  type="button"
                  @click="openDeleteEmployeeModal(employee)"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </template>
          <tr v-else>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
          <tr v-for="n in (10 - paginatedEmployees.length)" :key="n">
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

    <!-- Modals -->
    <TambahKaryawanModal
      v-if="showAddModal"
      @close="showAddModal = false"
      @added="handleEmployeeAdded"
    />
    <EditKaryawanModal
      v-if="showEditModal"
      :karyawan="selectedEmployee"
      @close="showEditModal = false"
      @update="handleEmployeeUpdated"
    />
    <HapusKaryawanModal
      v-if="showDeleteModal"
      :karyawan="selectedEmployee"
      @close="showDeleteModal = false"
      @delete="handleEmployeeDeleted"
    />
  </section>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import TambahKaryawanModal from '@/components/modals/TambahKaryawan.vue'
import EditKaryawanModal from '@/components/modals/EditKaryawan.vue'
import HapusKaryawanModal from '@/components/modals/HapusKaryawan.vue'

export default {
  name: 'EmployeeManagement',
  props: {
    searchTerm: {
      type: String,
      default: ''
    }
  },
  components: {
    TambahKaryawanModal,
    EditKaryawanModal,
    HapusKaryawanModal
  },
  setup(props) {
    const employees = ref([]) 
    const currentPage = ref(1)
    const itemsPerPage = ref(10)

    const showAddModal = ref(false)
    const showEditModal = ref(false)
    const showDeleteModal = ref(false)
    const selectedEmployee = ref(null)

    const totalPages = computed(() => {
      return Math.ceil(employees.value.length / itemsPerPage.value)
    })

    const paginatedEmployees = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return employees.value.slice(start, end)
    })

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
      }
    }

    const fetchEmployees = async () => {
      try {
        const token = localStorage.getItem('auth_token');  // Get the token from localStorage
        const response = await axios.get('http://127.0.0.1:8000/api/karyawan', {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`,  // Add the Bearer token to the request header
          }
        })

        employees.value = response.data.data
      } catch (error) {
        console.error(error)
        alert('Terjadi kesalahan saat mengambil data karyawan')
      }
    }

    // Watch searchTerm prop to perform search
    watch(() => props.searchTerm, async (newTerm) => {
      const token = localStorage.getItem('auth_token');
      if (newTerm && newTerm.trim() !== '') {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/search', {
            params: { search: newTerm, page: 'karyawan-owner' },
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            }
          });
          employees.value = Array.isArray(response.data.data.data) ? response.data.data.data : [];
        } catch (error) {
          console.error('Error searching employees:', error);
        }
      } else {
        // If search term is empty, fetch all employees
        fetchEmployees();
      }
    }, { immediate: true });

    onMounted(() => {
      fetchEmployees()
    })

    const openEditEmployeeModal = (employee) => {
      selectedEmployee.value = employee
      showEditModal.value = true
    }

    const openDeleteEmployeeModal = (employee) => {
      selectedEmployee.value = employee
      showDeleteModal.value = true
    }

    const handleEmployeeAdded = async (newEmployee) => {
      await fetchEmployees(); // ambil ulang data dari backend
      showAddModal.value = false;
    }


    const handleEmployeeUpdated = async (updatedEmployee) => {
      await fetchEmployees(); // ambil ulang data dari server (pasti sinkron)
      showEditModal.value = false;
    }

    const handleEmployeeDeleted = async (deletedEmployeeId) => {
      await fetchEmployees(); // ambil ulang data setelah penghapusan
      showDeleteModal.value = false;
    }

    return {
      employees,
      paginatedEmployees,
      currentPage,
      totalPages,
      changePage,
      showAddModal,
      showEditModal,
      showDeleteModal,
      selectedEmployee,
      openEditEmployeeModal,
      openDeleteEmployeeModal,
      handleEmployeeAdded,
      handleEmployeeUpdated,
      handleEmployeeDeleted,
      searchTerm: props.searchTerm
    }
  }
}
</script>


<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';
</style>
