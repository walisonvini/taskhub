<template>
  <div class="flex h-screen">
    <AppSidebar ref="sidebar" />
    <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
      <AppHeader 
        :is-menu-open="sidebarOpen"
        @open-menu="openSidebar"
      />
      <main class="flex-1 overflow-auto p-6">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
import AppSidebar from '@/components/AppSidebar.vue'
import AppHeader from '@/components/AppHeader.vue'

export default {
  name: "AuthLayout",
  components: {
    AppSidebar,
    AppHeader
  },
  data() {
    return {
      sidebarOpen: false
    }
  },
  methods: {
    openSidebar() {
      this.sidebarOpen = true
      if (this.$refs.sidebar) {
        this.$refs.sidebar.openSidebar()
      }
    }
  }
};
</script>
