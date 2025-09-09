<template>
  <div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
        Exportações de Tarefas
      </h1>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
      <span class="ml-3 text-gray-600 dark:text-gray-400">Carregando...</span>
    </div>

    <!-- Empty State -->
    <div v-else-if="exports.length === 0" class="text-center py-12">
      <div class="text-gray-500 dark:text-gray-400">
        <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-lg">Nenhuma arquivo encontrado</p>
        <p class="text-sm mt-1">Crie sua primeira arquivo para começar</p>
      </div>
    </div>

    <!-- Exports Table -->
    <div v-else class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Criado em
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Arquivo
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Erro
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Ações
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr 
              v-for="exportItem in exports" 
              :key="exportItem.id"
              class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              
              <!-- Status -->
              <td class="px-6 py-4 whitespace-nowrap">
                <UiBadge 
                  :text="exportItem.status" 
                  type="status" 
                  :value="exportItem.status"
                />
              </td>
              
              <!-- Data de Criação -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                {{ formatDate(exportItem.created_at) }}
              </td>
              
              <!-- Arquivo -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                <span v-if="exportItem.filename" class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                  {{ exportItem.filename }}
                </span>
                <span v-else class="text-gray-400 dark:text-gray-500">-</span>
              </td>
              
              <!-- Erro -->
              <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                <div v-if="exportItem.error_message" class="max-w-xs">
                  <p class="text-red-600 dark:text-red-400 text-xs bg-red-50 dark:bg-red-900/20 p-2 rounded truncate" :title="exportItem.error_message">
                    {{ exportItem.error_message }}
                  </p>
                </div>
                <span v-else class="text-gray-400 dark:text-gray-500">-</span>
              </td>
              
              <!-- Ações -->
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <UiButton 
                  v-if="exportItem.status === 'concluído' && exportItem.file_path"
                  variant="primary"
                  size="sm"
                  @click="downloadExport(exportItem.id)"
                >
                  Download
                </UiButton>
                <span v-else class="text-gray-400 dark:text-gray-500">-</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { getTaskExports, downloadTaskExport } from '@/api/task-export'
import UiButton from '@/components/ui/Button.vue'
import UiBadge from '@/components/ui/Badge.vue'

export default {
  name: 'TaskExportsIndex',
  components: {
    UiButton,
    UiBadge
  },
  data() {
    return {
      exports: [],
      loading: true
    }
  },
  async mounted() {
    await this.loadExports()
  },
  methods: {
    async loadExports() {
      try {
        this.loading = true
        const { data } = await getTaskExports()
        this.exports = data.data.exports
      } catch (error) {
        this.$toast.error('Erro ao carregar exportações')
      } finally {
        this.loading = false
      }
    },

    async downloadExport(exportId) {
      try {
        const { data } = await downloadTaskExport(exportId)
        
        const url = window.URL.createObjectURL(new Blob([data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', `export-${exportId}.csv`)
        document.body.appendChild(link)
        link.click()
        link.remove()
        window.URL.revokeObjectURL(url)
      } catch (error) {
        console.error('Erro ao baixar arquivo:', error)
        this.$toast.error('Erro ao baixar arquivo')
      }
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleString('pt-BR')
    }
  }
}
</script>