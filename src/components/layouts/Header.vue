<template>
  <section class="header mb-2">
    <!-- Dashboard tanpa search (khusus owner) -->
    <template v-if="isDashboardPage">
      <div></div>
      <div class="owner float-end search">{{ userRole === 'owner' ? 'Owner' : 'Karyawan' }}</div>
    </template>

    <!-- Halaman selain Dashboard dengan search bar -->
    <template v-else>
      <input
        type="text"
        v-model="localSearchTerm"
        name="search"
        id="search"
        placeholder="Search..."
        class="form-control search"
        @input="emitSearch"
      />
      <!-- Label role pengguna -->
      <div :class="userRole === 'owner' ? 'owner' : 'karyawan'" class="fw-bold">
        {{ userRole === 'owner' ? 'Owner' : 'Karyawan' }}
      </div>
    </template>
  </section>
</template>

<script>
import { ref, watch, computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'HeaderComponent',
  props: {
    searchTerm: {
      type: String,
      default: ''
    }
  },
  emits: ['search'],
  setup(props, { emit }) {
    const localSearchTerm = ref(props.searchTerm);
    const route = useRoute(); // Untuk mendapatkan informasi halaman saat ini
    const userRole = JSON.parse(localStorage.getItem('user_info'))?.role || 'karyawan'; // Mengambil role dari localStorage

    // Watch perubahan props untuk menyinkronkan state lokal
    watch(() => props.searchTerm, (newValue) => {
      localSearchTerm.value = newValue;
    });

    // Emit event pencarian saat input
    const emitSearch = () => {
      emit('search', localSearchTerm.value);
    };

    // Menentukan apakah halaman saat ini adalah Dashboard
    const isDashboardPage = computed(() => {
      return route.name === 'dashboard'; // Ganti 'dashboard' dengan nama route yang sesuai
    });

    return {
      localSearchTerm,
      emitSearch,
      userRole,
      isDashboardPage
    };
  }
};
</script>
<style scoped>
.header input {
    width: 40vw;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
@media only screen and(min-width:1023) and (max-width:1440) and (min-height:600px) and (max-height:1000px){
    .search{
        width: 50vw !important;
    }
}
@media only screen and(max-width:576px){
  .search{
        width: 50vw!important;
    }
}

</style>
