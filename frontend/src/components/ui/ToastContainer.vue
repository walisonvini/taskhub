<template>
  <div class="fixed top-4 right-4 z-50 space-y-2">
    <Toast
      v-for="toast in toasts"
      :key="toast.id"
      :type="toast.type"
      :message="toast.message"
      :duration="toast.duration"
      :closable="toast.closable"
      @close="removeToast(toast.id)"
    />
  </div>
</template>

<script>
import Toast from './Toast.vue';

export default {
  name: 'ToastContainer',
  components: {
    Toast
  },
  data() {
    return {
      toasts: [],
      nextId: 1
    }
  },
  methods: {
    addToast(toast) {
      const id = this.nextId++;
      const newToast = {
        id,
        type: toast.type || 'info',
        message: toast.message,
        duration: toast.duration || 5000,
        closable: toast.closable !== false
      };
      
      this.toasts.push(newToast);
      
      if (newToast.duration > 0) {
        setTimeout(() => {
          this.removeToast(id);
        }, newToast.duration);
      }
      
      return id;
    },
    removeToast(id) {
      const index = this.toasts.findIndex(toast => toast.id === id);
      if (index > -1) {
        this.toasts.splice(index, 1);
      }
    },
    clearAll() {
      this.toasts = [];
    }
  }
}
</script>
