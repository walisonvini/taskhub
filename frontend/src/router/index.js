import Vue from 'vue'
import VueRouter from 'vue-router'

import { authGuard } from '@/router/guards';

import AuthLayout from '@/layouts/AuthLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';

import Login from '@/views/auth/Login.vue';
import Home from '@/views/Home.vue';
import Tasks from '@/views/tasks';

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: '/login', name: 'login', component: Login},
      { path: '', redirect: 'login' },
    ]
  },
  
  {
    path: '/dashboard',
    component: AuthLayout,
    children: [
      { path: 'home', name: 'home', component: Home },
      { path: '', redirect: 'home' },
      { path: 'tasks', name: 'tasks.index', component: Tasks.index },
      { path: 'tasks/create', name: 'tasks.create', component: Tasks.create },
    ]
  },
];

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach(authGuard)

export default router
