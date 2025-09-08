<template>
  <select
    :value="value"
    :class="[
      'block w-full border rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none dark:bg-gray-800 dark:text-white transition-colors px-4 py-2.5 text-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white hover:border-primary/50 focus:border-primary focus:ring-2 focus:ring-primary/20',
      extraClass
    ]"
    @change="$emit('input', $event.target.value)"
  >
    <slot />
  </select>
</template>

<script>
export default {
  name: 'UiSelect',
  props: {
    type: Boolean,
    value: { type: [String, Number], default: '' },
    extraClass: { type: String, default: '' }
  }
}
</script>
