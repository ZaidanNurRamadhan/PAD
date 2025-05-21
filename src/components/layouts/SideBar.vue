<template>
  <aside class="sidebar">
    <div>
      <div>
        <img alt="KONEK Logo" height="120" src="/src/assets/img/Logo.png" width="170" class="image1 object-fit-cover" />
        <img alt="KONEK Logo" height="80" src="/src/assets/img/logo-konek.png" width="80" class="image2" />
      </div>

      <!-- Navigation Berdasarkan userRole -->
      <div v-if="isOwner" class="nav-container">
        <nav>
          <router-link to="/dashboard" :class="{ active: isActive('/dashboard') }">
            <font-awesome-icon :icon="['fas', 'home']" /> Beranda
          </router-link>
          <router-link to="/transaksi-owner" :class="{ active: isActive('/transaksi-owner') }">
            <font-awesome-icon :icon="['fas', 'cash-register']" /> Transaksi
          </router-link>
          <router-link to="/gudang-owner" :class="{ active: isActive('/gudang-owner') }">
            <font-awesome-icon :icon="['fas', 'warehouse']" /> Gudang
          </router-link>
          <router-link to="/laporan" :class="{ active: isActive('/laporan') }">
            <font-awesome-icon :icon="['fas', 'chart-line']" /> Laporan
          </router-link>
          <router-link to="/pemasok" :class="{ active: isActive('/pemasok') }">
            <font-awesome-icon :icon="['fas', 'truck']" /> Pemasok
          </router-link>
          <router-link to="/manajemen-toko" :class="{ active: isActive('/manajemen-toko') }">
            <font-awesome-icon :icon="['fas', 'store']" /> Manajemen Toko
          </router-link>
        </nav>
      </div>

      <!-- Navigasi untuk Karyawan -->
      <div v-else class="nav-container">
        <nav>
          <router-link to="/transaksi-karyawan" :class="{ active: isActive('/transaksi-karyawan') }">
            <font-awesome-icon :icon="['fas', 'cash-register']" /> Transaksi
          </router-link>
          <router-link to="/gudang-karyawan" :class="{ active: isActive('/gudang-karyawan') }">
            <font-awesome-icon :icon="['fas', 'warehouse']" /> Gudang
          </router-link>
        </nav>
      </div>

      <!-- Link settings (khusus owner) -->
      <router-link v-if="isOwner" to="/settings" :class="{ active: isActive('/settings') }">
        <font-awesome-icon :icon="['fas', 'users-cog']" /> Manajemen Karyawan
      </router-link>

      <!-- Tombol logout -->
      <a href="#" @click.prevent="isLogoutModalOpen = true">
        <font-awesome-icon :icon="['fas', 'sign-out-alt']" /> Keluar
      </a>
    </div>

    <!-- Modal Logout -->
    <LogoutModal
      v-if="isLogoutModalOpen"
      @close="isLogoutModalOpen = false"
      @logout="handleLogout"
    />
  </aside>
</template>


<script>
import LogoutModal from '@/components/modals/Logout.vue';

export default {
  components: {
    LogoutModal
  },
  data() {
    return {
      userRole: JSON.parse(localStorage.getItem('user_info'))?.role,
      isLogoutModalOpen: false,
    };
  },
  computed: {
    isOwner() {
      return this.userRole === 'owner';
    },
  },
  methods: {
    isActive(route) {
      return this.$route.path === route;
    },
    handleLogout() {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user_info');
      this.$router.push('/');
    },
  },
};
</script>

<style scoped>
@import '/src/assets/css/style.css';
@import '/src/assets/css/layout.css';

.active {
  font-weight: bold;
  color: blue;
}
</style>
