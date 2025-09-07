import store from '@/store';
import { me } from '@/api/auth';

export async function authGuard(to, from, next) {
  const token = localStorage.getItem('token')

  if (to.path.startsWith('/dashboard')) {
    if (!token) {
      return next('/login')
    }

    try {
      if (!store.getters.getUser) {
        const { data } = await me();
        store.commit('SET_USER', data.data.user)
      }
      return next()
    } catch (err) {
      store.commit('SET_TOKEN', null)
      store.commit('SET_USER', null)
      return next('/login')
    }
  }

  if (to.path === '/login' && token) {
    return next('/dashboard/home')
  }

  return next()
}
