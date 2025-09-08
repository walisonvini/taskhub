import api from '@/api';

export function getTasks() {
  return api.get('/tasks');
}

export function getTask(id) {
  return api.get(`/tasks/${id}`);
}

export function createTask(task) {
  return api.post('/tasks', task);
}