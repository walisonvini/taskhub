<template>
   <div id="app" class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
html, body, #app {
  margin: 0;
  padding: 0;
  min-height: 100vh;
}
</style>
