<template>
  <span 
    class="px-2 lg:px-3 py-1 rounded-full text-xs font-medium"
    :class="badgeClass"
  >
    {{ text }}
  </span>
</template>

<script>
export default {
  name: 'UiBadge',
  props: {
    text: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required: true,
      validator: (value) => ['status', 'priority'].includes(value)
    },
    value: {
      type: String,
      required: true
    }
  },
  computed: {
    badgeClass() {
      if (this.type === 'status') {
        return this.getStatusClass(this.value);
      } else if (this.type === 'priority') {
        return this.getPriorityClass(this.value);
      }
      return 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
    }
  },
  methods: {
    getStatusClass(status) {
      const statusClasses = {
        'pendente': 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
        'em andamento': 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
        'concluída': 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'
      };
      
      return statusClasses[status] || 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
    },
    
    getPriorityClass(priority) {
      const priorityClasses = {
        'baixa': 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200',
        'média': 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
        'alta': 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
      };
      
      return priorityClasses[priority] || 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
    }
  }
}
</script>
