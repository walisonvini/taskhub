<template>
  <div class="flex flex-col">
    <Label 
      v-if="label" 
      :for-id="id" 
      :required="required"
      :size="labelSize"
    >
      {{ label }}
    </Label>
    <select
      :id="id"
      :value="modelValue"
      :required="required"
      :disabled="disabled"
      :class="selectClass"
      @change="$emit('update:modelValue', $event.target.value)"
      @focus="$emit('focus', $event)"
      @blur="$emit('blur', $event)"
    >
      <option 
        v-if="placeholder" 
        value=""
        disabled
      >
        {{ placeholder }}
      </option>
      <slot />
    </select>
  </div>
</template>

<script>
import Label from './Label.vue';

export default {
  name: 'UiSelect',
  components: {
    Label
  },
  props: {
    modelValue: {
      type: [String, Number],
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    required: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    id: {
      type: String,
      default: ''
    },
    size: {
      type: String,
      default: 'md',
      validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    labelSize: {
      type: String,
      default: 'md',
      validator: (value) => ['sm', 'md', 'lg'].includes(value)
    }
  },
  emits: ['update:modelValue', 'focus', 'blur'],
  computed: {
    selectClass() {
      const baseClasses = 'border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white transition-colors';
      
      const sizeClasses = {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2.5 text-sm',
        lg: 'px-5 py-3.5 text-base'
      };
      
      const stateClasses = this.disabled
        ? 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed'
        : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary/20';
      
      return [
        baseClasses,
        sizeClasses[this.size],
        stateClasses
      ].join(' ');
    }
  }
}
</script>
