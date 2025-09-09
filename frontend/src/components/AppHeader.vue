<template>
  <header class="bg-white dark:bg-gray-900 shadow-sm px-6 py-4 relative z-30">
    <div class="flex items-center justify-between">
      <!-- Company Name and Mobile Menu Button -->
      <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
          {{ companyName }}
        </h1>
        <!-- Mobile Menu Button -->
        <button
          v-if="isMobile"
          @click="$emit('open-menu')"
          class="lg:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
        >
          <Icon icon="mdi:menu" class="text-xl" />
        </button>
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
  props: {
    isMenuOpen: {
      type: Boolean,
      default: false
    }
  },
  emits: ['open-menu'],
  computed: {
    userName() {
      return this.$store.getters.getUser?.name || 'Usuário'
    },
    companyName() {
      return this.$store.getters.getUser?.company?.name || 'Empresa'
    },
    isMobile() {
      return window.innerWidth < 1024
    }
  }
}
</script>
