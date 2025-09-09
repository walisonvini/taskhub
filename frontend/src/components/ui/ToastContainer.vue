<template>
  <div class="fixed top-4 right-4 z-50">
    <transition
      name="toast-fade"
      mode="out-in"
      appear
    >
      <Toast
        v-if="currentToast"
        :key="currentToast.id"
        :type="currentToast.type"
        :message="currentToast.message"
        :duration="currentToast.duration"
        :closable="currentToast.closable"
        @close="removeCurrentToast"
      />
    </transition>
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
      currentToast: null,
      nextId: 1,
      timeout: null
    }
  },
  computed: {
    hasToast() {
      return this.currentToast !== null;
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
      
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }
      
      this.currentToast = newToast;
      
      if (newToast.duration > 0) {
        this.timeout = setTimeout(() => {
          this.removeCurrentToast();
        }, newToast.duration);
      }
      
      return id;
    },
    removeCurrentToast() {
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }
      this.currentToast = null;
    },
    clearAll() {
      this.removeCurrentToast();
    }
  },
  beforeDestroy() {
    if (this.timeout) {
      clearTimeout(this.timeout);
    }
  }
}
</script>

<style scoped>
.toast-fade-enter-active {
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.toast-fade-leave-active {
  transition: all 0.2s ease-out;
}

.toast-fade-enter {
  transform: translateX(100%);
  opacity: 0;
}

.toast-fade-enter-to {
  transform: translateX(0);
  opacity: 1;
}

.toast-fade-leave {
  transform: translateX(0);
  opacity: 1;
}

.toast-fade-leave-to {
  transform: translateX(0);
  opacity: 0;
}
</style>
