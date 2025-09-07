<template>
  <header class="bg-white dark:bg-gray-900 shadow-sm px-6 py-4">
    <div class="flex items-center justify-between">
      <!-- Company Name -->
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
          {{ companyName }}
        </h1>
      </div>

      <!-- User Menu -->
      <div class="flex items-center space-x-3">
        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ userName }}</p>
        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
          <Icon icon="mdi:account" class="text-sm text-gray-700 dark:text-gray-300" />
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { Icon } from '@iconify/vue2'

export default {
  name: 'AppHeader',
  components: {
    Icon
  },
  computed: {
    userName() {
      return this.$store.getters.getUser?.name || 'Usuário'
    },
    companyName() {
      return this.$store.getters.getUser?.company?.name || 'Empresa'
    }
  }
}
</script>
