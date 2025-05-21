<template>
  <div id="app">
    <main>
      <router-view></router-view> <!-- Menambahkan router-view untuk menampilkan komponen yang sesuai -->
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      message: 'Hello, Vue!'
    }
  },
  methods: {
    changeMessage() {
      this.message = 'You clicked the button!';
    }
  }
}
</script>

<style scoped>
/* Styling tetap seperti semula */
</style>
