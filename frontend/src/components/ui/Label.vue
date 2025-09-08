<template>
  <label 
    :for="forId"
    :class="labelClass"
  >
    <slot />
  </label>
</template>

<script>
export default {
  name: 'UiLabel',
  props: {
    forId: {
      type: String,
      default: ''
    },
    size: {
      type: String,
      default: 'md',
      validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    required: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    labelClass() {
      const baseClasses = 'block font-medium text-gray-700 dark:text-gray-300';
      
      const sizeClasses = {
        sm: 'text-xs mb-1',
        md: 'text-sm mb-1',
        lg: 'text-base mb-2'
      };
      
      const requiredClasses = this.required ? 'after:content-["*"] after:text-red-500 after:ml-1' : '';
      
      return [
        baseClasses,
        sizeClasses[this.size],
        requiredClasses
      ].join(' ');
    }
  }
}
</script>
