import api from '@/api';

export function getTaskExports() {
  return api.get('/task-exports');
}

export function createTaskExport(filters) {
  return api.post('/task-exports', { filters });
}

export function downloadTaskExport(id) {
  return api.get(`/task-exports/${id}/download`, {
    responseType: 'blob'
  });
}