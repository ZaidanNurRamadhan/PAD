import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// Import ikon yang diperlukan
import {
  faHome,
  faCashRegister,
  faWarehouse,
  faChartLine,
  faTruck,
  faStore,
  faUsersCog,
  faSignOutAlt,
  faReceipt,      // Jika masih ingin pakai ikon lama untuk transaksi
  faFileAlt,      // Jika masih ingin pakai ikon lama untuk laporan
  faCog,           // Jika masih ingin pakai ikon lama untuk settings
  faAngleRight
} from '@fortawesome/free-solid-svg-icons'

// Tambahkan ikon ke library Font Awesome
library.add(
  faHome,
  faCashRegister,
  faWarehouse,
  faChartLine,
  faTruck,
  faStore,
  faUsersCog,
  faSignOutAlt,
  faReceipt,
  faFileAlt,
  faCog,
  faAngleRight
)

createApp(App).component('font-awesome-icon', FontAwesomeIcon).use(router).mount('#app')
