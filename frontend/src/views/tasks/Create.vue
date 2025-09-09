<template>
  <div class="max-w-2xl mx-auto p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Criar Nova Tarefa</h1>
      <p class="text-gray-600 dark:text-gray-400">Preencha os dados da sua nova tarefa</p>
    </div>

    <!-- Form -->
    <form @submit.prevent="create" class="space-y-6">
      <!-- Title -->
      <div>
        <Label for-id="title" :required="true">Título</Label>
        <Input
          id="title"
          v-model="form.title"
          type="text"
          placeholder="Digite o título da task"
          :has-error="errors.title"
        />
      </div>

      <!-- Description -->
      <div>
        <Label for-id="description">Descrição</Label>
        <textarea
          id="description"
          v-model="form.description"
          placeholder="Descreva a task (opcional)"
          :class="textareaClasses"
          rows="4"
        ></textarea>
      </div>

      <!-- Priority -->
      <div>
        <Label for-id="priority" :required="true">Prioridade</Label>
        <Select
          id="priority"
          v-model="form.priority"
          :has-error="errors.priority"
        >
          <option value="">Selecione a prioridade</option>
          <option value="baixa">Baixa</option>
          <option value="média">Média</option>
          <option value="alta">Alta</option>
        </Select>
      </div>

      <!-- Status -->
      <div>
        <Label for-id="status" :required="true">Status</Label>
        <Select
          id="status"
          v-model="form.status"
          :has-error="errors.status"
        >
          <option value="">Selecione o status</option>
          <option value="pendente">Pendente</option>
          <option value="em andamento">Em Andamento</option>
          <option value="concluída">Concluída</option>
        </Select>
      </div>

      <!-- Due Date -->
      <div>
        <Label for-id="due_date" :required="true">Data limite</Label>
        <Input
          id="due_date"
          v-model="form.due_date"
          type="date"
          :min="minDate"
          :has-error="errors.due_date"
        />
      </div>

      <div class="flex gap-4">
        <Button
          type="submit"
          variant="primary"
          size="md"
          :disabled="isSubmitting"
        >
          {{ isSubmitting ? 'Criando...' : 'Criar Tarefa' }}
        </Button>
        
        <Button
          type="button"
          variant="secondary"
          size="md"
          @click="$router.push({ name: 'tasks.index' })"
        >
          Cancelar
        </Button>
      </div>
    </form>
  </div>
</template>

<script>
import Button from '@/components/ui/Button.vue';
import Input from '@/components/ui/Input.vue';
import Label from '@/components/ui/Label.vue';
import Select from '@/components/ui/Select.vue';
import formValidationMixin from '@/mixins/formValidation.js';

import { createTask } from '@/api/task';

export default {
  name: "TasksCreate",
  mixins: [formValidationMixin],
  components: {
    Button,
    Input,
    Label,
    Select
  },
  data() {
    return {
      form: {
        title: '',
        description: '',
        priority: '',
        status: 'pendente',
        due_date: ''
      },
      errors: {
        title: false,
        description: false,
        priority: false,
        status: false,
        due_date: false
      },
      isSubmitting: false,
      minDate: new Date().toISOString().split('T')[0]
    }
  },
  computed: {
    textareaClasses() {
      const baseClasses = 'block w-full px-4 py-2.5 border rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-800 dark:text-white transition-colors resize-none';
      
      if (this.errors.description) {
        return `${baseClasses} border-red-500 dark:border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/20`;
      }
      
      return `${baseClasses} border-gray-300 dark:border-gray-600`;
    }
  },
  methods: {
    async create() {
      // Limpar erros anteriores
      this.clearErrors();
      
      try {
        this.isSubmitting = true;
        
        await createTask(this.form);
        this.$toast.success('Tarefa criada com sucesso!');
        this.$router.push({ name: 'tasks.index' });
      } catch (error) {
        this.handleValidationError(error, 'Erro ao criar tarefa. Tente novamente.');
      } finally {
        this.isSubmitting = false;
      }
    }
  },
  watch: {
    ...formValidationMixin.methods.createFieldWatchers(['title', 'description', 'priority', 'status', 'due_date'])
  },
};
</script>
  