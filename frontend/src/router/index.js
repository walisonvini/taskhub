import Login from '../views/auth/Login.vue';

export default [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
];
