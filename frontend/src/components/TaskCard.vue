<template>
  <div 
    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5"
  >
    <!-- Desktop Layout -->
    <div class="hidden sm:flex items-center justify-between">
      <!-- Left: Checkbox + Title -->
      <div class="flex items-center space-x-3 flex-1 min-w-0">
        <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition-colors flex-shrink-0"></div>
        <h3 class="text-gray-800 dark:text-white font-medium truncate">{{ task.title }}</h3>
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
        <button class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Layout -->
    <div class="sm:hidden">
      <!-- Top Row: Checkbox + Title + Menu -->
      <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-3 flex-1 min-w-0">
          <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition-colors flex-shrink-0"></div>
          <h3 class="text-gray-800 dark:text-white font-medium truncate">{{ task.title }}</h3>
        </div>
        <button class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors flex-shrink-0">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
          </svg>
        </button>
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
  methods: {
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('pt-BR');
    }
  }
}
</script>
