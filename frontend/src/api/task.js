import api from '@/api';

export function getTasks(params = {}) {
  return api.get('/tasks', { params });
}

export function getTask(id) {
  return api.get(`/tasks/${id}`);
}

export function createTask(task) {
  return api.post('/tasks', task);
}