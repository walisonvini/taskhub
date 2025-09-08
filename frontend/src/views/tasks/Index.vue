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
  </div>
</template>
  
<script>
import { getTasks } from '@/api/task';
import TaskCard from '@/components/TaskCard.vue';
import Button from '@/components/ui/Button.vue';
import Select from '@/components/ui/Select.vue';
import UiPagination from '@/components/Pagination.vue';

export default {
  name: "TasksIndex",
  components: {
    TaskCard,
    Button,
    Select,
    UiPagination
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
      }
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
    }
  },
  methods: {
    createTask() {
      this.$router.push({ name: 'tasks.create' });
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