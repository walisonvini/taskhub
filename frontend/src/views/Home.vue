<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6">
    <!-- Header com saudação e horário -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            {{ greeting }}, {{ userName }}!
          </h1>
          <p class="text-gray-600 dark:text-gray-400">
            {{ currentDate }}
          </p>
        </div>
        
        <div class="text-right">
          <div class="text-2xl font-mono font-bold text-primary dark:text-primary">
            {{ currentTime }}
          </div>
          <div class="text-sm text-gray-500 dark:text-gray-400">
            Horário atual
          </div>
        </div>
      </div>
    </div>

    <!-- Ações rápidas -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Ações Rápidas</h2>
      <div class="flex flex-col sm:flex-row gap-4">
        <Button
          @click="$router.push({ name: 'tasks.create' })"
          variant="primary"
          size="md"
          class="flex-1 sm:flex-none"
        >
          <Icon icon="mdi:plus" class="w-5 h-5 mr-2" />
          Nova Tarefa
        </Button>
        
        <Button
          @click="$router.push({ name: 'tasks.index' })"
          variant="secondary"
          size="md"
          class="flex-1 sm:flex-none"
        >
          <Icon icon="mdi:clipboard-list" class="w-5 h-5 mr-2" />
          Ver Todas as Tarefas
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import Button from '@/components/ui/Button.vue';
import { Icon } from '@iconify/vue2';

export default {
  name: "HomePage",
  components: {
    Button,
    Icon
  },
  data() {
    return {
      currentTime: '',
      currentDate: '',
      totalTasks: 0,
      pendingTasks: 0,
      completedTasks: 0,
      timeInterval: null
    }
  },
  computed: {
    user() {
      return this.$store.getters.getUser;
    },
    userName() {
      return this.user?.name || 'Usuário';
    },
    greeting() {
      const hour = new Date().getHours();
      if (hour < 12) return 'Bom dia';
      if (hour < 18) return 'Boa tarde';
      return 'Boa noite';
    }
  },
  methods: {
    updateTime() {
      const now = new Date();
      this.currentTime = now.toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      this.currentDate = now.toLocaleDateString('pt-BR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
  },
  mounted() {
    this.updateTime();
    
    // Atualizar horário a cada segundo
    this.timeInterval = setInterval(this.updateTime, 1000);
  },
  beforeDestroy() {
    if (this.timeInterval) {
      clearInterval(this.timeInterval);
    }
  }
};
</script>
