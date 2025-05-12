import { createRouter, createWebHistory } from 'vue-router'
import TaskListView from '../views/TaskList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: TaskListView,
    },
  ],
})

export default router
