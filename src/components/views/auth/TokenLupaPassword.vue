<!-- TokenVerification.vue -->
<template>
  <main class="container-fluid d-flex align-items-center">
    <div class="row flex-fill">
      <!-- Left Side - Image -->
      <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
        <img :src="logoImage" alt="logo" class="logo-utama" />
      </aside>

      <!-- Right Side - Token Verification Form -->
      <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
        <form @submit.prevent="submitToken" class="login-form">
          <!-- Form Header -->
          <div class="form-group text-center">
            <img :src="logoIcon" alt="logo" class="icon-login" />
            <h1>Verifikasi Kode</h1>
            <p class="fw-light mb-0">Masukkan kode yang diterima di email Anda</p>
          </div>

          <!-- Notification -->
          <div v-if="showNotification" :class="['notification', notificationType]">
            {{ notificationMessage }}
          </div>

          <!-- Hidden Inputs -->
          <input type="hidden" :value="email" name="email"/>
          <input type="hidden" :value="token" name="token"/>

          <!-- Token Input -->
          <div class="mb-3">
            <label class="m-0" for="token">Masukkan kode verifikasi</label>
            <input
              type="text"
              v-model="token"
              class="form-control"
              id="token"
              placeholder="Masukkan Kode Verifikasi"
              required
            />
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
            <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
            Submit
          </button>

          <!-- Back to Login Link -->
          <div class="text-center mt-3">
            <router-link to="/" class="text-decoration-none">Kembali ke halaman login</router-link>
          </div>
        </form>
      </section>
    </div>
  </main>
</template>

<script>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import logoImage from '@/assets/img/wa.jpg'
import logoIcon from '@/assets/img/logo-konek.png'

export default {
  name: 'TokenLupaPassword',
  setup() {
    const route = useRoute()
    const router = useRouter()
    // Read email and token from localStorage instead of URL query
    const email = ref(localStorage.getItem('resetEmail') || '')
    const tokenValue = ref(localStorage.getItem('resetToken') || '')
    const token = ref('')
    const isLoading = ref(false)
    const showNotification = ref(false)
    const notificationMessage = ref('')
    const notificationType = ref('')

    const submitToken = async () => {
      isLoading.value = true
      showNotification.value = false
      notificationMessage.value = ''
      notificationType.value = ''

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/validate-token', {
          email: email.value,
          token: token.value
        })

        notificationMessage.value = 'Kode verifikasi berhasil divalidasi.'
        notificationType.value = 'success'
        showNotification.value = true

        // Store email and token in localStorage before redirecting
        localStorage.setItem('resetEmail', email.value)
        localStorage.setItem('resetToken', tokenValue.value)

        // Redirect to reset password page without query params
        setTimeout(() => {
          router.push({ name: 'resetpassword' })
        }, 1500)
      } catch (error) {
        notificationMessage.value = error.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.'
        notificationType.value = 'error'
        showNotification.value = true
      } finally {
        isLoading.value = false
      }
    }

    return {
      email,
      tokenValue,
      token,
      isLoading,
      showNotification,
      notificationMessage,
      notificationType,
      logoImage,
      logoIcon,
      submitToken
    }
  }
}
</script>

<style scoped>
@import '/src/assets/css/form.css';
</style>
