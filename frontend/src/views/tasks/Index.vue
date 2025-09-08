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
            v-model="filters.status"
            label="Status"
          >
            <option value="">Todos os status</option>
            <option value="pendente">Pendente</option>
            <option value="em andamento">Em Andamento</option>
            <option value="concluída">Concluída</option>
          </Select>
          
          <Select
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
    
    <div class="space-y-3">
      <TaskCard 
        v-for="task in tasks" 
        :key="task.id"
        :task="task"
      />
    </div>
  </div>
</template>
  
<script>
import { getTasks } from '@/api/task';
import TaskCard from '@/components/TaskCard.vue';
import Button from '@/components/ui/Button.vue';
import Select from '@/components/ui/Select.vue';

export default {
  name: "TasksIndex",
  components: {
    TaskCard,
    Button,
    Select
  },
  data() {
    return {
      tasks: [],
      filters: {
        status: '',
        priority: ''
      }
    }
  },
  methods: {
    createTask() {
      this.$router.push({ name: 'tasks.create' });
    }
  },
  mounted() {
    getTasks().then(response => {
      this.tasks = response.data.data.tasks;
    });
  }
};
</script>