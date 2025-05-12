<template>
  <div class="task-card">
    <h3>{{ task.title }}</h3>
    <p>{{ task.description }}</p>
    <p>Status: {{ task.status }}</p>
    <button v-if="task.status !== 'done'" @click="$emit('mark-done', task.id)">
      Marcar como feita
    </button>
  </div>
</template>

<script setup>
defineProps({
  task: Object
})
</script>
