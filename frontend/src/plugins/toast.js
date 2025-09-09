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
          replacePrevious: true,
          ...options
        });
      },
      
      error(message, options = {}) {
        return initToast().addToast({
          type: 'error',
          message,
          replacePrevious: true,
          ...options
        });
      },
      
      warning(message, options = {}) {
        return initToast().addToast({
          type: 'warning',
          message,
          replacePrevious: true,
          ...options
        });
      },
      
      info(message, options = {}) {
        return initToast().addToast({
          type: 'info',
          message,
          replacePrevious: true,
          ...options
        });
      },
      
      show(type, message, options = {}) {
        return initToast().addToast({
          type,
          message,
          replacePrevious: true,
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
