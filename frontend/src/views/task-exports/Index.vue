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
      <div class="text-gray-500 dark:text-gray-400">Carregando...</div>
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

    <GenericTable :columns="columns" :items="exports">
      <template #status="{ item }">
        <UiBadge :text="item.status" type="status" :value="item.status" />
      </template>

      <template #created_at="{ item }">
        {{ formatDate(item.created_at) }}
      </template>

      <template #filename="{ item }">
        <span v-if="item.filename" class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
          {{ item.filename }}
        </span>
        <span v-else class="text-gray-400 dark:text-gray-500">-</span>
      </template>

      <template #error_message="{ item }">
        <div v-if="item.error_message" class="max-w-xs">
          <p class="text-red-600 dark:text-red-400 text-xs bg-red-50 dark:bg-red-900/20 p-2 rounded truncate" :title="item.error_message">
            {{ item.error_message }}
          </p>
        </div>
        <span v-else class="text-gray-400 dark:text-gray-500">-</span>
      </template>

      <template #actions="{ item }">
        <UiButton v-if="item.status === 'concluído' && item.file_path" variant="primary" size="sm" @click="downloadExport(item.id)">
          Download
        </UiButton>
        <span v-else class="text-gray-400 dark:text-gray-500">-</span>
      </template>
    </GenericTable>
  </div>
</template>

<script>
import { getTaskExports, downloadTaskExport } from '@/api/task-export'
import UiButton from '@/components/ui/Button.vue'
import UiBadge from '@/components/ui/Badge.vue'
import GenericTable from '@/components/GenericTable.vue'

export default {
  name: 'TaskExportsIndex',
  components: {
    UiButton,
    UiBadge,
    GenericTable
  },
  data() {
    return {
      exports: [],
      loading: true,
      columns: [
        { key: 'status', label: 'Status' },
        { key: 'created_at', label: 'Criado em' },
        { key: 'filename', label: 'Arquivo' },
        { key: 'error_message', label: 'Erro' },
        { key: 'actions', label: 'Ações', class: 'text-right' }
      ]
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