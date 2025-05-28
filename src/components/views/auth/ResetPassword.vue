<!-- PasswordReset.vue -->
<template>
    <div>
      <div v-if="notification" class="notification" :class="notification.type">
        {{ notification.message }}
      </div>

      <main class="container-fluid d-flex align-items-center">
        <div class="row flex-fill">
          <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
            <img :src="logoUtama" alt="logo" class="logo-utama">
          </aside>
          <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
            <form @submit.prevent="resetPassword" class="login-form">
              <div class="form-group text-center">
                <img :src="logoKonek" alt="logo" class="icon-login">
                <h1>Reset Password</h1>
                <p class="fw-light">Masukkan password baru</p>
              </div>
              <input type="hidden" v-model="email">
              <div class="mb-3">
                <label class="m-0" for="password">Password Baru</label>
                <input
                  type="password"
                  v-model="password"
                  class="form-control"
                  id="password"
                  placeholder="Masukkan Password"
                  required
                >
              </div>
              <div class="mb-3">
                <label class="m-0" for="password_confirmation">Konfirmasi Password Baru</label>
                <input
                  type="password"
                  v-model="passwordConfirmation"
                  class="form-control"
                  id="password_confirmation"
                  placeholder="Konfirmasi Password Baru"
                  required
                >
              </div>
              <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
          </section>
        </div>
      </main>
    </div>
  </template>

<script>
import axios from 'axios'

export default {
  name: 'PasswordReset',
  props: {
    initialEmail: {
      type: String,
      default: ''
    }
  },
    data() {
      return {
        email: this.initialEmail,
        password: '',
        passwordConfirmation: '',
        notification: null,
        logoUtama: '/assets/img/wa.jpg',
        logoKonek: '/assets/img/logo-konek.png'
      }
    },
    created() {
      // Get email from localStorage if not provided via props
      if (!this.email) {
        this.email = localStorage.getItem('resetEmail') || ''
      }
    },
    watch: {
      // Remove watcher on route query email since no longer used
      /*
      '$route.query.email'(newEmail) {
        this.email = newEmail || ''
      }
      */
    },
  methods: {
    resetPassword() {
      // Validate passwords match
      if (this.password !== this.passwordConfirmation) {
        this.notification = {
          type: 'error',
          message: 'Password tidak cocok. Silakan periksa kembali.'
        }
        return
      }

      // Replace with your API call logic
      axios.post('http://127.0.0.1:8000/api/reset-password', {
        email: this.email,
        password: this.password,
        password_confirmation: this.passwordConfirmation
      })
      .then(response => {
        // Handle success
        this.notification = {
          type: 'success',
          message: 'Password berhasil direset. Silakan login dengan password baru Anda.'
        }

        // Redirect to login page after a delay
        setTimeout(() => {
          this.$router.push({ name: 'login' })
        }, 2000)
      })
      .catch(error => {
        // Handle error
        this.notification = {
          type: 'error',
          message: error.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.'
        }
      })
    }
  }
}
</script>

  <style scoped>
@import '/src/assets/css/form.css';
  </style>
