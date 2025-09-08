<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Detalhes da Tarefa</h1>
          <p class="text-gray-600 dark:text-gray-400">Visualize os detalhes da sua tarefa</p>
        </div>
        
        <Button
          @click="$router.push({ name: 'tasks.index' })"
          variant="secondary"
          size="md"
        >
          Voltar
        </Button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-8">
      <div class="text-gray-500 dark:text-gray-400">Carregando tarefa...</div>
    </div>

    <!-- Task Details -->
    <div v-else-if="task" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
      <div class="space-y-6">
        <!-- Title -->
        <div>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ task.title }}</h2>
        </div>

        <!-- Description -->
        <div v-if="task.description">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Descrição</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ task.description }}</p>
        </div>

        <!-- Status and Priority -->
        <div class="flex flex-wrap gap-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Status</h3>
            <Badge 
              :text="task.status"
              type="status"
              :value="task.status"
            />
          </div>
          
          <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Prioridade</h3>
            <Badge 
              :text="task.priority"
              type="priority"
              :value="task.priority"
            />
          </div>
        </div>

        <!-- Due Date -->
        <div v-if="task.due_date">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Data Limite</h3>
          <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
            <Icon icon="mdi:calendar" class="w-5 h-5" />
            <span>{{ formatDate(task.due_date) }}</span>
          </div>
        </div>

        <!-- Created and Updated dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ formatDate(task.created_at) }}</p>
          </div>
          
          <div v-if="task.updated_at !== task.created_at">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ formatDate(task.updated_at) }}</p>
          </div>
        </div>

        <!-- Action Button -->
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
          <Button
            @click="deliverTask"
            variant="primary"
            size="md"
            :disabled="task.status === 'concluída'"
            class="w-full sm:w-auto"
          >
            <Icon icon="mdi:check-circle" class="w-5 h-5 mr-2" />
            {{ task.status === 'concluída' ? 'Tarefa Entregue' : 'Entregar Tarefa' }}
          </Button>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="text-center py-8">
      <div class="text-gray-500 dark:text-gray-400">
        Tarefa não encontrada.
      </div>
    </div>

    <!-- Modal de confirmação para entregar tarefa -->
    <UiModal
      :show="showDeliverModal"
      title="Entregar Tarefa"
      :message="deliverModalMessage"
      confirm-text="Entregar"
      confirm-variant="primary"
      @close="closeDeliverModal"
      @confirm="confirmDeliver"
    />
  </div>
</template>

<script>
import Button from '@/components/ui/Button.vue';
import Badge from '@/components/ui/Badge.vue';
import UiModal from '@/components/ui/Modal.vue';
import { Icon } from '@iconify/vue2';
import { getTask, completeTask } from '@/api/task';

export default {
  name: "TasksShow",
  components: {
    Button,
    Badge,
    UiModal,
    Icon
  },
  data() {
    return {
      task: null,
      loading: false,
      showDeliverModal: false
    }
  },
  computed: {
    deliverModalMessage() {
      if (this.task) {
        return `Tem certeza que deseja entregar a tarefa "${this.task.title}"? Esta ação marcará a tarefa como concluída.`;
      }
      return '';
    }
  },
  methods: {
    async loadTask() {
      this.loading = true;
      try {
        const taskId = this.$route.params.id;
        const response = await getTask(taskId);
        this.task = response.data.data.task;
      } catch (error) {
        console.error('Erro ao carregar tarefa:', error);
        this.$toast.error('Erro ao carregar tarefa');
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    deliverTask() {
      if (this.task.status === 'concluída') {
        this.$toast.info('Esta tarefa já foi entregue!');
        return;
      }
      
      this.showDeliverModal = true;
    },
    closeDeliverModal() {
      this.showDeliverModal = false;
    },
    async confirmDeliver() {
      try {
        const taskId = this.$route.params.id;
        await completeTask(taskId);
        this.$toast.success('Tarefa entregue com sucesso!');
        this.closeDeliverModal();
        // Recarregar os dados da tarefa
        this.loadTask();
      } catch (error) {
        console.error('Erro ao entregar tarefa:', error);
        this.$toast.error('Erro ao entregar tarefa. Tente novamente.');
      }
    }
  },
  mounted() {
    this.loadTask();
  }
};
</script>
  