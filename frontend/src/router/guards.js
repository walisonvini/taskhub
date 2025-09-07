import axios from 'axios';

export async function authGuard(to, from, next) {
  const token = localStorage.getItem('access_token');

  if (to.path.startsWith('/dashboard')) {
    if (!token) {
      return next('/login');
    }

    try {
      await axios.get('/api/me', {
        headers: { Authorization: `Bearer ${token}` }
      });
      return next();
    } catch (err) {
      localStorage.removeItem('access_token');
      return next('/login');
    }
  }

  return next();
}
