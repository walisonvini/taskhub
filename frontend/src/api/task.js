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

export function updateTask(id, task) {
  return api.put(`/tasks/${id}`, task);
}

export function deleteTask(id) {
  return api.delete(`/tasks/${id}`);
}

export function completeTask(id) {
  return api.patch(`/tasks/${id}/complete`);
}