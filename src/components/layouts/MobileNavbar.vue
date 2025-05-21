<template>
  <header class="d-sm-none">
    <nav class="navbar bg-body-tertiary fixed-top">
      <div class="container-fluid">
        <img src="/src/assets/img/Logo.png" width="100" height="40" class="aspek object-fit-cover" alt="KONEK Logo">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title fs-3" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body d-flex flex-column">
            <ul class="navbar-nav flex-grow-1">
              <!-- Navigasi Owner -->
              <template v-if="isOwner">
                <li class="nav-item">
                  <router-link to="/dashboard" :class="[{ active: isActive('/dashboard') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'home']" /> Beranda
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/transaksi-owner" :class="[{ active: isActive('/transaksi-owner') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'cash-register']" /> Transaksi
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/gudang-owner" :class="[{ active: isActive('/gudang-owner') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'warehouse']" /> Gudang
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/laporan" :class="[{ active: isActive('/laporan') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'chart-line']" /> Laporan
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/pemasok" :class="[{ active: isActive('/pemasok') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'truck']" /> Pemasok
                  </router-link>
                </li>
                <li class="nav-item">

                </li>
                <li class="nav-item">
                  <router-link to="/manajemen-toko" :class="[{ active: isActive('/manajemen-toko') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'store']" /> Manajemen Toko
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link v-if="isOwner" to="/settings" :class="[{ active: isActive('/settings') }, 'text-decoration-none']">
                  <font-awesome-icon :icon="['fas', 'users-cog']" /> Manajemen Karyawan
                </router-link>
              </li>
              </template>

              <!-- Navigasi Karyawan -->
              <template v-else>
                <li class="nav-item">
                  <router-link to="/transaksi-karyawan" :class="[{ active: isActive('/transaksi-karyawan') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'cash-register']" /> Transaksi
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/gudang-karyawan" :class="[{ active: isActive('/gudang-karyawan') }, 'text-decoration-none']">
                    <font-awesome-icon :icon="['fas', 'warehouse']" /> Gudang
                  </router-link>
                </li>
              </template>

              <!-- Link settings (khusus owner) -->
              

              <!-- Link logout -->
              <li class="nav-item mt-auto">
                <a href="#" @click.prevent="isLogoutModalOpen = true" class="text-decoration-none">
                  <font-awesome-icon :icon="['fas', 'sign-out-alt']" /> Keluar
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import LogoutModal from '../modals/Logout.vue';

export default {
  components: {
    LogoutModal,
  },
  data() {
    return {
      // Mengambil role pengguna dari localStorage
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
    handleLogout() {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user_info');
      this.$router.push('/'); // Redirect ke halaman login setelah logout
    },
    isActive(path) {
      return this.$route.path === path;
    },
  },
};
</script>
<style scoped>
  @import '/src/assets/css/style.css';
  @import '/src/assets/css/layout.css';
</style>