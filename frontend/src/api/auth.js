import api from './index';

export function login(credentials) {
  return api.post('/login', {
    email: credentials.email,
    password: credentials.password,
  });
}

export function me() {
  return api.post('/me');
}

export function logout() {
  return api.post('/logout');
}

export function refresh() {
  return api.post('/refresh');
}
