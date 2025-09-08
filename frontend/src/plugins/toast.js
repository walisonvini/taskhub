import Vue from 'vue';
import ToastContainer from '@/components/ui/ToastContainer.vue';

let toastContainer = null;

function initToast() {
  if (!toastContainer) {
    const ToastContainerClass = Vue.extend(ToastContainer);
    toastContainer = new ToastContainerClass();
    toastContainer.$mount();
    document.body.appendChild(toastContainer.$el);
  }
  return toastContainer;
}

const ToastPlugin = {
  install(Vue) {
    initToast();
    
    Vue.prototype.$toast = {
      success(message, options = {}) {
        return initToast().addToast({
          type: 'success',
          message,
          ...options
        });
      },
      
      error(message, options = {}) {
        return initToast().addToast({
          type: 'error',
          message,
          ...options
        });
      },
      
      warning(message, options = {}) {
        return initToast().addToast({
          type: 'warning',
          message,
          ...options
        });
      },
      
      info(message, options = {}) {
        return initToast().addToast({
          type: 'info',
          message,
          ...options
        });
      },
      
      show(type, message, options = {}) {
        return initToast().addToast({
          type,
          message,
          ...options
        });
      },
      
      clear() {
        initToast().clearAll();
      }
    };
  }
};

export default ToastPlugin;
