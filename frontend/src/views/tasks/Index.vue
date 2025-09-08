<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6">
    <div class="mb-6">
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <Button 
          @click="createTask"
          variant="primary"
          size="md"
        >
          Criar Tarefa
        </Button>

        <div class="flex flex-col sm:flex-row gap-3">

          <Select
            id="status"
            v-model="filters.status"
            label="Status"
          >
            <option value="">Todos os status</option>
            <option value="pendente">Pendente</option>
            <option value="em andamento">Em Andamento</option>
            <option value="concluída">Concluída</option>
          </Select>
          
          <Select
            id="priority"
            v-model="filters.priority"
            label="Prioridade"
          >
            <option value="">Todas as prioridades</option>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
          </Select>
        </div>
      </div>
    </div>
    
    <div v-if="loading" class="flex justify-center items-center py-8">
      <div class="text-gray-500 dark:text-gray-400">Carregando tarefas...</div>
    </div>

    <div v-else class="space-y-3">
      <TaskCard 
        v-for="task in tasks" 
        :key="task.id"
        :task="task"
        @view="handleViewTask"
        @edit="handleEditTask"
        @delete="handleDeleteTask"
        @toggle-complete="handleToggleComplete"
      />

      <div v-if="tasks.length === 0" class="text-center py-8">
        <div class="text-gray-500 dark:text-gray-400">
          Nenhuma tarefa encontrada.
        </div>
      </div>
    </div>

    <div v-if="!loading && tasks.length > 0" class="mt-8">
      <UiPagination
        :current-page="paginationData.currentPage"
        :total-pages="paginationData.totalPages"
        :total-items="paginationData.totalItems"
        :items-per-page="paginationData.itemsPerPage"
        @page-change="handlePageChange"
      />
    </div>

    <!-- Modal de confirmação -->
    <UiModal
      :show="showDeleteModal"
      title="Excluir Tarefa"
      :message="deleteModalMessage"
      confirm-text="Excluir"
      @close="closeDeleteModal"
      @confirm="confirmDelete"
    />
  </div>
</template>
  
<script>
import { getTasks, updateTask, deleteTask, completeTask } from '@/api/task';
import TaskCard from '@/components/TaskCard.vue';
import Button from '@/components/ui/Button.vue';
import Select from '@/components/ui/Select.vue';
import UiPagination from '@/components/Pagination.vue';
import UiModal from '@/components/ui/Modal.vue';

