<template>
  <div>
    <!-- Mobile overlay -->
    <div 
      v-if="isOpen && isMobile" 
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
      @click="closeSidebar"
    ></div>
    
    <!-- Sidebar -->
    <div 
      :class="sidebarClasses"
    >
      <!-- Close button for mobile - positioned absolutely -->
      <button 
        v-if="isMobile"
        @click="closeSidebar"
        class="lg:hidden absolute top-4 right-4 z-10 p-2 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-white dark:bg-gray-800 shadow-sm"
      >
        <Icon icon="mdi:close" class="text-xl" />
      </button>
      
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
        <li v-for="item in navigationItems" :key="item.name">
          <router-link 
            :to="item.to" 
            class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors"
            :class="{ 'bg-primary/10 text-primary dark:text-primary': isActiveRoute(item) }"
            active-class="bg-primary/10 text-primary dark:text-primary"
          >
            <Icon :icon="item.icon" class="mr-3 text-lg" />
            {{ item.name }}
          </router-link>
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
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ userName }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ userEmail }}</p>
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
  data() {
    return {
      isOpen: false,
      navigationItems: [
        {
          name: 'Home',
          to: '/dashboard/home',
          icon: 'mdi:view-grid'
        },
        {
          name: 'Tarefas',
          to: '/dashboard/tasks',
          icon: 'mdi:clipboard-list'
        },
        {
          name: 'Exportações',
          to: '/dashboard/task-exports',
          icon: 'mdi:file-export'
        }
      ]
    }
  },
  computed: {
    userName() {
      return this.$store.getters.getUser?.name || 'Usuário'
    },
    userEmail() {
      return this.$store.getters.getUser?.email || 'user@email.com'
    },
    isMobile() {
      return window.innerWidth < 1024
    },
    sidebarClasses() {
      const baseClasses = 'h-screen bg-white dark:bg-gray-800 shadow-lg flex flex-col transition-transform duration-300 ease-in-out z-50'
      const widthClasses = this.isMobile ? 'fixed top-0 left-0 w-64' : 'w-64'
      const transformClasses = this.isMobile && !this.isOpen ? '-translate-x-full' : 'translate-x-0'
      
      return `${baseClasses} ${widthClasses} ${transformClasses}`
    }
  },
  mounted() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    isActiveRoute(item) {
      const currentPath = this.$route.path;
      
      if (item.to === '/dashboard') {
        return currentPath === '/dashboard' || currentPath === '/dashboard/home';
      }
      
      return currentPath.startsWith(item.to);
    },
    handleResize() {
      this.$forceUpdate()
    },
    closeSidebar() {
      this.isOpen = false
    },
    openSidebar() {
      this.isOpen = true
    },
    toggleSidebar() {
      this.isOpen = !this.isOpen
    },
    async logout() {
      await logout();
      this.$store.dispatch('logout');
      this.$router.push('/login');
    }
  }
}
</script>
