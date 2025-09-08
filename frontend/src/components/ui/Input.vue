<template>
  <input
    :type="type"
    :value="value"
    :placeholder="placeholder"
    :class="['block w-full border rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none dark:bg-gray-800 dark:text-white transition-colors px-4 py-2.5 text-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white hover:border-primary/50 focus:border-primary focus:ring-2 focus:ring-primary/20', extraClass]"
    @input="$emit('input', $event.target.value)"
  />
</template>

<script>
export default {
  name: 'UiInput',
  props: {
    value: { type: [String, Number], default: '' },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    extraClass: { type: String, default: '' }
  }
}
</script>
