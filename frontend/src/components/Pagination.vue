<template>
  <div class="flex items-center justify-between">
    <!-- Info -->
    <div class="text-sm text-gray-700 dark:text-gray-300">
      Mostrando <span class="font-medium">{{ startItem }}</span> a <span class="font-medium">{{ endItem }}</span> de <span class="font-medium">{{ totalItems }}</span> tarefas
    </div>

    <!-- Pagination Controls -->
    <div class="flex items-center space-x-2">
      <!-- Previous Button -->
      <button 
        class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        :disabled="currentPage === 1"
        @click="$emit('page-change', currentPage - 1)"
      >
        Anterior
      </button>

      <!-- Page Numbers -->
      <div class="flex items-center space-x-1">
        <button 
          v-for="page in visiblePages"
          :key="page"
          class="px-3 py-2 text-sm font-medium rounded-md transition-colors"
          :class="page === currentPage 
            ? 'text-white bg-primary border border-primary cursor-default' 
            : 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'"
          :disabled="page === currentPage"
          @click="page !== currentPage && $emit('page-change', page)"
        >
          {{ page }}
        </button>
        
        <!-- Ellipsis -->
        <span v-if="showEllipsis" class="px-2 text-gray-500 dark:text-gray-400">...</span>
        
        <!-- Last Page -->
        <button 
          v-if="totalPages > 4 && currentPage < totalPages - 2 && !visiblePages.includes(totalPages)"
          class="px-3 py-2 text-sm font-medium rounded-md transition-colors"
          :class="totalPages === currentPage 
            ? 'text-white bg-primary border border-primary cursor-default' 
            : 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'"
          :disabled="totalPages === currentPage"
          @click="totalPages !== currentPage && $emit('page-change', totalPages)"
        >
          {{ totalPages }}
        </button>
      </div>

      <!-- Next Button -->
      <button 
        class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        :disabled="currentPage === totalPages"
        @click="$emit('page-change', currentPage + 1)"
      >
        Próximo
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UiPagination',
  props: {
    currentPage: {
      type: Number,
      default: 1
    },
    totalPages: {
      type: Number,
      default: 1
    },
    totalItems: {
      type: Number,
      default: 0
    },
    itemsPerPage: {
      type: Number,
      default: 10
    }
  },
  emits: ['page-change'],
  computed: {
    startItem() {
      return ((this.currentPage - 1) * this.itemsPerPage) + 1;
    },
    endItem() {
      const end = this.currentPage * this.itemsPerPage;
      return Math.min(end, this.totalItems);
    },
    visiblePages() {
      const pages = [];
      const maxVisible = 3;
      
      if (this.totalPages <= maxVisible) {
        // Se tem 3 ou menos páginas, mostra todas
        for (let i = 1; i <= this.totalPages; i++) {
          pages.push(i);
        }
      } else {
        // Se está nas primeiras páginas (1 ou 2)
        if (this.currentPage <= 2) {
          for (let i = 1; i <= maxVisible; i++) {
            pages.push(i);
          }
        }
        // Se está nas últimas páginas
        else if (this.currentPage >= this.totalPages - 1) {
          for (let i = this.totalPages - maxVisible + 1; i <= this.totalPages; i++) {
            pages.push(i);
          }
        }
        // Se está no meio
        else {
          for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
            pages.push(i);
          }
        }
      }
      
      return pages;
    },
    showEllipsis() {
      return this.totalPages > 4 && this.currentPage < this.totalPages - 2;
    }
  }
}
</script>
