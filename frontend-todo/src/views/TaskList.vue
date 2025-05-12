<template>
  <div class="container">
    <form @submit.prevent="addTask" class="form">
      <h2 class="title">Nova Tarefa</h2>
      <input
        v-model="title"
        type="text"
        placeholder="Título"
        required
        class="input"
      />
      <input
        v-model="description"
        type="text"
        placeholder="Descrição"
        class="input"
      />
      <button type="submit" class="button">Adicionar</button>
    </form>

    <div class="filter">
      <label>Status:</label>
      <select v-model="statusFilter" @change="fetchTasks" class="select">
        <option value="">Todos</option>
        <option value="pending">Pendentes</option>
        <option value="done">Concluídas</option>
      </select>
    </div>

    <div class="task-list">
      <TaskCard
        v-for="task in filteredTasks"
        :key="task.id"
        :task="task"
        @mark-done="markAsDone"
      />
    </div>
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

