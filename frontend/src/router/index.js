import Vue from 'vue'
import VueRouter from 'vue-router'

import { authGuard } from '@/router/guards';

import AuthLayout from '@/layouts/AuthLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';

import Login from '@/views/auth/Login.vue';
import Home from '@/views/Home.vue';
import Tasks from '@/views/tasks';
import TaskExports from '@/views/task-exports';

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
      { path: 'tasks/:id', name: 'tasks.show', component: Tasks.show },
      { path: 'tasks/:id/edit', name: 'tasks.edit', component: Tasks.edit },

      { path: 'task-exports', name: 'task-exports.index', component: TaskExports.index },
    ]
  },
];

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach(authGuard)

export default router
