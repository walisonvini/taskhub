import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../views/auth/Login.vue';
import Home from '../views/Home.vue';
import AuthLayout from '../layouts/AuthLayout.vue';
import AppLayout from '../layouts/AppLayout.vue';
import { authGuard } from './guards';

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: 'login', component: Login, alias: '/login' },
      { path: '', redirect: 'login' },
    ]
  },
  
  {
    path: '/dashboard',
    component: AuthLayout,
    children: [
      { path: '', redirect: 'home' },
      { path: 'home', component: Home },
    ]
  },
];

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach(authGuard)

export default router
