<template>
  <div class="w-64 h-screen bg-white dark:bg-gray-800 shadow-lg flex flex-col">
    <!-- Logo/Header -->
    <div class="p-6">
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">
        TaskHub
      </h1>
      <div class="mt-4 border-b border-gray-200 dark:border-gray-700 mx-4"></div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4">
      <ul class="space-y-2">
        <li>
          <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
            <Icon icon="mdi:view-dashboard" class="mr-3 text-lg" />
            Dashboard
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
            <Icon icon="mdi:clipboard-list" class="mr-3 text-lg" />
            Tarefas
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
            <Icon icon="mdi:account-group" class="mr-3 text-lg" />
            Equipe
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
            <Icon icon="mdi:cog" class="mr-3 text-lg" />
            Configurações
          </a>
        </li>
      </ul>
    </nav>

    <!-- User info / Logout -->
    <div class="p-4">
      <div class="border-t border-gray-200 dark:border-gray-700 mx-4 mb-4"></div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
            <Icon icon="mdi:account" class="text-sm text-gray-700 dark:text-gray-300" />
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900 dark:text-white">Usuário</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">user@email.com</p>
          </div>
        </div>
        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
          <a href="#" @click="logout">
            <Icon icon="mdi:logout" class="text-lg" />
          </a>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { Icon } from '@iconify/vue2'
import { logout } from '@/api/auth';

export default {
  name: 'AppSidebar',
  components: {
    Icon
  },
  methods: {
    async logout() {
      await logout();
      this.$store.dispatch('logout');
      this.$router.push('/login');
    }
  }
}
</script>