export default {
  name: "TasksIndex",
  components: {
    TaskCard,
    Button,
    Select,
    UiPagination,
    UiModal
  },
  data() {
    return {
      tasks: [],
      loading: false,
      filters: {
        status: '',
        priority: ''
      },
      paginationData: {
        currentPage: 1,
        totalPages: 1,
        totalItems: 0,
        itemsPerPage: 10
      },
      showDeleteModal: false,
      taskToDelete: null
    }
  },
  computed: {
    pagination() {
      return {
        currentPage: parseInt(this.$route.query.page) || 1,
        totalPages: 1,
        totalItems: 0,
        itemsPerPage: parseInt(this.$route.query.per_page) || 10
      }
    },
    deleteModalMessage() {
      if (this.taskToDelete) {
        return `Tem certeza que deseja excluir a tarefa "${this.taskToDelete.title}"? Esta ação não pode ser desfeita.`;
      }
      return '';
    }
  },
  methods: {
    createTask() {
      this.$router.push({ name: 'tasks.create' });
    },
    handleViewTask(task) {
      if (task && task.id) {
        this.$router.push({ name: 'tasks.show', params: { id: task.id } });
      } else {
        this.$toast.error('Erro: ID da tarefa não encontrado');
      }
    },
    handleEditTask(task) {
      if (task && task.id) {
        this.$router.push({ name: 'tasks.edit', params: { id: task.id } });
      } else {
        this.$toast.error('Erro: ID da tarefa não encontrado');
      }
    },
    handleDeleteTask(task) {
      this.taskToDelete = task;
      this.showDeleteModal = true;
    },
    closeDeleteModal() {
      this.showDeleteModal = false;
      this.taskToDelete = null;
    },
    async confirmDelete() {
      if (!this.taskToDelete) return;
      
      try {
        // Excluir tarefa via API
        await deleteTask(this.taskToDelete.id);
        
        this.$toast.success(`Tarefa "${this.taskToDelete.title}" excluída com sucesso!`);
        this.closeDeleteModal();
        
        // Recarregar as tarefas para manter paginação consistente
        await this.loadTasks();
      } catch (error) {
        console.error('Erro ao excluir tarefa:', error);
        this.$toast.error('Erro ao excluir tarefa. Tente novamente.');
      }
    },
    async handleToggleComplete(task) {
      try {
        if (task.status === 'concluída') {
          // Se já está concluída, volta para pendente usando update
          await updateTask(task.id, { status: 'pendente' });
          const taskIndex = this.tasks.findIndex(t => t.id === task.id);
          if (taskIndex !== -1) {
            this.tasks[taskIndex].status = 'pendente';
          }
          this.$toast.success(`Tarefa "${task.title}" marcada como pendente!`);
        } else {
          // Se está pendente, marca como concluída usando endpoint específico
          await completeTask(task.id);
          const taskIndex = this.tasks.findIndex(t => t.id === task.id);
          if (taskIndex !== -1) {
            this.tasks[taskIndex].status = 'concluída';
          }
          this.$toast.success(`Tarefa "${task.title}" marcada como concluída!`);
        }
      } catch (error) {
        console.error('Erro ao atualizar status da tarefa:', error);
        this.$toast.error('Erro ao atualizar tarefa. Tente novamente.');
      }
    },
    initFiltersFromUrl() {
      this.filters.status = this.$route.query.status || '';
      this.filters.priority = this.$route.query.priority || '';
    },
    async loadTasks() {
      this.loading = true;
      try {
        const params = {
          page: this.pagination.currentPage,
          per_page: this.pagination.itemsPerPage,
          ...this.filters
        };

        // Remove parâmetros vazios
        Object.keys(params).forEach(key => {
          if (params[key] === '' || params[key] === null || params[key] === undefined) {
            delete params[key];
          }
        });

        const response = await getTasks(params);
        const data = response.data.data;
        
        this.tasks = data.tasks;
        
        // Atualizar dados de paginação
        this.paginationData = {
          currentPage: parseInt(data.pagination.current_page),
          totalPages: parseInt(data.pagination.last_page),
          totalItems: parseInt(data.pagination.total),
          itemsPerPage: parseInt(data.pagination.per_page)
        };
      } catch (error) {
        console.error('Erro ao carregar tasks:', error);
      } finally {
        this.loading = false;
      }
    },
    handlePageChange(page) {
      this.updateUrl({ page });
    },
    updateUrl(newParams) {
      const currentQuery = { ...this.$route.query };
      const updatedQuery = { ...currentQuery, ...newParams };
      
      // Se mudou filtro (status ou priority), reset para página 1
      if (newParams.status !== undefined || newParams.priority !== undefined) {
        updatedQuery.page = 1;
      }
      
      // Remove parâmetros vazios
      Object.keys(updatedQuery).forEach(key => {
        if (updatedQuery[key] === '' || updatedQuery[key] === null || updatedQuery[key] === undefined) {
          delete updatedQuery[key];
        }
      });
      
      this.$router.push({ 
        name: 'tasks.index', 
        query: updatedQuery 
      });
    }
  },
  watch: {
    '$route.query': {
      handler() {
        this.initFiltersFromUrl();
        this.loadTasks();
      },
      immediate: true
    },
    'filters.status'(newStatus) {
      this.updateUrl({ status: newStatus });
    },
    'filters.priority'(newPriority) {
      this.updateUrl({ priority: newPriority });
    }
  }
};
</script>