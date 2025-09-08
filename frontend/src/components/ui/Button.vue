<template>
  <button
    :type="type"
    :disabled="disabled"
    :class="buttonClass"
    @click="$emit('click', $event)"
  >
    <slot />
  </button>
</template>

<script>
export default {
  name: 'UiButton',
  props: {
    type: {
      type: String,
      default: 'button',
      validator: (value) => ['button', 'submit', 'reset'].includes(value)
    },
    variant: {
      type: String,
      default: 'primary',
      validator: (value) => ['primary', 'secondary', 'outline', 'ghost', 'danger'].includes(value)
    },
    size: {
      type: String,
      default: 'md',
      validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    disabled: {
      type: Boolean,
      default: false
    },
    fullWidth: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    buttonClass() {
      const baseClasses = 'inline-flex items-center justify-center font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900';
      
      const sizeClasses = {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-sm',
        lg: 'px-6 py-3 text-base'
      };
      
      const variantClasses = {
        primary: 'text-white bg-primary hover:bg-primary/90 focus:ring-primary border border-transparent',
        secondary: 'text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-gray-500 border border-gray-300 dark:border-gray-600',
        outline: 'text-primary dark:text-primary bg-transparent hover:bg-primary/10 dark:hover:bg-primary/20 focus:ring-primary border border-primary dark:border-primary',
        ghost: 'text-primary dark:text-primary bg-transparent hover:bg-primary/10 dark:hover:bg-primary/20 focus:ring-primary border border-transparent',
        danger: 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500 border border-transparent'
      };
      
      const disabledClasses = this.disabled 
        ? 'opacity-50 cursor-not-allowed' 
        : 'cursor-pointer';
        
      const widthClasses = this.fullWidth ? 'w-full' : '';
      
      return [
        baseClasses,
        sizeClasses[this.size],
        variantClasses[this.variant],
        disabledClasses,
        widthClasses
      ].join(' ');
    }
  }
}
</script>
