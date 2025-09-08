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
          <svg v-if="task.status === 'concluída'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
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
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-sm hidden lg:inline">{{ formatDate(task.due_date) }}</span>
        </div>
        
        <!-- Menu -->
        <div class="relative">
          <button 
            @click.stop="toggleMenu"
            class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
            </svg>
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
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Visualizar
              </button>
              
              <button 
                @click="editTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
              </button>
              
              <hr class="my-1 border-gray-200 dark:border-gray-700">
              
              <button 
                @click="deleteTask"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
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
            <svg v-if="task.status === 'concluída'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <h3 class="text-gray-800 dark:text-white font-medium truncate" :class="{ 'line-through opacity-60': task.status === 'concluída' }">{{ task.title }}</h3>
        </div>
        <div class="relative flex-shrink-0">
          <button 
            @click.stop="toggleMenu"
            class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
            </svg>
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
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Visualizar
              </button>
              
              <button 
                @click="editTask"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
              </button>
              
              <hr class="my-1 border-gray-200 dark:border-gray-700">
              
              <button 
                @click="deleteTask"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
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
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-sm">{{ formatDate(task.due_date) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Badge from '@/components/ui/Badge.vue';

export default {
  name: 'TaskCard',
  components: {
    Badge
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
