
<!-- resources/vue/views/auth/ForgotPassword.vue -->
<template>
    <main class="container-fluid d-flex align-items-center">
      <div class="row flex-fill">
        <!-- Left Side - Image -->
        <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
          <img :src="logoImage" alt="logo" class="logo-utama">
        </aside>

        <!-- Right Side - Forgot Password Form -->
        <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
          <form @submit.prevent="handleSubmit" class="login-form">
            <!-- Form Header -->
            <div class="form-group text-center">
              <img :src="logoIcon" alt="logo" class="icon-login">
              <h1>Lupa Password?</h1>
              <p class="fw-light mb-0">Masukkan alamat email yang terkait dengan</p>
              <p class="fw-light mb-4">Akun anda untuk reset password</p>
            </div>

            <!-- Alert for success -->
            <div
              v-if="successMessage"
              class="alert alert-success"
              role="alert"
            >
              {{ successMessage }}
            </div>

            <!-- Alert for errors -->
            <div
              v-if="errorMessage"
              class="alert alert-danger"
              role="alert"
            >
              {{ errorMessage }}
            </div>

            <!-- Email Input -->
            <div class="mb-3">
              <label class="m-0" for="email">Email</label>
              <input
                type="email"
                v-model="email"
                class="form-control"
                id="email"
                placeholder="Masukkan Email"
                required
              >
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              class="btn btn-primary w-100"
              :disabled="isLoading"
            >
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
              Submit
            </button>

            <!-- Back to Login Link -->
            <div class="text-center mt-3">
              <router-link to="/" class="text-decoration-none">
                Kembali ke halaman login
              </router-link>
            </div>
          </form>
        </section>
      </div>

      <!-- Notification Component -->
      <Notification
        v-if="showNotification"
        :message="notificationMessage"
        @close="showNotification = false"
      />
    </main>
  </template>

  <script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Notification from '@/components/modals/Notifikasi.vue';
import logoImage from '@/assets/img/wa.jpg'
import logoIcon from '@/assets/img/logo-konek.png'

export default {
  name: 'LupaPassword',
  components: {
    Notification
  },
  setup() {
    const router = useRouter();
    const email = ref('');
    const isLoading = ref(false);
    const errorMessage = ref('');
    const successMessage = ref('');
    const showNotification = ref(false);
    const notificationMessage = ref('');

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
        successMessage.value = '';

        const response = await fetch('http://127.0.0.1:8000/api/forgot-password', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          body: JSON.stringify({ email: email.value })
        });

        const data = await response.json();

        if (response.ok) {
          successMessage.value = data.message || 'Link reset password telah dikirim ke email Anda.';
          const sentEmail = email.value; // Store email before clearing
          email.value = ''; // Clear the input
          // Store email and token in localStorage instead of passing in URL query
          localStorage.setItem('resetEmail', sentEmail);
          localStorage.setItem('resetToken', data.token);
          router.push({ name: 'tokenlupapassword' });
        } else {
          errorMessage.value = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
        }
      } catch (error) {
        console.error('Forgot password error:', error);
        errorMessage.value = 'Terjadi kesalahan. Silakan coba lagi.';
      } finally {
        isLoading.value = false;
      }
    };

    return {
      email,
      isLoading,
      errorMessage,
      successMessage,
      showNotification,
      notificationMessage,
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
