<!-- TokenVerification.vue -->
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
            <form @submit.prevent="submitToken" class="login-form">
              <div class="form-group text-center">
                <img :src="logoKonek" alt="logo" class="icon-login">
                <h1>Verifikasi Kode</h1>
                <p class="fw-light mb-0">Masukkan kode yang diterima di email Anda</p>
              </div>
              <input type="hidden" v-model="email">
              <input type="hidden" v-model="tokenValue">
              <div class="mb-3">
                <label class="m-0" for="token">Masukkan kode verifikasi</label>
                <input
                  type="text"
                  v-model="token"
                  class="form-control"
                  id="token"
                  placeholder="Masukkan Kode Verifikasi"
                  required
                >
              </div>
              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
          </section>
        </div>
      </main>
    </div>
  </template>

  <script>
  export default {
    name: 'TokenLupaPassword',
    props: {
      initialEmail: {
        type: String,
        default: ''
      },
      initialToken: {
        type: String,
        default: ''
      }
    },
    data() {
      return {
        email: this.initialEmail,
        tokenValue: this.initialToken,
        token: '',
        notification: null,
        logoUtama: '/assets/img/wa.jpg',
        logoKonek: '/assets/img/logo-konek.png'
      }
    },
    methods: {
      submitToken() {
        // Replace with your API call logic using axios, fetch or any HTTP client
        this.$axios.post('/api/password/token/submit', {
          email: this.email,
          token: this.token,
          tokenValue: this.tokenValue
        })
        .then(response => {
          // Handle success
          this.notification = {
            type: 'success',
            message: 'Kode verifikasi berhasil divalidasi.'
          }
          // Redirect to password reset page or handle as needed
          this.$router.push({
            name: 'password.reset',
            query: { email: this.email, token: this.tokenValue }
          })
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
  /* You can import your form.css here or define styles directly */
  .notification {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
  }

  .notification.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .notification.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  /* Add more styles as needed */
  </style>
