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

<style scoped>
.container {
    width: 720px;
    max-width: 100%; /* Garantir que não haja limitação de largura */
    margin: 0 auto; /* Centraliza o conteúdo */
}

.title {
  font-size: 1.2rem;
  margin-bottom: 1rem;
}

.form {
  background: #f9f9f9;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 2rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.input {
  display: block;
  width: 100%;
  padding: 0.6rem;
  margin-bottom: 1rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.button {
  background-color: #007bff;
  color: white;
  padding: 0.6rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button:hover {
  background-color: #0056b3;
}

.filter {
  margin-bottom: 1rem;
}

.select {
  padding: 0.5rem;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.task-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
</style>
