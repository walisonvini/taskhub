<template>
  <div
    v-if="visible"
    class="fixed top-4 right-4 z-50 max-w-sm w-full"
    :class="toastClasses"
  >
    <div class="flex items-start p-4 rounded-lg shadow-lg border">
      <div class="flex-shrink-0 mr-3">
        <div :class="iconClasses">
          {{ icon }}
        </div>
      </div>
      
      <div class="flex-1 min-w-0">
        <p class="text-sm font-medium" :class="textClasses">
          {{ message }}
        </p>
      </div>
      
      <div class="flex-shrink-0 ml-3">
        <button
          @click="close"
          class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
          :class="closeButtonClasses"
        >
          <span class="sr-only">Fechar</span>
          <Icon icon="mdi:close" class="h-4 w-4" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { Icon } from '@iconify/vue2';

export default {
  name: 'UiToast',
  components: {
    Icon
  },
  props: {
    type: {
      type: String,
      default: 'info',
      validator: (value) => ['success', 'error', 'warning', 'info'].includes(value)
    },
    message: {
      type: String,
      required: true
    },
    duration: {
      type: Number,
      default: 5000
    },
    closable: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      visible: true
    }
  },
  computed: {
    icon() {
      const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
      };
      return icons[this.type];
    },
    toastClasses() {
      const baseClasses = 'transform transition-all duration-300 ease-in-out';
      const typeClasses = {
        success: 'bg-green-50 dark:bg-green-900/80 border-green-200 dark:border-green-700',
        error: 'bg-red-50 dark:bg-red-900/80 border-red-200 dark:border-red-700',
        warning: 'bg-yellow-50 dark:bg-yellow-900/80 border-yellow-200 dark:border-yellow-700',
        info: 'bg-blue-50 dark:bg-blue-900/80 border-blue-200 dark:border-blue-700'
      };
      return [baseClasses, typeClasses[this.type]].join(' ');
    },
    iconClasses() {
      const baseClasses = 'flex items-center justify-center w-6 h-6 rounded-full text-sm font-bold';
      const typeClasses = {
        success: 'bg-green-100 dark:bg-green-800/90 text-green-600 dark:text-green-200',
        error: 'bg-red-100 dark:bg-red-800/90 text-red-600 dark:text-red-200',
        warning: 'bg-yellow-100 dark:bg-yellow-800/90 text-yellow-600 dark:text-yellow-200',
        info: 'bg-blue-100 dark:bg-blue-800/90 text-blue-600 dark:text-blue-200'
      };
      return [baseClasses, typeClasses[this.type]].join(' ');
    },
    textClasses() {
      const typeClasses = {
        success: 'text-green-800 dark:text-green-200',
        error: 'text-red-800 dark:text-red-200',
        warning: 'text-yellow-800 dark:text-yellow-200',
        info: 'text-blue-800 dark:text-blue-200'
      };
      return typeClasses[this.type];
    },
    closeButtonClasses() {
      const typeClasses = {
        success: 'text-green-400 hover:text-green-600 hover:bg-green-100 dark:hover:bg-green-800 focus:ring-green-500',
        error: 'text-red-400 hover:text-red-600 hover:bg-red-100 dark:hover:bg-red-800 focus:ring-red-500',
        warning: 'text-yellow-400 hover:text-yellow-600 hover:bg-yellow-100 dark:hover:bg-yellow-800 focus:ring-yellow-500',
        info: 'text-blue-400 hover:text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-800 focus:ring-blue-500'
      };
      return typeClasses[this.type];
    }
  },
  methods: {
    close() {
      this.visible = false;
      this.$emit('close');
    }
  }
}
</script>
