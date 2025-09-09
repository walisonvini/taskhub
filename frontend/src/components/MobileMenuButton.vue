<template>
  <button
    @click="$emit('open')"
    class="lg:hidden fixed top-20 left-4 z-50 p-2 rounded-md bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
  >
    <Icon icon="mdi:menu" class="text-xl" />
  </button>
</template>

<script>
import { Icon } from '@iconify/vue2'

export default {
  name: 'MobileMenuButton',
  components: {
    Icon
  },
  emits: ['open']
}
</script>
