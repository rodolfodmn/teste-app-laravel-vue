<template>
  <div class="card" :class="{ done: task.status === 'done' }">
    <h3 class="task-title">{{ task.title }}</h3>
    <p class="task-desc" v-if="task.description">{{ task.description }}</p>
    <p class="task-status">
      Status:
      <span :class="task.status === 'done' ? 'done-text' : 'pending-text'">
        {{ task.status === 'done' ? 'Concluída' : 'Pendente' }}
      </span>
    </p>
    <button
      v-if="task.status !== 'done'"
      @click="$emit('mark-done', task.id)"
      class="done-button"
    >
      Marcar como concluída
    </button>
  </div>
</template>

<script setup>
defineProps({
  task: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
.card {
  background-color: #fff;
  border: 1px solid #ddd;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.card.done {
  background-color: #f0fdf4;
  border-color: #c6f6d5;
}

.task-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.task-desc {
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 0.5rem;
}

.task-status {
  font-size: 0.9rem;
  margin-bottom: 0.8rem;
}

.done-text {
  color: #38a169;
  font-weight: 500;
}

.pending-text {
  color: #e53e3e;
  font-weight: 500;
}

.done-button {
  padding: 0.5rem 1rem;
  background-color: #38a169;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.9rem;
}

.done-button:hover {
  background-color: #2f855a;
}
</style>
