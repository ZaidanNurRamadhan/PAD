<template>
  <main class="container-fluid d-flex align-items-center">
    <div class="row flex-fill">
      <!-- Left Side - Image -->
      <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
        <img :src="logoImage" alt="logo" class="logo-utama"/>
      </aside>

      <!-- Right Side - Login Form -->
      <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
        <form @submit.prevent="handleSubmit" class="login-form">
          <!-- Form Header -->
          <div class="form-group text-center">
            <img :src="logoIcon" alt="logo" class="icon-login"/>
            <h1>Login</h1>
            <p class="fw-light">Selamat datang di aplikasi manajemen stok</p>
          </div>

          <!-- Alert for errors -->
          <div v-if="errorMessage" class="alert alert-danger" role="alert">
            {{ errorMessage }}
          </div>

          <!-- Email Input -->
          <div class="mb-3">
            <label class="m-0">Email</label>
            <input
              type="email"
              v-model="form.email"
              class="form-control"
              id="email"
              placeholder="Masukkan Email"
              required
            >
          </div>

          <!-- Password Input with Toggle -->
          <div>
            <label class="m-0">Password</label>
            <div class="d-flex position-relative">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                class="form-control"
                id="password"
                placeholder="Masukkan Password"
                required
              />
              <span
                class="fas"
                :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"
                @click="togglePassword"
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"
              ></span>
            </div>
          </div>

          <!-- Forgot Password Link -->
          <router-link to="/forgot-password" class="mb-2 text-decoration-none float-end">
            Lupa password?
          </router-link>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
            <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
            Login
          </button>
        </form>
      </section>
    </div>

    <!-- Notification Component -->
    <Notification v-if="showNotification" :message="notificationMessage" @close="showNotification = false"/>
  </main>
</template>

<script>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import Notification from '@/components/modals/Notifikasi.vue';
import logoImage from '@/assets/img/wa.jpg';
import logoIcon from '@/assets/img/logo-konek.png';

export default {
  name: 'LoginView',
  components: {
    Notification
  },
  setup() {
    const router = useRouter();

    // Form data
    const form = reactive({
      email: '',
      password: ''
    });

    // UI state
    const isLoading = ref(false);
    const showPassword = ref(false);
    const errorMessage = ref('');
    const showNotification = ref(false);
    const notificationMessage = ref('');

    // Toggle password visibility
    const togglePassword = () => {
      showPassword.value = !showPassword.value;
    };

    // Show notification
    const showNotificationMessage = (message) => {
      notificationMessage.value = message;
      showNotification.value = true;

      // Auto-hide notification after 3 seconds
      setTimeout(() => {
        showNotification.value = false;
      }, 3000);
    };

    // Handle form submission
    const handleSubmit = async () => {
  try {
    isLoading.value = true;
    errorMessage.value = '';

    const response = await fetch('http://127.0.0.1:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),  // CSRF token dari meta tag di Blade template
      },
      body: JSON.stringify({
        email: form.email,
        password: form.password,
      }),
      credentials: 'include', // Penting untuk mengirimkan cookie dengan permintaan
    });


    const data = await response.json();

    if (data.success) {
      // Menyimpan user info dan token otentikasi
      localStorage.setItem('auth_token', data.token);
      localStorage.setItem('user_info', JSON.stringify(data.user));
      console.log(localStorage.getItem('auth_token'))

      // Redirect ke dashboard berdasarkan peran
      const redirectPath = data.user?.role === 'owner' ? '/dashboard' : '/transaksi-karyawan';
      router.push(redirectPath);
    } else {
      errorMessage.value = data.message || 'Login gagal. Silakan periksa kembali email dan password Anda.';
    }
  } catch (error) {
    console.error('Login error:', error);
    errorMessage.value = 'Terjadi kesalahan saat login. Silakan coba lagi.';
  } finally {
    isLoading.value = false;
  }
};

    return {
      form,
      isLoading,
      showPassword,
      errorMessage,
      showNotification,
      notificationMessage,
      togglePassword,
      handleSubmit,
      logoIcon,
      logoImage
    };
  }
};
</script>
<style scoped>
  @import '/src/assets/css/form.css';
</style>