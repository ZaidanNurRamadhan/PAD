import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '@/components/layouts/AuthLayout.vue';
import OwnerLayout from '@/components/layouts/OwnerLayout.vue';

import Login from '@/components/views/auth/Login.vue';
import LupaPassword from '@/components/views/auth/LupaPassword.vue';
import ResetPassword from '@/components/views/auth/ResetPassword.vue';
import TokenLupaPassword from '@/components/views/auth/TokenLupaPassword.vue';

import Dashboard from '@/components/views/owner/Dashboard.vue';
import ManajemenToko from '@/components/views/owner/ManajemenToko.vue';
import Gudang from '@/components/views/owner/Gudang.vue';
import Pemasok from '@/components/views/owner/Pemasok.vue';
import Settings from '@/components/views/owner/Settings.vue';
import Transaksi from '@/components/views/owner/Transaksi.vue';
import Monitoring from '@/components/views/owner/Monitoring.vue';
import Laporan from '@/components/views/owner/Laporan.vue';
import Transaksis from '@/components/views/karyawan/Transaksi.vue';
import Gudangs from '@/components/views/karyawan/Gudang.vue';


const routes = [
  {
    path: '/',
    component: AuthLayout,
    children: [
      {
        path : '',
        component : Login,
        name: 'login'
      },

      {
        path : 'forgot-password',
        component : LupaPassword
      },
      {
        path:'token-forgot-password',
        component: TokenLupaPassword,
        name: 'tokenlupapassword'
      },
      {
        path:'reset-password',
        component: ResetPassword,
        name: 'resetpassword'
      }
    ],
  },
  {
    path: '/',
    component: OwnerLayout,
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: 'gudang-owner',
        component: Gudang
      },
      {
        path: 'manajemen-toko',
        component: ManajemenToko
      },
      {
        path: 'pemasok',
        component: Pemasok
      },
      {
        path: 'settings',
        component: Settings
      },
      {
        path: 'transaksi-owner',
        component: Transaksi
      },
      {
        path: 'monitoring',
        component: Monitoring
      },
      {
        path: 'laporan',
        component: Laporan
      },
      {
        path: 'gudang-karyawan',
        component: Gudangs
      },
      {
        path: 'transaksi-karyawan',
        component: Transaksis
      },
    ]
  }
];

const router = createRouter({
  history: createWebHistory(''),
  routes,
});

export default router;
