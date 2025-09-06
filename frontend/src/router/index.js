import Login from '../views/auth/Login.vue';
import Home from '../views/Home.vue';
import AuthLayout from '../layouts/AuthLayout.vue';
import AppLayout from '../layouts/AppLayout.vue';

export default [
  { path: '/', redirect: '/login' },
  
  {
    path: '/app',
    component: AppLayout,
    children: [
      { path: 'login', component: Login, alias: '/login' }
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
