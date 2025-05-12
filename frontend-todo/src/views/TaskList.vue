<template>
  <div>
    <form @submit.prevent="addTask">
      <input v-model="title" placeholder="Título" required />
      <input v-model="description" placeholder="Descrição" />
      <button type="submit">Adicionar</button>
    </form>

    <div>
      <label>Status:</label>
      <select v-model="statusFilter">
        <option value="">Todos</option>
        <option value="pending">Pendentes</option>
        <option value="done">Concluídas</option>
      </select>
    </div>

    <TaskCard
      v-for="task in filteredTasks"
      :key="task.id"
      :task="task"
      @mark-done="markAsDone"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import TaskCard from '../components/TaskCard.vue'
import api from '../services/api'

const tasks = ref([])
const title = ref('')
const description = ref('')
const statusFilter = ref('')

const fetchTasks = async () => {
  const res = await api.get('/tasks', {
    params: statusFilter.value ? { status: statusFilter.value } : {}
  })
  tasks.value = res.data
}

const addTask = async () => {
  await api.post('/tasks', {
    title: title.value,
    description: description.value,
    status: 'pending',
  })
  title.value = ''
  description.value = ''
  await fetchTasks()
}

const markAsDone = async (taskId) => {
  await api.put(`/tasks/${taskId}`, { status: 'done' })
  await fetchTasks()
}

const filteredTasks = computed(() => tasks.value)

onMounted(fetchTasks)
</script>
