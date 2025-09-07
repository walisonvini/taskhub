<template>
  <div>
    <h1>Home</h1>
    <p>Usuário: {{ user }}</p>
    <p>Autenticado: {{ isAuthenticated }}</p>
  </div>
</template>

<script>
export default {
  name: "HomePage",
  computed: {
    user() {
      return this.$store.getters.getUser;
    },
    isAuthenticated() {
      return this.$store.getters.isAuthenticated;
    }
  }
};
</script>
