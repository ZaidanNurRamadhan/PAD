<template>
    <div id="owner-layout">
      <Sidebar />
      <Navbar />
      <main class="content">
        <Header :searchTerm="searchTerm" @search="updateSearchTerm" />
        <main class="main-content">
          <router-view v-slot="{ Component, route }">
            <component :is="Component" :searchTerm="searchTerm" :key="route.fullPath" />
          </router-view>
        </main>
      </main>
    </div>
</template>
  
  <script>
  import { ref } from 'vue'
  import Sidebar from '../layouts/SideBar.vue';
  import Navbar from '../layouts/MobileNavbar.vue';
  import Header from './Header.vue';
  
  export default {
    components: {
      Sidebar,
      Navbar,
      Header
    },
    setup() {
      const searchTerm = ref('')
      const updateSearchTerm = (newTerm) => {
        searchTerm.value = newTerm
      }
      return {
        searchTerm,
        updateSearchTerm
      }
    }
  };
  </script>
  <style scoped>
    @import '/src/assets/css/style.css';
    @import '/src/assets/css/layout.css';
  </style>
  