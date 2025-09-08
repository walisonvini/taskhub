<template>
  <div 
    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow duration-200"
  >
    <!-- Desktop Layout -->
    <div class="hidden sm:flex items-center justify-between">
      <!-- Left: Checkbox + Title -->
      <div class="flex items-center space-x-3 flex-1 min-w-0">
        <div 
          @click="toggleComplete"
          class="w-5 h-5 rounded-full border-2 cursor-pointer transition-colors flex-shrink-0 flex items-center justify-center"
          :class="task.status === 'concluída' 
            ? 'bg-primary border-primary text-white' 
            : 'border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500'"
        >
          <Icon v-if="task.status === 'concluída'" icon="mdi:check" class="w-3 h-3" />
        </div>
        <h3 class="text-gray-800 dark:text-white font-medium truncate" :class="{ 'line-through opacity-60': task.status === 'concluída' }">{{ task.title }}</h3>
      </div>
      
      <!-- Right: Priority + Status + Date + Menu -->
      <div class="flex items-center space-x-2 lg:space-x-3 flex-shrink-0">
        <!-- Priority -->
        <Badge 
          v-if="task.priority" 
          :text="task.priority"
          type="priority"
          :value="task.priority"
        />
        
        <!-- Status -->
        <Badge 
          v-if="task.status" 
          :text="task.status"
          type="status"
          :value="task.status"
        />
        
        <!-- Date with Clock Icon -->
        <div v-if="task.due_date" class="flex items-center space-x-1 text-gray-500 dark:text-gray-400">
          <Icon icon="mdi:clock-outline" class="w-4 h-4" />
          <span class="text-sm hidden lg:inline">{{ formatDate(task.due_date) }}</span>
        </div>
        
        <!-- Menu -->
        <div class="relative">
          <button 
            @click.stop="toggleMenu"
            class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
          >
            <Icon icon="mdi:dots-vertical" class="w-5 h-5" />
          </button>
          
          <!-- Dropdown Menu -->
          <div 
            v-if="showMenu"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-50"
          >
            <div class="py-1">
              <button 
                @click="viewTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <Icon icon="mdi:eye" class="w-4 h-4 mr-3" />
                Visualizar
              </button>
              
              <button 
                @click="editTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <Icon icon="mdi:pencil" class="w-4 h-4 mr-3" />
                Editar
              </button>
              
              <hr class="my-1 border-gray-200 dark:border-gray-700">
              
              <button 
                @click="deleteTask"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
              >
                <Icon icon="mdi:delete" class="w-4 h-4 mr-3" />
                Excluir
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Layout -->
    <div class="sm:hidden">
      <!-- Top Row: Checkbox + Title + Menu -->
      <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-3 flex-1 min-w-0">
          <div 
            @click="toggleComplete"
            class="w-5 h-5 rounded-full border-2 cursor-pointer transition-colors flex-shrink-0 flex items-center justify-center"
            :class="task.status === 'concluída' 
              ? 'bg-primary border-primary text-white' 
              : 'border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500'"
          >
            <Icon v-if="task.status === 'concluída'" icon="mdi:check" class="w-3 h-3" />
          </div>
          <h3 class="text-gray-800 dark:text-white font-medium truncate" :class="{ 'line-through opacity-60': task.status === 'concluída' }">{{ task.title }}</h3>
        </div>
        <div class="relative flex-shrink-0">
          <button 
            @click.stop="toggleMenu"
            class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
          >
            <Icon icon="mdi:dots-vertical" class="w-5 h-5" />
          </button>
          
          <!-- Dropdown Menu Mobile -->
          <div 
            v-if="showMenu"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-50"
          >
            <div class="py-1">
              <button 
                @click="viewTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <Icon icon="mdi:eye" class="w-4 h-4 mr-3" />
                Visualizar
              </button>
              
              <button 
                @click="editTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <Icon icon="mdi:pencil" class="w-4 h-4 mr-3" />
                Editar
              </button>
              
              <hr class="my-1 border-gray-200 dark:border-gray-700">
              
              <button 
                @click="deleteTask"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
              >
                <Icon icon="mdi:delete" class="w-4 h-4 mr-3" />
                Excluir
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bottom Row: Tags + Date -->
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <!-- Priority -->
          <Badge 
            v-if="task.priority" 
            :text="task.priority"
            type="priority"
            :value="task.priority"
          />
          
          <!-- Status -->
          <Badge 
            v-if="task.status" 
            :text="task.status"
            type="status"
            :value="task.status"
          />
        </div>
        
        <!-- Date with Clock Icon -->
        <div v-if="task.due_date" class="flex items-center space-x-1 text-gray-500 dark:text-gray-400">
          <Icon icon="mdi:clock-outline" class="w-4 h-4" />
          <span class="text-sm">{{ formatDate(task.due_date) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Badge from '@/components/ui/Badge.vue';
import { Icon } from '@iconify/vue2';

export default {
  name: 'TaskCard',
  components: {
    Badge,
    Icon
  },
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      showMenu: false
    }
  },
  methods: {
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('pt-BR');
    },
    toggleMenu() {
      // Emitir evento para fechar outros menus
      this.$root.$emit('close-other-menus', this._uid);
      this.showMenu = !this.showMenu;
    },
    viewTask() {
      this.showMenu = false;
      this.$emit('view', this.task);
    },
    editTask() {
      this.showMenu = false;
      this.$emit('edit', this.task);
    },
    deleteTask() {
      this.showMenu = false;
      this.$emit('delete', this.task);
    },
    toggleComplete() {
      this.$emit('toggle-complete', this.task);
    }
  },
  mounted() {
    // Fechar menu ao clicar fora
    document.addEventListener('click', (e) => {
      if (!this.$el.contains(e.target)) {
        this.showMenu = false;
      }
    });
    
    // Escutar evento para fechar menu quando outro for aberto
    this.$root.$on('close-other-menus', (excludeId) => {
      if (this._uid !== excludeId) {
        this.showMenu = false;
      }
    });
  },
  beforeDestroy() {
    // Remover listener do evento
    this.$root.$off('close-other-menus');
  }
}
</script>
